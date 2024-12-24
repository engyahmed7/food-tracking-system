<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('payment.stripe_enabled', false);
        $this->migrator->add('payment.paypal_enabled', false);
        $this->migrator->add('payment.cod_enabled', false);
    }
};
