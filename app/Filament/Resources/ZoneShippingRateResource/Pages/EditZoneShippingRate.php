<?php

namespace App\Filament\Resources\ZoneShippingRateResource\Pages;

use App\Filament\Resources\ZoneShippingRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditZoneShippingRate extends EditRecord
{
    protected static string $resource = ZoneShippingRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
