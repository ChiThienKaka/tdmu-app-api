<?php
namespace App\Features\Domain\Recruitment\Subscriptions\Database\Seeders;

use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use App\Features\Domain\Recruitment\Payments\Models\PaymentTransactionModel;
use App\Features\Domain\Recruitment\Payments\Models\RecruiterPaymentModel;
use App\Features\Domain\Recruitment\Packages\Models\RecruiterPackageModel;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;


class RecruiterSubscriptionSeeder extends Seeder
{
    public function run(): void
    {
       $users = User::with('company')->where('role_id', 4)->get();
       $packages = RecruiterPackageModel::get();
       foreach($users as $user){
            $package = $packages->random();
            $subscription = $user->subscriptions()->create([
                'package_id' => $package->package_id,
                'company_id' => $user?->company->company_id,
                'start_date' => now(),
                'end_date' => now()->addDays($package->duration_days),
                'status' => 'active'
            ]);
            RecruiterPaymentModel::create([
                'subscription_id' => $subscription->subscription_id,
                'payment_status' => 'completed',
                'payment_method' => 'vnpay',
                'payment_amount' => $package->price,
            ]);
            PaymentTransactionModel::create([
                'subscription_id' => $subscription->subscription_id,
                'payment_method' => 'vnpay',
                'amount' => $package->price,
                'status' => 'completed',
                'transaction_code'=> Str::upper(Str::random(10))
            ]);
       }
    }
}
