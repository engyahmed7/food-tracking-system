<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Settings\showBannerData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;

class ManageLandingBanner extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-photo';

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
                Forms\Components\TextInput::make('banner_text')
                    ->label('Banner Header Text'),

                Forms\Components\TextInput::make('banner_description')
                    ->label('Banner Description'),

                Forms\Components\TextInput::make('banner_btn_text')
                    ->label('Banner Button Text'),


                Forms\Components\FileUpload::make('banner_image')
                    ->label('Banner Image'),
            ]);
    }
}
