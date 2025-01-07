<?php

namespace App\Filament\Resources\LinksResource\Pages;

use App\Filament\Resources\LinksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLinks extends EditRecord
{
    protected static string $resource = LinksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
