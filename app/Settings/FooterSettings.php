<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FooterSettings extends Settings
{
    public string $address;
    public array $links;
    public array $open_hours;
    public string $location;
    public string $copyright;
    public array $menu;
    public array $social_links;

    public static function group(): string
    {
        return 'footer';
    }
}
