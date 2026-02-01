<?php
namespace App\Features\Domain\Auth\Services;

use App\Features\Infrastructure\Persistence\Auth\UserRepository;
use App\Features\Infrastructure\Persistence\Auth\UserMajorRepository;
use App\Features\Infrastructure\Persistence\Auth\MajorRepository;
use App\Features\Domain\Auth\Services\RegisterGroupService;
use App\Features\Domain\Auth\DTOs\RegisterDTO;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterService
{
    protected UserRepository $userRepository;
    protected UserMajorRepository $userMajorRepository;
    protected MajorRepository $majorRepository;
    protected RegisterGroupService $registerGroupService;

    public function __construct(
        UserRepository $userRepository,
        UserMajorRepository $userMajorRepository,
        MajorRepository $majorRepository,
        RegisterGroupService $registerGroupService,
    ) {
        $this->userRepository = $userRepository;
        $this->userMajorRepository = $userMajorRepository;
        $this->majorRepository = $majorRepository;
        $this->registerGroupService = $registerGroupService;
    }

    public function createStudentProfile(RegisterDTO $dto): ?User
    {
        $email = $dto->email;

        $exits_email = $this->userRepository->existsByEmail($email);

        //kiểm tra email đã tồn tại chưa
        if ($exits_email) {
            throw new \Exception('Email already exists');
        }

        //kiểm tra email có phải email sinh viên không
        if($this->isStudent($email)) {
            $studentCode = $this->extractStudentCodeFromEmail($email);
            // Lấy mã ngành từ mã sinh viên
            $majorCode = $this->extractMajorCode($studentCode);
            // Tạo bảng user cho sinh viên
            $user = $this->userRepository->create([
                'email' => $email,
                'student_code' => $studentCode,
                'role_id' => 2, // role_id 2 là sinh viên
                'full_name' => $dto->full_name,
                'password' => Hash::make($dto->password),
                //register google
                'avatar_url'=> $dto->picture,
                'google_id'=> $dto->google_id
            ]);
            // Tạo bảng user_major nếu có mã ngành
            if ($majorCode) {
                $major = $this->majorRepository->findByCode($majorCode);
                $facultyId = $major->faculty_id;
                $majorId = $major->major_id;
                if (!$major) {
                    throw new \Exception('Major not found: ' . $majorCode);
                }
                $this->userMajorRepository->create([
                    'user_id' => $user->user_id,
                    'major_id' => $major->major_id
                ]);
                // đăng ký group khoa viện
                $this->registerGroupService->registerGroupFaculty($user, $facultyId, $majorId);
            }
            return $user;
        }else{
            // Tạo bảng user cho người dùng không phải sinh viên
            $user = $this->userRepository->create([
                'email' => $email,
                'role_id' => 3, // role_id 3 là khách
                'full_name' => $dto->full_name,
                'password' => Hash::make($dto->password),
                //register google
                'avatar_url'=> $dto->picture,
                'google_id'=> $dto->google_id
            ]);
            return $user;
        }

        return null;
    }
    // Lấy mã sinh viên từ email
    private function extractStudentCodeFromEmail(string $email): string
    {
        if (!str_ends_with($email, '@student.tdmu.edu.vn')) {
            throw new \InvalidArgumentException('Email is not a student email');
        }

        return strstr($email, '@', true);
    }
    //kiểm tra email có phải email sinh viên không
    public function isStudent(string $email): bool
    {
        return str_ends_with($email, '@student.tdmu.edu.vn');
    }
    // kiểm tra mssv thuộc ngành nào
    function extractMajorCode(string $studentCode): ?string
    {
        if (strlen($studentCode) !== 13) {
            return null;
        }
        ///format xxx480201xxxx
        return '7' . substr($studentCode, 3, 6);
    }

}
