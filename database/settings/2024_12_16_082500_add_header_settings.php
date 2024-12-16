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
                'label' => 'Rent Venue',
                'url' => '/rent-venue',
            ],
            [
                'label' => 'Shows & Events',
                'url' => '/shows-events',
            ],
            [
                'label' => 'Tickets',
                'url' => '/tickets',
            ],
        ]);
    }
};
