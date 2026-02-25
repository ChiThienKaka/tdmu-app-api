<?php

namespace App\Features\Domain\ChatBox\Services\AI;

class SmartChunkService
{
    public function split(string $text, string $type = 'default'): array
    {
        $config = $this->getConfig($type);

        $text = $this->normalize($text);

        // 1️⃣ Tách theo paragraph trước
        $paragraphs = preg_split('/\n+/', $text);

        $chunks = [];

        foreach ($paragraphs as $paragraph) {

            if (mb_strlen($paragraph) <= $config['size']) {
                $chunks[] = trim($paragraph);
                continue;
            }

            // 2️⃣ Nếu paragraph dài → tách theo câu
            $sentences = preg_split('/(?<=[.?!])\s+/', $paragraph);

            $current = '';

            foreach ($sentences as $sentence) {

                if (mb_strlen($current . ' ' . $sentence) > $config['size']) {

                    $chunks[] = trim($current);

                    // overlap
                    $current = mb_substr(
                        $current,
                        -$config['overlap']
                    );

                    $current .= ' ' . $sentence;

                } else {
                    $current .= ' ' . $sentence;
                }
            }

            if (!empty(trim($current))) {
                $chunks[] = trim($current);
            }
        }

        return array_values(array_filter($chunks));
    }

    /**
     * Tự chọn config theo loại document
     */
    protected function getConfig(string $type): array
    {
        return match ($type) {
            'faq' => [
                'size' => 400,
                'overlap' => 80,
            ],
            'job' => [
                'size' => 700,
                'overlap' => 150,
            ],
            'cv' => [
                'size' => 900,
                'overlap' => 200,
            ],
            default => [
                'size' => 600,
                'overlap' => 120,
            ],
        };
    }

    /**
     * Chuẩn hóa text
     */
    protected function normalize(string $text): string
    {
        // remove multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);

        // trim
        return trim($text);
    }
}