<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {

        $this->migrator->add('header.header_items', [
            [
                'label' => 'Home',
                'url' => '/',
            ],
            [
                'label' => 'About Us',
                'url' => '/about',
            ],
            [
                'label' => 'Contact Us',
                'url' => '/contact',
            ],
            [
                'label' => 'categories',
                'url' => '/categories',
            ],
            [
                'label' => 'Products',
                'url' => '/products',
            ],
        ]);
    }
};
