<?php

namespace App\Services;

use App\Exceptions\InsufficientCreditException;
use App\Models\Payment;

class PaymentService
{
    private UserService $userService;
    private Payment $payment;

    public function __construct(Payment $payment, UserService $userService)
    {
        $this->userService = $userService;
        $this->payment = $payment;
    }

    public function create(array $data): Payment
    {
        $user = $this->userService->get($data['user_id']);
        if (!$user || $user->credit < $data['cost']) {
            throw new InsufficientCreditException();
        }

        $payment = $this->payment->create($data);

    }
}
