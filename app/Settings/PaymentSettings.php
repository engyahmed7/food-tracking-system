<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PaymentSettings extends Settings
{

    public bool $stripe_enabled;
    public bool $paypal_enabled;
    public bool $cod_enabled;

    public static function group(): string
    {
        return 'payment';
    }
}
