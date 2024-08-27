<?php

namespace App\Filament\Resources\PropertyTypesResource\Pages;

use App\Filament\Resources\PropertyTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyTypes extends EditRecord
{
    protected static string $resource = PropertyTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
