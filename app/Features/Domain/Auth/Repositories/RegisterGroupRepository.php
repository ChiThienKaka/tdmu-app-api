<?php
namespace App\Features\Domain\Auth\Repositories;
use App\Models\Group;
class RegisterGroupRepository{
    public function getGroupByFacultyFirst(int $faculty_id){
        return Group::where('faculty_id', $faculty_id)
                ->where('group_type', 'faculty')
                ->first();
    }
    public function getGroupByMajorFirst(int $major_id){
        return Group::where('major_id', $major_id)
                ->where('group_type', 'major')
                ->first();
    }
    public function get3GroupByClubFirst(){
        return Group::where('group_type', 'club')->limit(3)->get();
    }
}