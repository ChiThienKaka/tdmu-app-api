<?php

namespace App\Features\Domain\Recruitment\Companies\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RecruiterCompanyModel extends Model
{
    protected $table = 'recruiter_companies';
    protected $primaryKey = 'company_id';

    protected $fillable = [
        'company_name',   
        'company_tax_code',
        'company_address',
        'company_phone',
        'company_email',
        'company_size',
        'company_industry',
        'company_url',
        'verification_status'
    ];

    protected $casts = [
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
