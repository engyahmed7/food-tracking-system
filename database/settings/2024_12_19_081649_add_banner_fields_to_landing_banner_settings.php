<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('landing_banner_settings.banner_text', 'Default Banner Text');
        $this->migrator->add('landing_banner_settings.banner_image', 'bolognese-past.jpg');
        $this->migrator->add('landing_banner_settings.banner_btn_text', 'Click Here');
    }

    public function down(): void
    {
        $this->migrator->delete('landing_banner_settings.banner_text');
        $this->migrator->delete('landing_banner_settings.banner_image');
        $this->migrator->delete('landing_banner_settings.banner_btn_text');
    }


    public static function group(): string
    {
        return 'landing_banner_settings';
    }
};
