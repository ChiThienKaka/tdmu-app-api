<?php
namespace App\Features\Domain\Auth\Services;
use App\Features\Domain\Auth\Repositories\RegisterGroupRepository;
use App\Models\Group;
use App\Models\User;
class RegisterGroupService {
    protected RegisterGroupRepository $registerGroupRepository;
    public function __construct(RegisterGroupRepository $registerGroupRepository)
    {
        $this->registerGroupRepository = $registerGroupRepository;
    }
    public function getGroupByFacultyFirst(int $faculty_id):Group {
        $group = $this->registerGroupRepository->getGroupByFacultyFirst($faculty_id);
        return $group;
    }
    public function getGroupByMajorFirst(int $major_id):Group {
        $group = $this->registerGroupRepository->getGroupByMajorFirst($major_id);
        return $group;
    }
    public function get3GroupByClubFirst(){
        $group = $this->registerGroupRepository->get3GroupByClubFirst();
        return $group;
    }
    public function registerGroupFaculty(User $user, int $faculty_id, int $major_id){
        $group_faculty = $this->getGroupByFacultyFirst($faculty_id);
        $group_major = $this->getGroupByMajorFirst($major_id);
        $group_3club = $this->get3GroupByClubFirst();
        $syncData = [];
        // add nhóm khoa viện
        if ($group_faculty) {
            $syncData[$group_faculty->group_id] = [
                'member_role' => 'member'
            ];
        }
        //add nhóm ngành
        if ($group_major) {
            $syncData[$group_major->group_id] = [
                'member_role' => 'member'
            ];
        }
        //add 2 club đầu tiên
        foreach ($group_3club as $club) {
            $syncData[$club->group_id] = [
                'member_role' => 'member'
            ];
        }

        if (!empty($syncData)) {
            $user->groups()->syncWithoutDetaching($syncData);
        }
        // if ($group_faculty) {
        //     $syncData[$group_faculty->group_id] = [
        //         'member_role' => 'member'
        //     ];
        // }
    }
}