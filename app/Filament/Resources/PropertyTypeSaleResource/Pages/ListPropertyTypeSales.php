<?php

namespace App\Filament\Resources\PropertyTypeSaleResource\Pages;

use App\Filament\Resources\PropertyTypeSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyTypeSales extends ListRecords
{
    protected static string $resource = PropertyTypeSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
