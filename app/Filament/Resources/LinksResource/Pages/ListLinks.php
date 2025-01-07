<?php

namespace App\Filament\Resources\LinksResource\Pages;

use App\Filament\Resources\LinksResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Imports\LinksImporter;
use Filament\Actions\ImportAction;
use EightyNine\ExcelImport\ExcelImportAction; // Asegúrate de esta línea

class ListLinks extends ListRecords
{
    protected static string $resource = LinksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }
}
