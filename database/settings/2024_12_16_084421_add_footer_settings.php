<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('footer.address', '5 College St NW, Norcross, GA 30071, United States');
        $this->migrator->add('footer.links', [
            [
                'label' => 'home',
                'url' => '',
            ],
            [
                'label' => 'about us',
                'url' => '',
            ],
            [
                'label' => 'contact us',
                'url' => '',
            ],
            [
                'label' => 'categories',
                'url' => '',
            ],
            [
                'label' => 'products',
                'url' => '',
            ],
        ]);
        $this->migrator->add('footer.open_hours', "Mon to Fri: 10:00 AM to 8:00 PM\nSat - Sun: 11:00 AM to 4:00 PM\nHolidays: Closed");
        $this->migrator->add('footer.location', 'São Conrado, Rio de Janeiro');
        $this->migrator->add('footer.copyright', 'Copyright 2021 ArtXibition Company');
        $this->migrator->add('footer.menu', [
            'home' => '#',
            'about us' => '#',
            'contact us' => '#',
            'categories' => '#',
            'products' => '#',
        ]);
        $this->migrator->add('footer.social_links', [
            'twitter' => '#',
            'facebook' => '#',
            'behance' => '#',
            'instagram' => '#',
        ]);
    }

    public function down(): void
    {
        $this->migrator->delete('footer.address');
        $this->migrator->delete('footer.categories');
        $this->migrator->delete('footer.open_hours');
        $this->migrator->delete('footer.location');
        $this->migrator->delete('footer.copyright');
        $this->migrator->delete('footer.menu');
        $this->migrator->delete('footer.social_links');
    }
};
