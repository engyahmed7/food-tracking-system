<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ShowBannerData extends Settings
{
    public int $selected_product_id;
    public string $banner_text;
    public string $banner_description;
    public string $banner_image;
    public string $banner_btn_text;


    public static function group(): string
    {
        return 'landing_banner_settings';
    }
}
