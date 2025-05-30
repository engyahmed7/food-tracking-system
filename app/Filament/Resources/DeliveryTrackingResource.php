<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryTrackingResource\Pages;
use App\Filament\Resources\DeliveryTrackingResource\RelationManagers;
use App\Models\DeliveryTracking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryTrackingResource extends Resource
{
    protected static ?string $model = DeliveryTracking::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'preparing' => 'Preparing',
                        'on_the_way' => 'On the way',
                        'delivered' => 'Delivered',
                        'failed' => 'Failed',
                    ])
                    ->required(),

                Forms\Components\DateTimePicker::make('status_time')
                    ->nullable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryTrackings::route('/'),
            'create' => Pages\CreateDeliveryTracking::route('/create'),
            'view' => Pages\ViewDeliveryTracking::route('/{record}'),
            'edit' => Pages\EditDeliveryTracking::route('/{record}/edit'),
        ];
    }
}
