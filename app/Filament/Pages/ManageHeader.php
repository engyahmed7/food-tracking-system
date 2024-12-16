<?php

namespace App\Filament\Pages;

use App\Settings\HeaderSettings;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;

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
            // Header Section
            Section::make('Header Items Configuration')
                ->schema([
                    Repeater::make('header_items')
                        ->label('Header Items')
                        ->schema([
                            TextInput::make('label')
                                ->label('Label')
                                ->placeholder('Enter label for the header item')
                                ->required()
                                ->reactive()
                                ->helperText('This will be displayed in the navigation menu.'),
                            TextInput::make('url')
                                ->label('URL')
                                ->placeholder('Enter the URL for the header item')
                                ->required()
                                ->reactive()
                                ->helperText('Ensure the URL is valid and starts with http:// or https://'),
                        ])
                        ->minItems(1)
                        ->maxItems(5)
                        ->createItemButtonLabel('Add New Header Item')
                        ->columns(2)
                        ->defaultItems(1)

                ])
                ->collapsible(),
        ];
    }
}
