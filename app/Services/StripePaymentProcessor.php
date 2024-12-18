<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class StripePaymentProcessor implements PaymentProcessorInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPayment(float $amount, string $currency, array $paymentDetails): array
    {
        try {
            if (empty($paymentDetails['payment_method_id'])) {
                throw new \Exception('Payment method ID is required');
            }

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => $currency,
                'payment_method' => $paymentDetails['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.success'),
            ]);

            return [
                'status' => 'success',
                'payment_intent_id' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe Payment Creation Error: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }


    public function processPayment(array $paymentData): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentData['payment_intent_id']);

            if ($paymentIntent->status === 'succeeded') {
                return [
                    'status' => 'success',
                    'message' => 'Payment processed successfully.',
                    'transaction_id' => $paymentIntent->id,
                ];
            }

            return [
                'status' => 'error',
                'message' => 'Payment failed.',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function refundPayment(string $transactionId, float $amount): bool
    {
        try {
            \Stripe\Refund::create([
                'payment_intent' => $transactionId,
                'amount' => $amount * 100,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Refund failed: ' . $e->getMessage());
            return false;
        }
    }
}
