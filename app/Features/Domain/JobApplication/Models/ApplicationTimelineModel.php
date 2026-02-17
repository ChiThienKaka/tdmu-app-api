<?php

namespace App\Features\Domain\JobApplication\Models;

use Illuminate\Database\Eloquent\Model;
use App\Features\Domain\JobApplication\Models\JobApplicationModel;
use App\Models\User;

class ApplicationTimelineModel extends Model
{
    protected $table = 'application_timeline';

    protected $primaryKey = 'timeline_id';

    public $timestamps = false; // bạn custom created_at

    /*
    |--------------------------------------------------------------------------
    | Mass assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'application_id',
        'changed_by',
        'old_status',
        'new_status',
        'note',
        'created_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function application()
    {
        return $this->belongsTo(
            JobApplicationModel::class,
            'application_id',
            'application_id'
        );
    }

    public function changedBy()
    {
        return $this->belongsTo(
            User::class,
            'changed_by',
            'user_id'
        );
    }
}
