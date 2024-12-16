<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Settings\showBannerData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageLandingBanner extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static string $settings = showBannerData::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('selected_product_id')
                    ->label('Select Product')
                    ->options(Product::all()->pluck('name', 'id'))
                    ->required(),
            ]);
    }
}
