<?php
namespace App\Features\Domain\ChatBox\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Features\Domain\ChatBox\Services\AI\EmbeddingService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use App\Features\Domain\ChatBox\Repositories\MessageChatboxRepository;

class ChatBoxController extends Controller {
    public function __construct(private EmbeddingService $embedding_service, 
    private MessageChatboxRepository $message_chatbox_repository)
    {
        
    }
    public function debugSearch(FormRequest $request)
    {
        $user = auth('api')->user();
        $query = $request->input('question');

        $queryVector = $this->embedding_service->embedSmart($query);

        $vectorString = '[' . implode(',', $queryVector) . ']';

        $context = DB::select("
            SELECT source_table, source_id, content,
                embedding <=> ?::vector AS distance
            FROM embeddings
            ORDER BY embedding <=> ?::vector
            LIMIT 5
        ", [$vectorString, $vectorString]);
        //format dữ liệu mảng sang chuỗi
        $contextText = collect($context)
        ->map(function ($row) {
            return "- " . $row->content;
        })
        ->implode("\n");

        $apiKey = config('services.gemini.api_key');

        $prompt = "
        Bạn là chatbot tuyển dụng.

        Dựa trên dữ liệu sau:
        $contextText

        Hãy trả lời câu hỏi:
        $query

        Không được bịa thêm thông tin.
        ";

        $response = Http::timeout(15) // tối đa 15 giây / retry 2 lần, mỗi lần cách 2 giây
        ->retry(2, 2000)->withHeaders([
            'x-goog-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent",
            [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ]
                ]
            ]
        );
        if (!$response->successful()) {
            return response()->json([
                'error' => $response->body()
            ], 500);
        }

        $text = $response->json('candidates.0.content.parts.0.text');
        
        // lưu lại lịch sử đoạn chat
        $this->message_chatbox_repository->create($user, 'user', $query);
        $this->message_chatbox_repository->create($user, 'assistant', $text);

        return response()->json([
            'answer' => $text
        ],200);
    }
}