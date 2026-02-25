<?php

namespace App\Features\Domain\ChatBox\Services\AI;

use App\Features\Domain\ChatBox\Models\EmbeddingModel;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use Illuminate\Support\Facades\DB;

class JobEmbeddingService
{
    public function __construct(
        protected DocumentBuilder $documentBuilder,
        protected SmartChunkService $chunkService,
        protected EmbeddingService $embeddingService
    ) {}

    public function generate(JobPostModel $job): void
    {
        DB::transaction(function () use ($job) {

            // 1️⃣ Build document
            $document = $this->documentBuilder->buildJob($job);

            // 2️⃣ Chunk
            $chunks = $this->chunkService->split($document, 'job');

            foreach ($chunks as $chunk) {

                // 3️⃣ Hash để tránh duplicate
                $hash = hash('sha256', $chunk);

                $exists = EmbeddingModel::where('content_hash', $hash)->exists();

                if ($exists) {
                    continue;
                }

                // 4️⃣ Embed
                $vector = $this->embeddingService->embedSmart($chunk);

                // 5️⃣ Save
                EmbeddingModel::create([
                    'source_table' => 'job_posts',
                    'source_id'    => $job->job_id,
                    'content'      => $chunk,
                    'content_hash' => $hash,
                    'embedding'    => $vector,
                ]);
            }
        });
    }
}