<?php

namespace App\Filament\Pages;

use App\Models\Category;
use App\Settings\FooterSettings;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageFooter extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Settings';
    protected static string $settings = FooterSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('address')
                            ->label('Address')
                            ->required()
                            ->placeholder('Enter the address here')
                            ->hint('This will be displayed in the footer.')
                            ->columnSpanFull(),
                        TextInput::make('location')
                            ->label('Location')
                            ->required()
                            ->placeholder('e.g., São Conrado, Rio de Janeiro'),
                        TextInput::make('copyright')
                            ->label('Copyright')
                            ->required()
                            ->placeholder('e.g., © 2024 Your Company Name'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Links')
                    ->schema([
                        Repeater::make('links')
                            ->label('Useful Links')
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
                            ->columns(2)
                            ->createItemButtonLabel('Add New Category'),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Open Hours')
                    ->schema([
                        Forms\Components\Textarea::make('open_hours')
                            ->label('Working Hours')
                            ->required()
                            ->placeholder("Mon to Fri: 10:00 AM to 8:00 PM\nSat - Sun: 11:00 AM to 4:00 PM\nHolidays: Closed")
                            ->helperText('Enter each time slot on a new line')
                            ->rows(5)
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Menu')
                    ->schema([
                        Repeater::make('menu')
                            ->label('Menu Items')
                            ->schema([
                                TextInput::make('key')
                                    ->label('Menu Item')
                                    ->required()
                                    ->placeholder('e.g., Home, Products'),
                                TextInput::make('value')
                                    ->label('URL')
                                    ->required()
                                    ->placeholder('Ensure the URL is valid and starts with http:// or https://'),
                            ])
                            ->columns(2)
                            ->createItemButtonLabel('Add New Menu Item'),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Social Links')
                    ->schema([
                        Repeater::make('social_links')
                            ->label('Social Media Links')
                            ->schema([
                                TextInput::make('key')
                                    ->label('Platform')
                                    ->required()
                                    ->placeholder('e.g., Facebook, Twitter'),
                                TextInput::make('value')
                                    ->label('URL')
                                    ->required()
                                    ->placeholder('e.g., https://facebook.com/yourpage'),
                            ])
                            ->columns(2)
                            ->createItemButtonLabel('Add New Social Link'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
