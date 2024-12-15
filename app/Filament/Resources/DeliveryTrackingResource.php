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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
