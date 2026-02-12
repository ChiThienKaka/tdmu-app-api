<?php
namespace App\Features\Domain\Auth\Services;
use App\Features\Infrastructure\Persistence\Auth\UserRepository;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;
use App\Features\Domain\Auth\DTOs\RegisterDTO;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterRecruiterService
{
    protected UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function createRecruiter(RegisterDTO $dto)
    {
        $email = $dto->email;

        $exits_email = $this->userRepository->existsByEmail($email);

        //kiểm tra email đã tồn tại chưa
        if ($exits_email) {
            throw new \Exception('Email already exists');
        }

        // Tạo bảng user cho nhà tuyển dụng
        $user = $this->userRepository->create([
            'email' => $email,
            'role_id' => 4, 
            'full_name' => $dto->full_name,
            'password' => Hash::make($dto->password),
            //register google
            'avatar_url'=> $dto->picture,
            'google_id'=> $dto->google_id
        ]);
        // tạo sẵn bảng thông tin công ty
        $user->company()->create();

        return $user;
    }
}
