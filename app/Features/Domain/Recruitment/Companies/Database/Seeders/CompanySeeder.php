<?php
namespace App\Features\Domain\Recruitment\Companies\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;
use App\Models\User;
class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $company_infos = collect( require app_path(
            'Features\Domain\Recruitment\Companies\Database\Seeders\data\info_company.php'
        ));
        $company_imgs = collect( require app_path(
            'Features\Domain\Recruitment\Companies\Database\Seeders\data\img_company.php'
        ));
        $recruiters = User::where('role_id', 4)->get();
        foreach($recruiters as $user){
            $company_info = $company_infos->random();
            $company_img = $company_imgs->random();
            RecruiterCompanyModel::create([
                'user_id'=> $user->user_id,
                'company_name'     => $company_info['company_name'],
                'company_tax_code' => $company_info['company_tax_code'],
                'company_address'  => $company_info['company_address'],
                'company_phone'    => $company_info['company_phone'],
                'company_email'    => $company_info['company_email'],
                'company_size'     => $company_info['company_size'],
                'company_industry' => $company_info['company_industry'],
                'company_url'      => $company_img,
                'verification_status'=> 'verified'
            ]);
        }
    }
}
