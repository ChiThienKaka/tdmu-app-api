<?php
namespace App\Features\Domain\ChatBox\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Features\Domain\ChatBox\Services\AI\EmbeddingService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use App\Features\Domain\ChatBox\Repositories\MessageChatboxRepository;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use Illuminate\Support\Collection;

class ChatBoxController extends Controller {
    public function __construct(private EmbeddingService $embedding_service, 
    private MessageChatboxRepository $message_chatbox_repository)
    {
        
    }
    public function debugSearch(FormRequest $request)
    {
        $user = auth('api')->user();
        $query = $request->input('question');

        // 1. LUÔN lưu user trước (quan trọng)
        $this->message_chatbox_repository->create($user, 'user', $query);

        // ===== VECTOR SEARCH =====
        $queryVector = $this->embedding_service->embedSmart($query);
        $vectorString = '[' . implode(',', $queryVector) . ']';

        $context = DB::select("
            SELECT source_table, source_id, content,
                embedding <=> ?::vector AS distance
            FROM embeddings
            ORDER BY embedding <=> ?::vector
            LIMIT 5
        ", [$vectorString, $vectorString]);

        [$jobIds, $jobs] = $this->extractSuggestedJobsFromContext($context);

        $contextText = collect($context)
            ->map(fn ($row) => "- " . $row->content)
            ->implode("\n");

        // $apiKey = config('services.gemini.api_key');
        $apiKey = config('services.groq.api_key_groq');

        $prompt = "
        Bạn là AI đa năng: vừa là chuyên gia tuyển dụng, vừa là trợ lý.

        Hãy làm theo quy trình:
        1. Xác định câu hỏi có liên quan đến tuyển dụng hay không.
        2. Nếu có:
        - Dùng CONTEXT nếu phù hợp.
        3. Nếu không:
        - Trả lời như trợ lý thông minh bằng kiến thức chung.

        Luôn:
        - Không bịa dữ liệu từ CONTEXT
        - Trả lời rõ ràng, tự nhiên

        CONTEXT:
        $contextText

        Hãy trả lời câu hỏi:
        $query
        ";

        // ===== CALL AI (SAFE) =====
        // try {
        //     $response = Http::timeout(15)
        //         ->retry(2, 2000)
        //         ->withHeaders([
        //             'x-goog-api-key' => $apiKey,
        //             'Content-Type' => 'application/json',
        //         ])
        //         ->post(
        //             "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent",
        //             [
        //                 "contents" => [
        //                     [
        //                         "parts" => [
        //                             ["text" => $prompt]
        //                         ]
        //                     ]
        //                 ]
        //             ]
        //         );

        //     if (!$response->successful()) {
        //         $text = "Máy chủ AI đang quá tải, vui lòng thử lại sau!";
        //     } else {
        //         $text = $response->json('candidates.0.content.parts.0.text')
        //             ?? "Không nhận được phản hồi hợp lệ từ AI.";
        //     }

        // } catch (\Throwable $e) {
        //     // bắt mọi lỗi (timeout, 503, network...)
        //     $text = "Hệ thống đang gặp sự cố, vui lòng thử lại sau.";
        // }

        // ===== CALL AI (SAFE) GROQ =====
        try {
            $response = Http::timeout(15)
                ->retry(2, 2000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post(
                    "https://api.groq.com/openai/v1/chat/completions",
                    [
                        "model" => "llama-3.3-70b-versatile",
                        "messages" => [
                            [
                                "role" => "user",
                                "content" => $prompt
                            ]
                        ],
                        "temperature" => 1,
                        "max_tokens" => 1024,
                        "top_p" => 1,
                        "stream" => false
                    ]
                );

            if (!$response->successful()) {
                $text = "Máy chủ AI đang quá tải, vui lòng thử lại sau!";
            } else {
                $text = $response->json('choices.0.message.content')
                    ?? "Không nhận được phản hồi hợp lệ từ AI.";
            }

        } catch (\Throwable $e) {
            // bắt mọi lỗi (timeout, 503, network...)
            $text = "Hệ thống đang gặp sự cố, vui lòng thử lại sau.";
        }


        // đảm bảo luôn là string (tránh null crash DB)
        $text = (string) $text;

        // ===== LƯU ASSISTANT =====
        $this->message_chatbox_repository->create(
            $user,
            'assistant',
            $text,
            $jobIds ?? [],
            $jobs ?? []
        );

        // ===== RESPONSE =====
        return response()->json([
            'answer'  => $text,
            'job_ids' => $jobIds ?? [],
            'jobs'    => $jobs ?? [],
        ], 200);
    }

    public function getgetRecentMessages(){
        $user = auth('api')->user();
        $data = $this->message_chatbox_repository->getRecentMessages($user);
        return response()->json($data,200);
    }

    private function extractSuggestedJobsFromContext(array $context): array
    {
        $jobIds = collect($context)
            ->filter(fn($row) => ($row->source_table ?? null) === 'job_posts')
            ->pluck('source_id')
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        if ($jobIds->isEmpty()) {
            return [[], []];
        }

        $jobs = JobPostModel::query()
            ->whereIn('job_id', $jobIds->all())
            ->get([
                'job_id',
                'job_title',
                'company_id',
                'location_province',
                'salary_min',
                'salary_max',
                'application_deadline',
            ])
            ->keyBy('job_id');

        $orderedJobs = $jobIds
            ->map(function ($jobId) use ($jobs) {
                $job = $jobs->get($jobId);
                if (!$job) {
                    return null;
                }

                return [
                    'job_id' => $job->job_id,
                    'job_title' => $job->job_title,
                    'company_id' => $job->company_id,
                    'location_province' => $job->location_province,
                    'salary_min' => $job->salary_min,
                    'salary_max' => $job->salary_max,
                    'application_deadline' => $job->application_deadline,
                ];
            })
            ->filter()
            ->values();

        return [$jobIds->all(), $orderedJobs->all()];
    }
}