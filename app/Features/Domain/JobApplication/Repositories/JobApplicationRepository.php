<?php
namespace App\Features\Domain\JobApplication\Repositories;
use App\Features\Domain\JobApplication\Models\JobApplicationModel;
use App\Features\Domain\JobApplication\Models\ApplicationTimeline;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Features\Domain\JobApplication\Services\MediaStorageService;
use Illuminate\Validation\ValidationException;
use App\Features\Domain\ApplicantProfile\Models\StudentProfileModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class JobApplicationRepository {
    public function __construct(private MediaStorageService $mediaserive)
    {
    }
    //hàm khởi tạo thông qua profile
    public function applyWithDefaultCV(
        User $user, $job_id
    ) {
        $profile = StudentProfileModel::where('user_id', $user->user_id)->firstOrFail();
        if (!$profile->cv_default_url) {
            throw ValidationException::withMessages([
                'cv' => 'Bạn chưa có CV mặc định.'
            ]);
        }
        if (!$profile->email && !$profile->phone) {
            throw ValidationException::withMessages([
                'contact' => 'Cần ít nhất một phương thức liên hệ.'
            ]);
        }
        return $this->createApplicationCore(
            $user,
            [
                'job_id'=> $job_id,
                'email' => $profile->email,
                'phone' => $profile->phone,
            ],
            $profile->cv_default_url ?? null
        );
    }

    // gửi CV thông qua profile
    public function applyWithUploadedCV(
        User $user,
        array $data,
        $media
    ) {
        $cvUrl = null;
        if ($media) {
            $path = $this->mediaserive->store($media);
            $cvUrl = $this->mediaserive->url($path);
        }
        return $this->createApplicationCore($user, $data, $cvUrl);
    }
    // hàm khởi tạo core
    public function createApplicationCore(User $user, array $data, ?string $cvUrl){
        return DB::transaction(function () use ($user, $data, $cvUrl) {
            $job_id = $data['job_id'];
            $jobPost = JobPostModel::lockForUpdate()->findOrFail($job_id);

            // Check đã apply chưa (theo user + job)
            $exists = JobApplicationModel::where('job_id', $job_id)
                ->where('user_id', $user->user_id)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'message' => 'Bạn đã ứng tuyển vị trí này rồi.'
                ]);
            }

            // Lưu CV nếu có
            // $path = null;
            // if ($media) {
            //     $path = $this->mediaserive->store($media);
            // }

            $application = $jobPost->applications()->create([
                ...$data,
                'user_id' => $user->user_id,
                'cv_url'  => $cvUrl
                // 'cv_url'  => $path ? $this->mediaserive->url($path) : null,
            ]);
            // ghi timeline đầu tiên, lịch sử xử lý hồ sơ
            $application->timelines()->create([
                "changed_by"=>$user->user_id,
                "old_status"=> null,
                "new_status"=>$application->status ?? 'pending',
                'note'=>'User applied'
            ]);
            return $application;
        });
    }
}