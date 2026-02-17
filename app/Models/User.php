<?php

namespace App\Models;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use App\Features\Domain\ApplicantProfile\Models\StudentProfileModel;
use App\Features\Domain\JobApplication\Models\JobApplicationModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'google_id',
        'email',
        'password',
        'full_name',
        'avatar_url',
        'phone',
        'date_of_birth',
        'gender',
        'role_id',
        'student_code',
        'is_verified',
        'status'
    ];

    protected $casts = [
        'is_verified'   => 'boolean',
        'date_of_birth'=> 'date',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Required by JWTSubject
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Required by JWTSubject
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    // Quan hệ Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    // Quan hệ với Major thông qua bảng trung gian UserMajor
    public function majors()
    {
        return $this->belongsToMany(Major::class, 'user_majors', 'user_id', 'major_id')
                    ->using(UserMajor::class)
                    ->withPivot(['class_name', 'academic_year']);
    }
    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'group_members',   // bảng trung gian
            'user_id',
            'group_id'
        )->withPivot('member_role')
        ->withTimestamps();
    }
    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class, 'user_id', 'user_id');
    }
     /**
     * Mỗi user chỉ có 1 company
     */
    public function company()
    {
        return $this->hasOne(
            RecruiterCompanyModel::class,
            'user_id',
            'user_id'
        );
    }
    public function subscriptions()
    {
        return $this->hasMany(RecruiterSubscriptionModel::class, 'user_id', 'user_id');
    }
    
    public function studentProfile()
    {
        return $this->hasOne(
            StudentProfileModel::class,
            'user_id',   // FK ở bảng student_profiles
            'user_id'    // PK ở bảng users
        );
    }
    // liên kết nhiều
    public function jobApplications()
    {
        return $this->hasMany(JobApplicationModel::class, 'user_id', 'user_id');
    }

}
