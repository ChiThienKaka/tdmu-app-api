<?php

namespace App\Features\Domain\Recruitment\Companies\Models;

use Illuminate\Database\Eloquent\Model;

class RecruiterCompanyModel extends Model
{
    protected $table = 'recruiter_companies';
    protected $primaryKey = 'company_id';

    protected $fillable = [
        'name',
        'logo',
        'website',
        'address',
        'description',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];
}
