<?php

namespace App\Features\Domain\ApplicantProfile\Repositories;

use App\Features\Domain\ApplicantProfile\DTOs\StudentProfileDTO;
use App\Features\Domain\ApplicantProfile\Models\StudentProfileModel;
use App\Features\Domain\ApplicantProfile\Services\MediaStorageService;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class StudentProfileRepository
{
    public function __construct(private MediaStorageService $media_storage_service)
    {
    }
    public function upsert(StudentProfileDTO $dto): StudentProfileModel
    {
        return StudentProfileModel::updateOrCreate(
            // ['user_id' => $dto->user_id],
            $dto->toArray()
        );
    }
    // lấy thông tin Student Profile
    public function findStudentProfileByUser(User $user){
        return $user?->studentProfile;
    }
    // update theo thông tin user truyền vào 
    public function updateStudentProfileByUser(User $user, array $data, $media){
        if($user->studentProfile){
            $path = $media ? $this->media_storage_service->store($media) : null;
            $user?->studentProfile()->update([
                ...$data,
                'cv_default_url'=> $this->media_storage_service->url($path)
            ]);
            return $user->studentProfile;
        }
        throw ValidationException::withMessages([
            'studentprofile' => ['User does not have a student profile to update.'],
        ]);
    }
    public function findByUser(int $userId): ?StudentProfileModel
    {
        return StudentProfileModel::find($userId);
    }

    public function delete(int $userId): bool
    {
        return StudentProfileModel::where('user_id', $userId)->delete();
    }
}
