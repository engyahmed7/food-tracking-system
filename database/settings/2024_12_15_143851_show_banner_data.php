<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('landing_banner_settings.selected_product_id', 1);
    }

    public static function group(): string
    {
        return 'landing_banner_settings';
    }
};


