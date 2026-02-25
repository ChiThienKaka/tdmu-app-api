<?php

namespace App\Features\Domain\ChatBox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqExampleModel extends Model
{
    protected $table = 'faq_examples';

    protected $fillable = [
        'faq_id',
        'example_question',
    ];

    /**
     * Quan hệ: Example thuộc về 1 FAQ
     */
    public function faq(): BelongsTo
    {
        return $this->belongsTo(FaqModel::class);
    }
}