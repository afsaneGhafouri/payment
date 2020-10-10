<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientCreditException;
use App\Http\Requests\CreatePaymentRequest;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function create(CreatePaymentRequest $paymentRequest)
    {
        $fields = $paymentRequest->only(['order_id', 'user_id', 'cost']);
        try {
            $payment = $this->paymentService->create($fields);
        } catch (InsufficientCreditException $creditException) {
            return response()->json([
                'message' => 'Insufficient Credit Amount'
            ], 400);
        }

        return response()->json($payment->toArray(), 201);


    }
}
