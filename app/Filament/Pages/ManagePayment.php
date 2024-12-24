<?php

namespace App\Filament\Pages;

use App\Settings\PaymentSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Heading;
use Filament\Forms\Components\Section;

class ManagePayment extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Manage Payment';
    protected static string $settings = PaymentSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Payment Gateway Configuration')
                    ->description('Configure the payment methods available to users in your application.')
                    ->schema([
                        Forms\Components\Toggle::make('stripe_enabled')
                            ->label('Enable Stripe')
                            ->onIcon('heroicon-o-check-circle')
                            ->offIcon('heroicon-o-x-circle')
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Allow users to pay using Stripe.')
                            ->reactive(),

                        Forms\Components\Toggle::make('paypal_enabled')
                            ->label('Enable PayPal')
                            ->onIcon('heroicon-o-check-circle')
                            ->offIcon('heroicon-o-x-circle')
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Allow users to pay using PayPal.')
                            ->reactive(),

                        Forms\Components\Toggle::make('cod_enabled')
                            ->label('Enable Cash on Delivery')
                            ->onIcon('heroicon-o-check-circle')
                            ->offIcon('heroicon-o-x-circle')
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Allow users to pay using Cash on Delivery.'),
                    ])
                    ->columns(2)
            ]);
    }
}
