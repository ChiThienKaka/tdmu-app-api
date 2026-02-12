<?php

namespace App\Features\Domain\JobPostings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategoryModel extends Model
{
    use HasFactory;

    protected $table = 'job_categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'category_slug',
        'parent_id',
        'icon',
        'description',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Quan hệ: danh mục cha
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'category_id');
    }

    /**
     * Quan hệ: danh mục con
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'category_id');
    }
}
