<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HeaderSettings extends Settings
{

    public array $header_items;

    public static function group(): string
    {
        return 'header';
    }
}
