<?php
namespace App\Features\Domain\Recruitment\Companies\Services;
use App\Features\Domain\Recruitment\Companies\Services\ImageStorageService;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class RecruiterCompanyService {
    public function __construct(private ImageStorageService $imageStorageService)
    {
       
    }
    public function updateRecruiterCompany(User $user, array $dto, $image){
        if ($user->company) {
            $path = $image ? $this->imageStorageService->store($image) : null;
            $user->company()->update([
                ...$dto,
                'company_url'=> $path ? $this->imageStorageService->url($path) : null
                
            ]);
            return $user->company;
        }
        throw ValidationException::withMessages([
            'company' => ['User does not have a company to update.'],
        ]);
    }
}