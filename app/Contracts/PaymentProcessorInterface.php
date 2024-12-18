<?php

namespace App\Contracts;

interface PaymentProcessorInterface
{
    /**
     * Creates a payment.
     *
     * @param float $amount
     * @param string $currency
     * @param array $paymentDetails
     * @return array
     */
    public function createPayment(float $amount, string $currency, array $paymentDetails): array;

    /**
     * Processes a payment.
     *
     * @param array $paymentData
     * @return array
     */
    public function processPayment(array $paymentData): array;

    /**
     * Refunds a payment.
     *
     * @param string $transactionId
     * @param float $amount
     * @return bool
     */
    public function refundPayment(string $transactionId, float $amount): bool;
}
