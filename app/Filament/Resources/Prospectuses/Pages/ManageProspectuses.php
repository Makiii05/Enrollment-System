<?php

namespace App\Filament\Resources\Prospectuses\Pages;

use App\Filament\Resources\Prospectuses\ProspectusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProspectuses extends ManageRecords
{
    protected static string $resource = ProspectusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
