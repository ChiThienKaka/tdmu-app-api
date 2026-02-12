<?php

namespace App\Features\Domain\Recruitment\Subscriptions\Controllers;

use App\Features\Domain\Recruitment\Subscriptions\Repositories\RecruiterSubscriptionRepository;
use App\Features\Domain\Recruitment\Subscriptions\Resources\RecruiterSubscriptionResource;
use App\Http\Controllers\Controller;
use App\Features\Domain\Recruitment\Subscriptions\Services\CreateRecruiterSubscriptionService;
use App\Features\Domain\Recruitment\Subscriptions\Services\RecruiterSubscriptionService;
use App\Features\Domain\Recruitment\Payments\Services\PaymentService;
use App\Features\Domain\Recruitment\Subscriptions\Resources\SubscriptionAndPackageResource;
use Illuminate\Foundation\Http\FormRequest;

class RecruiterSubscriptionController extends Controller
{
    public function __construct(
        protected RecruiterSubscriptionRepository $repository,
        protected CreateRecruiterSubscriptionService $service,
        protected RecruiterSubscriptionService $subscriptionService,
        protected PaymentService $paymentService,
    ) {
    }
    // Đăng ký gói cho nhà tuyển dụng
    public function subscribeRecruiter(FormRequest $request)
    {
        $user = auth('api')->user();
        $packageId = $request->input('package_id');
        $subscription = $this->service->subscribe($user, $packageId);
        return response()->json([
            'message' => 'Subscription created successfully.',
             'data' => $subscription,
        ], 201);
    }
    //lấy dánh sách gói đang chờ xử lý thanh toán của user
    public function getUserPendingSubscription(FormRequest $request)
    {
        $user = auth('api')->user();
        $recruiterSubscription = $this->subscriptionService->getPendingPackages($user->user_id);
        return response()->json([
            'data' => $recruiterSubscription ? new SubscriptionAndPackageResource($recruiterSubscription) : null,
        ], 200);
    }
    // Lấy danh sách gói đang hoạt động của user
    public function getUserActiveSubscriptions(int $userId)
    {
        $result = $this->repository->getActiveByUser($userId);
        return response()->json([
            'data' => RecruiterSubscriptionResource::collection($result),
        ], 200);
    }
}
