<?php

namespace App\Features\Domain\ChatBox\Database\Seeders;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Features\Domain\ChatBox\Services\AI\DocumentBuilder;
use App\Features\Domain\ChatBox\Services\AI\EmbeddingService;
use App\Features\Domain\ChatBox\Models\EmbeddingModel;
use Illuminate\Database\Seeder;
class EmbeddingDataSeeder extends Seeder
{
    public function __construct(private EmbeddingService $embedding_service, 
    private DocumentBuilder $document_builder)
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobposts = JobPostModel::select('job_posts.*'
                    ,'rc.company_name', 'rc.company_url'
                )
                ->join('recruiter_subscriptions as rs', 'rs.subscription_id', '=', 'job_posts.subscription_id')
                ->join('recruiter_packages as rp', 'rp.package_id', '=', 'rs.package_id')
                ->join('recruiter_companies as rc', 'rc.company_id', '=', 'rs.company_id')
                ->where('job_posts.status', 'approved')
                ->where('rs.status', 'active')
                ->whereDate('rs.end_date', '>=', now()->startOfDay())// ép về ngày để dễ so sánh gói còn hạn
                ->whereDate('job_posts.application_deadline','>=',now()->startOfDay())// ngày hết hạn tuyển dụng
                ->orderByRaw("
                    CASE 
                        WHEN rp.support_priority = 'vip' THEN 1
                        WHEN rp.support_priority = 'priority' THEN 2
                        ELSE 3
                    END
                ")
                ->orderByDesc('job_posts.priority_level')// bảng ưu tiên của từng bày post
                ->orderByDesc('job_posts.published_at') //ngày công khai tin tuyển dụng
                ->get();
        foreach($jobposts as $jobpost){
            //Hash để tránh duplicate
            $input = $this->document_builder->buildJob($jobpost);
            $hash = hash('sha256', $input);
            $exists = EmbeddingModel::where('content_hash', $hash)->exists();
            if ($exists) {
                continue;
            }
            $vector = $this->embedding_service->embedSmart($input);
            EmbeddingModel::create([
                'source_table' => 'job_posts',
                'source_id'    => $jobpost->job_id,
                'content'      => $input,
                'content_hash' => $hash,
                'embedding'    => $vector,
            ]);
        }
        
    }
}
