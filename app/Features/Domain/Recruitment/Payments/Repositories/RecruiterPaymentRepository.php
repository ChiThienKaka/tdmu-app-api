<?php
namespace App\Features\Domain\Recruitment\Payments\Repositories;
use App\Features\Domain\Recruitment\Payments\Models\RecruiterPaymentModel;

class RecruiterPaymentRepository
{
    // Repository methods will be defined here in the future.
    public function create(array $data)
    {
        return RecruiterPaymentModel::create($data);
    }
}