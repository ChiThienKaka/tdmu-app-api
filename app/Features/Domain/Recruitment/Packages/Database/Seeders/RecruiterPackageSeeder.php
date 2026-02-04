<?php
namespace App\Features\Domain\Recruitment\Packages\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Features\Domain\Recruitment\Packages\Models\RecruiterPackageModel;

class RecruiterPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'package_name' => 'Basic',
                'price' => 0,
                'duration_days' => 30,
                'post_limit' => 3,
                'featured_posts_limit' => 0,
                'refresh_limit' => 5,
                'support_priority' => 'standard',
                'features' => ['logo_highlight' => false, 'top_search' => false, 'analytics' => 'none'],
                'display_order' => 1,
            ],
            [
                'package_name' => 'Pro',
                'price' => 250000,
                'duration_days' => 60,
                'post_limit' => 20,
                'featured_posts_limit' => 5,
                'refresh_limit' => 50,
                'support_priority' => 'priority',
                'features' => ['logo_highlight' => true, 'top_search' => false, 'analytics' => 'basic'],
                'display_order' => 2,
            ],
            [
                'package_name' => 'Premium',
                'price' => 700000,
                'duration_days' => 90,
                'post_limit' => 100,
                'featured_posts_limit' => 30,
                'refresh_limit' => 200,
                'support_priority' => 'vip',
                'features' => ['logo_highlight' => true, 'top_search' => true, 'analytics' => 'full'],
                'display_order' => 3,
            ],
        ];
        foreach ($packages as $package) {
             RecruiterPackageModel::create($package);
        }
    }
}
