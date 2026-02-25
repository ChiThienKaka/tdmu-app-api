<?php

namespace App\Features\Domain\ChatBox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EmbeddingModel extends Model
{
    protected $table = 'embeddings';

    protected $fillable = [
        'source_table',
        'source_id',
        'content',
        'embedding',
    ];

    /**
     * Nếu bạn không dùng timestamps trong migration
     */
    public $timestamps = false;

    /**
     * Cast embedding về array khi lấy ra
     */
    protected $casts = [
        'embedding' => 'array',
    ];

    /**
     * Scope: tìm theo bảng nguồn
     */
    public function scopeFromTable(Builder $query, string $table): Builder
    {
        return $query->where('source_table', $table);
    }

    /**
     * Scope: tìm theo source_id
     */
    public function scopeFromSource(Builder $query, string $table, int $id): Builder
    {
        return $query->where('source_table', $table)
                     ->where('source_id', $id);
    }

    /**
     * Search theo vector (cosine similarity)
     */
    public function scopeSearchByVector(Builder $query, array $vector, int $limit = 5): Builder
    {
        $vectorString = '[' . implode(',', $vector) . ']';

        return $query
            ->selectRaw("
                *,
                1 - (embedding <=> ?) AS similarity
            ", [$vectorString])
            ->orderByRaw("embedding <=> ?", [$vectorString])
            ->limit($limit);
    }
}