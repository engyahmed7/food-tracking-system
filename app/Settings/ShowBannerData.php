<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ShowBannerData extends Settings
{
    public int $selected_product_id;

    public static function group(): string
    {
        return 'landing_banner_settings';
    }
}
