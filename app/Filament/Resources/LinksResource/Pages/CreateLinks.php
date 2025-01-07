<?php

namespace App\Filament\Resources\LinksResource\Pages;

use App\Filament\Resources\LinksResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LinksImport;
use League\Csv\Reader;

class CreateLinks extends CreateRecord
{
    protected static string $resource = LinksResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $csv = Reader::createFromPath(storage_path('app/public/excel_files/datos.csv'), 'r');
        $csv->setHeaderOffset(0); // Si el archivo tiene cabecera
        $userId = $data['userId']; // Obtener el ID del usuario

        // Procesar las filas del CSV y crear registros
        $import = new LinksImport($userId);
        foreach ($csv as $row) {
            $import->model($row);
        }

        // Retorna solo los datos del formulario sin insertar duplicados
        return $data;
    }

}
