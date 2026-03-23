<?php

namespace App\Features\Domain\Admin\Controllers;

use App\Features\Domain\Admin\Services\AdminPaymentService;
use App\Features\Domain\Admin\Resources\AdminPaymentResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminPaymentController
{
    public function __construct(protected AdminPaymentService $paymentService) {}

    // Danh sách thanh toán (filter theo payment_status)
    public function index(FormRequest $request)
    {
        $validated = $request->validate([
            'payment_status' => ['sometimes', 'string'],
            'per_page'       => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $result = $this->paymentService->listPayments(
            $validated['payment_status'] ?? null,
            $validated['per_page'] ?? 20
        );

        return response()->json([
            'data'         => AdminPaymentResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages'  => $result->lastPage(),
            'total'        => $result->total(),
        ], 200);
    }

    // Chi tiết một giao dịch thanh toán
    public function show(int $payment_id)
    {
        $payment = $this->paymentService->getDetail($payment_id);
        if (! $payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }
        return response()->json(['data' => new AdminPaymentResource($payment)], 200);
    }
}
