<?php


namespace App\Services;


use App\Contracts\PaymentProcessorInterface;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;
use Exception;

class PayPalPaymentProcessor implements PaymentProcessorInterface
{
    protected $provider;

    public function __construct()
    {
        Log::info('Starting PayPal Constructor');

        $this->provider = new PayPalClient();
        Log::info('PayPalProvider Initialized', ['provider' => $this->provider]);

        $paypalConfig = config('services.paypal');
        Log::info('PayPal Config', ['config' => $paypalConfig]);

        try {
            Log::info('Before setting credentials');
            $this->provider->setApiCredentials(config('services.paypal'));
            Log::info('After setting credentials');
        } catch (\Exception $e) {
            Log::error('Error setting credentials', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }



    public function createPayment(float $amount, string $currency, array $paymentDetails): array
    {
        try {
            Log::info('PayPal Configuration', [
                'mode' => config('services.paypal.mode'),
                'client_id_exists' => !empty(config('services.paypal.client_id')),
                'secret_exists' => !empty(config('services.paypal.secret')),
            ]);

            Log::info('PayPal Create Payment Input', [
                'amount' => $amount,
                'currency' => $currency,
                'payment_details' => $paymentDetails,
            ]);

            try {
                $this->provider->getAccessToken();
            } catch (\Exception $tokenException) {
                Log::error('PayPal Access Token Error', [
                    'message' => $tokenException->getMessage(),
                    'trace' => $tokenException->getTraceAsString(),
                ]);
                throw $tokenException;
            }

            $orderParams = [
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => $currency,
                            "value" => $amount,
                        ],
                        "description" => "Cart Purchase",
                    ],
                ],
                "application_context" => [
                    "return_url" => route('payment.success'),
                    "cancel_url" => route('payment.cancel'),
                    "brand_name" => config('app.name'),
                    "shipping_preference" => "NO_SHIPPING",
                    "user_action" => "PAY_NOW",
                ],
            ];

            Log::info('PayPal Order Creation Parameters', $orderParams);

            $response = $this->provider->createOrder($orderParams);

            Log::info('PayPal Create Order Full Response', ['full_response' => $response]);

            $links = $response['links'] ?? [];
            $approvalLink = null;
            foreach ($links as $link) {
                if ($link['rel'] === 'approve') {
                    $approvalLink = $link['href'];
                    break;
                }
            }

            if (isset($response['id']) && $approvalLink) {
                return [
                    'status' => 'success',
                    'transaction_id' => $response['id'],
                    'approval_url' => $approvalLink,
                    'amount' => $amount,
                    'currency' => $currency,
                ];
            }

            Log::error('PayPal create payment error', [
                'response' => $response,
                'approval_link' => $approvalLink,
            ]);

            return [
                'status' => 'error',
                'message' => $response['message'] ?? 'Failed to create payment',
            ];
        } catch (\Exception $e) {
            Log::error('PayPal Payment Creation Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function processPayment(array $paymentData): array
    {
        try {
            $this->provider->getAccessToken();

            $response = $this->provider->capturePaymentOrder($paymentData['transaction_id']);

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                return [
                    'status' => 'processed',
                    'message' => 'Payment processed successfully using PayPal.',
                ];
            }

            Log::error('PayPal process payment error', ['response' => $response]);
            return [
                'status' => 'error',
                'message' => 'Failed to process payment.',
            ];
        } catch (Exception $e) {
            Log::error('PayPal process payment exception', ['exception' => $e]);
            return [
                'status' => 'error',
                'message' => 'An error occurred while processing the payment.',
            ];
        }
    }

    public function refundPayment(string $transactionId, float $amount): bool
    {
        try {
            $this->provider->getAccessToken();

            $response = $this->provider->refundOrder($transactionId, [
                'amount' => [
                    'value' => $amount,
                    'currency_code' => 'USD',
                ],
            ]);

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                return true;
            }

            Log::error('PayPal refund payment error', ['response' => $response]);
            return false;
        } catch (Exception $e) {
            Log::error('PayPal refund payment exception', ['exception' => $e]);
            return false;
        }
    }
}
