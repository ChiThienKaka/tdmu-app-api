<?php
namespace App\Features\Domain\Recruitment\Packages\Repositories;

use App\Features\Domain\Recruitment\Packages\Models\RecruiterPackageModel;
class RecruiterPackageRepository
{
    public function getActive()
    {
        return RecruiterPackageModel::where('is_active', true)
            ->orderBy('display_order')
            ->get();
    }
}