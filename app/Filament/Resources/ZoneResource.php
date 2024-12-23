<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ZoneResource\Pages;
use App\Models\Zone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Nnjeim\World\World;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ZoneResource extends Resource
{
    protected static ?string $model = Zone::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Shipping';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('countries')
                    ->multiple()
                    ->options(function () {
                        try {
                            $response = World::countries();

                            if ($response->success && isset($response->data)) {
                                return collect($response->data)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            }

                            Log::error('World package countries response empty or invalid', [
                                'response' => $response
                            ]);

                            return [];
                        } catch (\Exception $e) {
                            Log::error('Error fetching countries from World package', [
                                'error' => $e->getMessage()
                            ]);

                            return [];
                        }
                    })
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('cities', []);
                    }),

                Forms\Components\Select::make('cities')
                    ->multiple()
                    ->options(function (callable $get) {
                        $selectedCountries = $get('countries');

                        if (empty($selectedCountries)) {
                            return [];
                        }

                        try {
                            $allCities = collect();

                            foreach ($selectedCountries as $countryId) {
                                $response = World::cities([
                                    'filters' => ['country_id' => $countryId]
                                ]);

                                if ($response->success && isset($response->data)) {
                                    $allCities = $allCities->merge($response->data);
                                }
                            }

                            return $allCities
                                ->pluck('name', 'id')
                                ->toArray();
                        } catch (\Exception $e) {
                            Log::error('Error fetching cities from World package', [
                                'error' => $e->getMessage(),
                                'countries' => $selectedCountries
                            ]);

                            return [];
                        }
                    })
                    ->searchable()
                    ->preload()
                    ->visible(fn(callable $get) => !empty($get('countries')))
                    ->helperText('Select cities for the chosen countries'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('countries')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) return '';

                        try {
                            return collect($state)->map(function ($countryId) {
                                $response = World::countries([
                                    'filters' => ['id' => $countryId]
                                ]);

                                if ($response->success && isset($response->data[0])) {
                                    return $response->data[0]->name;
                                }

                                return $countryId;
                            })->join(', ');
                        } catch (\Exception $e) {
                            Log::error('Error formatting countries in table', [
                                'error' => $e->getMessage(),
                                'state' => $state
                            ]);

                            return '';
                        }
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('cities')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) return '';

                        try {
                            return collect($state)->map(function ($cityId) {
                                $response = World::cities([
                                    'filters' => ['id' => $cityId]
                                ]);

                                if ($response->success && isset($response->data[0])) {
                                    return $response->data[0]->name;
                                }

                                return $cityId;
                            })->join(', ');
                        } catch (\Exception $e) {
                            Log::error('Error formatting cities in table', [
                                'error' => $e->getMessage(),
                                'state' => $state
                            ]);

                            return '';
                        }
                    })
                    ->searchable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListZones::route('/'),
            'create' => Pages\CreateZone::route('/create'),
            'edit' => Pages\EditZone::route('/{record}/edit'),
        ];
    }
}
