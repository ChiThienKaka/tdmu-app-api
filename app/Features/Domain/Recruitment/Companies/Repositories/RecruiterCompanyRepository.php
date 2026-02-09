<?php

namespace App\Features\Domain\Recruitment\Companies\Repositories;

use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;

class RecruiterCompanyRepository
{
    public function getVerified()
    {
        return RecruiterCompanyModel::where('is_verified', true)
            ->orderBy('name')
            ->get();
    }
}
