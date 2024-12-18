<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;

class CashOnDeliveryPaymentProcessor implements PaymentProcessorInterface
{
    public function createPayment(float $amount, string $currency, array $paymentDetails): array
    {
        return [
            'status' => 'success',
            'message' => 'Cash on Delivery payment created successfully.',
            'payment_details' => [
                'amount' => $amount,
                'currency' => $currency,
                'details' => $paymentDetails,
            ],
        ];
    }

    public function processPayment(array $paymentData): array
    {
        return [
            'status' => 'pending',
            'message' => 'Payment will be collected upon delivery.',
        ];
    }

    public function refundPayment(string $transactionId, float $amount): bool
    {
        return true;
    }
}
