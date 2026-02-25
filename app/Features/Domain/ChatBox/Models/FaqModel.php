<?php

namespace App\Features\Domain\ChatBox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FaqModel extends Model
{
    protected $table = 'faqs';

    protected $fillable = [
        'intent',
        'domain',
        'question',
        'answer',
        'priority',
    ];

    /**
     * Nếu muốn đảm bảo kiểu dữ liệu
     */
    protected $casts = [
        'priority' => 'integer',
    ];

    /**
     * Scope: lọc theo domain
     */
    public function scopeByDomain(Builder $query, string $domain): Builder
    {
        return $query->where('domain', $domain);
    }

    /**
     * Scope: lọc theo intent
     */
    public function scopeByIntent(Builder $query, string $intent): Builder
    {
        return $query->where('intent', $intent);
    }

    /**
     * Scope: sắp xếp theo priority cao → thấp
     */
    public function scopePriorityDesc(Builder $query): Builder
    {
        return $query->orderByDesc('priority');
    }
}