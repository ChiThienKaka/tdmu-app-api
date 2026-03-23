<?php

namespace App\Features\Domain\Admin\Controllers;

use App\Features\Domain\Admin\Services\AdminSubscriptionService;
use App\Features\Domain\Admin\Resources\AdminSubscriptionResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminSubscriptionController
{
    public function __construct(protected AdminSubscriptionService $subscriptionService) {}

    // Danh sách subscription (filter theo status)
    public function index(FormRequest $request)
    {
        $validated = $request->validate([
            'status'   => ['sometimes', Rule::in(['pending', 'active', 'expired'])],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $result = $this->subscriptionService->listSubscriptions(
            $validated['status'] ?? null,
            $validated['per_page'] ?? 20
        );

        return response()->json([
            'data'         => AdminSubscriptionResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages'  => $result->lastPage(),
            'total'        => $result->total(),
        ], 200);
    }

    // Chi tiết một subscription
    public function show(int $subscription_id)
    {
        $sub = $this->subscriptionService->getDetail($subscription_id);
        if (! $sub) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }
        return response()->json(['data' => new AdminSubscriptionResource($sub)], 200);
    }

    // Kích hoạt subscription (sau khi xác nhận thanh toán thủ công)
    public function activate(int $subscription_id)
    {
        $sub = $this->subscriptionService->activateSubscription($subscription_id);
        if (! $sub) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }
        return response()->json([
            'message' => 'Kích hoạt gói đăng ký thành công',
            'data'    => new AdminSubscriptionResource($sub),
        ], 200);
    }
}
