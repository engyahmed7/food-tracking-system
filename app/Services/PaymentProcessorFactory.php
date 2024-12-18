<?php

namespace App\Services;

use App\Contracts\PaymentProcessorFactoryInterface;
use App\Contracts\PaymentProcessorInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentProcessorFactory implements PaymentProcessorFactoryInterface
{
    public function getProcessor(string $provider): PaymentProcessorInterface
    {
        // Log::info('Payment Processor Factory', ['provider' => $provider]);

        return match ($provider) {
            'paypal' => new PayPalPaymentProcessor(),
            'stripe' => new StripePaymentProcessor(),
            'cod' => new CashOnDeliveryPaymentProcessor(),
            default => throw new Exception("Unsupported payment provider: $provider"),
        };
    }
}
