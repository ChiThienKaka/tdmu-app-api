<?php

namespace App\Features\Domain\ChatBox\Services\AI;

class SmartTokenChunkService
{
    public function split(string $text): array
    {
        $text = $this->normalize($text);

        $length = mb_strlen($text);

        $config = $this->dynamicConfig($length);

        return $this->chunkByTokens(
            $text,
            $config['tokens'],
            $config['overlap']
        );
    }

    protected function chunkByTokens(string $text, int $maxTokens, int $overlapTokens): array
    {
        $approxCharPerToken = 4;

        $size = $maxTokens * $approxCharPerToken;
        $overlap = $overlapTokens * $approxCharPerToken;

        $chunks = [];
        $length = mb_strlen($text);

        for ($i = 0; $i < $length; $i += ($size - $overlap)) {
            $chunks[] = mb_substr($text, $i, $size);
        }

        return array_filter($chunks);
    }

    protected function dynamicConfig(int $length): array
    {
        if ($length < 2000) {
            return ['tokens' => 300, 'overlap' => 50];
        }

        if ($length < 5000) {
            return ['tokens' => 500, 'overlap' => 100];
        }

        return ['tokens' => 800, 'overlap' => 150];
    }

    protected function normalize(string $text): string
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}