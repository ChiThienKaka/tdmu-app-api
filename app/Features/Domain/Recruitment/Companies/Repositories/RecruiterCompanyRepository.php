<?php

namespace App\Features\Domain\Recruitment\Companies\Repositories;
use App\Models\User;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;
use Illuminate\Validation\ValidationException;
class RecruiterCompanyRepository
{
    public function getInfoCompanyUser(User $user){
       if (!$user->company) {
        throw ValidationException::withMessages([
            'company' => ['User is not associated with any company.']
        ]);
    }

    return $user->company;
    }
    public function getVerified()
    {
        return RecruiterCompanyModel::where('verification_status', 'verified')
            ->orderBy('company_name')
            ->get();
    }
}
