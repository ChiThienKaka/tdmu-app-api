<?php

namespace App\Features\Domain\ChatBox\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmbeddingService
{
    public function embedSmart(array|string $input): array
    {
        $isSingle = !is_array($input);

        $texts = $isSingle ? [$input] : $input;

        // Normalize
        $texts = array_map(fn ($text) =>
            trim(preg_replace('/\s+/', ' ', $text)),
            $texts
        );

        $response = Http::timeout(60)
            ->retry(3, 500)
            ->post(config('services.embedding.url') . '/embed', [
                'texts' => $texts
            ]);

        if (!$response->successful()) {
            Log::error('Embedding API failed', [
                'status' => $response->status(),
                'body'   => $response->body()
            ]);

            throw new \RuntimeException('Embedding API failed');
        }

        $embeddings = $response->json('embeddings');

        if (!is_array($embeddings)) {
            throw new \RuntimeException('Invalid embedding response structure');
        }

        return $isSingle ? $embeddings[0] : $embeddings;
    } 
    public function embed(string $text): array
    {
        // Chuẩn hóa giống bên Python
        $text = trim(preg_replace('/\s+/', ' ', $text));

        $response = Http::timeout(30)
            ->retry(3, 500)
            ->post(config('services.embedding.url') . '/embed', [
                'texts' => [$text]   // phải là texts (array)
            ]);

        if (!$response->successful()) {
            Log::error('Embedding API error', [
                'status' => $response->status(),
                'body'   => $response->body()
            ]);

            throw new \RuntimeException('Embedding API failed');
        }

        $data = $response->json();

        if (!isset($data['embeddings'][0])) {
            Log::error('Invalid embedding response', [
                'response' => $data
            ]);

            throw new \RuntimeException('Invalid embedding response structure');
        }

        return $data['embeddings'][0]; // lấy vector đầu tiên
    }
    public function embedBatch(array $texts): array
    {
        $response = Http::timeout(60)
            ->retry(3, 500)
            ->post(config('services.embedding.url') . '/embed', [
                'texts' => $texts
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException('Embedding API failed');
        }

        return $response->json('embeddings');
    }
}