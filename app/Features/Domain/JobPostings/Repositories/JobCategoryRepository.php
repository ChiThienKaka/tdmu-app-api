<?php
namespace App\Features\Domain\JobPostings\Repositories;
use App\Features\Domain\JobPostings\Models\JobCategoryModel;
class JobCategoryRepository {
    public function __construct()
    {
       
    }
    //Lấy danh sách danh mục
    public function listAllJobCategory(){
        return JobCategoryModel::where('parent_id', null)->get();
    }
}