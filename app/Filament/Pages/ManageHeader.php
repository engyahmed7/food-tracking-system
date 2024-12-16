<?php

namespace App\Filament\Pages;

use App\Settings\HeaderSettings;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageHeader extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Header Settings';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $title = 'Manage Header';
    protected static string $settings = HeaderSettings::class;

    protected function getFormSchema(): array
    {
        return [
            Repeater::make('header_items')
                ->label('Header Items')
                ->schema([
                    TextInput::make('label')
                        ->label('Label')
                        ->required(),
                    TextInput::make('url')
                        ->label('URL')
                        ->required(),
                ])
                ->minItems(1)
                ->createItemButtonLabel('Add New Item'),
        ];
    }
}
