<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentRelationManager extends RelationManager
{
    protected static string $relationship = 'payment'; // Ensure the relationship name is correct

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('payment_status')
                    ->label('Payment Status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('payment_method')
                    ->label('Payment Method')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id') // You can display 'id' or another unique attribute for the payment
            ->columns([
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->sortable(),
                // Display the related Order data
                Tables\Columns\TextColumn::make('order.id') // Assuming `order_number` is a field on the `Order` model
                    ->label('Order Number')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.total_amount') // Assuming `total_amount` is a field on the `Order` model
                    ->label('Total Amount')
                    ->sortable(),
            ])
            ->filters([
                // Add any filters if needed
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
