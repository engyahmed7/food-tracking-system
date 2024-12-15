<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryTrackingRelationManager extends RelationManager
{
    // Set the relationship name to match the method defined in the Order model
    protected static string $relationship = 'deliveryTracking';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'preparing' => 'Preparing',
                        'on_the_way' => 'On the way',
                        'delivered' => 'Delivered',
                        'failed' => 'Failed',
                    ])
                    ->required(),

                Forms\Components\DateTimePicker::make('status_time')
                    ->required()
                    ->nullable()
                    ->label('Status Time'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')  
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Order ID') 
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status_time')
                    ->label('Status Time')
                    ->sortable()
                    ->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),  
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
