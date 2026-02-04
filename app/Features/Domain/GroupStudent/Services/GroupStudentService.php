<?php
namespace App\Features\Domain\GroupStudent\Services;
use App\Features\Domain\GroupStudent\Repositories\GroupStudentRepository;

class GroupStudentService
{
    // Service implementation goes here
    public function __construct(private GroupStudentRepository $groupStudentRepository)
    {
        // Constructor code here
    }
    public function getGroupStudentsByUser($user){
        return $this->groupStudentRepository->getGroupStudentsByUser($user);
    }
}