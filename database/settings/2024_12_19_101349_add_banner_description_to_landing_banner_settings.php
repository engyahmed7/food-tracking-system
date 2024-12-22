<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('landing_banner_settings.banner_description', 'Default Banner Description');
        $this->migrator->update('landing_banner_settings.banner_image', function () {
            return '';
        });
    }
    public function down(): void
    {
        $this->migrator->delete('landing_banner_settings.banner_description');
        $this->migrator->update('landing_banner_settings.banner_image', function () {
            return 'bolognese-past.jpg';
        });
    }

    public static function group(): string
    {
        return 'landing_banner_settings';
    }
};
