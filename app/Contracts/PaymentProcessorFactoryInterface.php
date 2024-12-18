<?php

namespace App\Contracts;

use App\Contracts\PaymentProcessorInterface;

interface PaymentProcessorFactoryInterface
{
    /**
     * Returns the payment processor implementation based on the provider name.
     *
     * @param string $provider
     * @return PaymentProcessorInterface
     */
    public function getProcessor(string $provider): PaymentProcessorInterface;
}
