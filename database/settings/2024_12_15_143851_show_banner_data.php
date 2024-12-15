<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Add the `selected_product_id` setting with a default value (e.g., 1)
        $this->migrator->add('landing_banner_settings.selected_product_id', 1); // Set default product ID here
    }

    public static function group(): string
    {
        return 'landing_banner_settings';
    }
};


