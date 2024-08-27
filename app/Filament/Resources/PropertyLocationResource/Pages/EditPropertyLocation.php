<?php

namespace App\Filament\Resources\PropertyLocationResource\Pages;

use App\Filament\Resources\PropertyLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyLocation extends EditRecord
{
    protected static string $resource = PropertyLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
