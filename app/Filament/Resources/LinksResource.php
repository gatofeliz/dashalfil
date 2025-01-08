<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinksResource\Pages;
use App\Filament\Resources\LinksResource\RelationManagers;
use App\Models\Links;
use App\Models\User;
use App\Imports\LinksImport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\ButtonAction;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;


class LinksResource extends Resource
{
    protected static ?string $model = Links::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        // Aquí puedes poner la lógica para mostrar u ocultar el botón
        // Si lo quieres ocultar, simplemente retorna false
        return false;
    }

    public function getHeaderActions(): array
    {
        return [
            ButtonAction::make('Ir a mi página')
                ->label('Ir a mi página')
                ->color('primary')
                ->url(route('/')) // Conecta con la URL de la ruta
                ->icon('heroicon-o-link')
                ->openUrlInNewTab() // Opcional, abre en una nueva pestaña
        ];
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Select::make('userId')
                ->label('Usuario') // Etiqueta visible para el usuario
                ->options(User::pluck('name', 'id'))
                ->required(),
                Components\FileUpload::make('excel_file')
                ->label('Archivo Excel')
                ->required()
                ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/csv'])
                ->directory('excel_files')
                ->disk('public')            // Establecer el disco para el almacenamiento (puedes usar 'public' si deseas acceso público)
                ->preserveFilenames()
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = auth()->user();

        $definition = $table
            ->columns([
                TextColumn::make('user.name') // Columna basada en el campo "name"
                ->label('Nombre') // Etiqueta que se muestra en la tabla
                ->sortable() // Permitir ordenamiento
                ->searchable(), // Permitir búsqueda
                TextColumn::make('link') // Columna basada en el campo "name"
                ->label('Link') // Etiqueta que se muestra en la tabla
                ->sortable() // Permitir ordenamiento
                ->searchable(), // Permitir búsqueda
                TextColumn::make('offer') // Columna basada en el campo "name"
                ->label('Oferta') // Etiqueta que se muestra en la tabla
                ->sortable() // Permitir ordenamiento
                ->searchable(), // Permitir búsqueda
                
            ])
            ->filters([
                //
            ])
            ->actions([
                CopyAction::make()->copyable(fn ($record) => $record->link),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);

        if (!$user->hasRole(['admin', 'asignador'])) {
            $definition->modifyQueryUsing(fn (Builder $query) => 
                $query
                    ->withoutGlobalScopes()
                    ->where('user_id', '=', $user->id)
            );
        }

        return $definition;
    }

    public function getUserName()
    {
        dd(auth()->user()->name);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        
        $user = auth()->user();

        // Comprobar si el rol es 2
        if ($user && $user->rol == 2) {
            // Si el rol es 2, solo permite la página de index
            return [
                'index' => Pages\ListLinks::route('/'),
            ];
        }
        return [
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLinks::route('/create'),
            'edit' => Pages\EditLinks::route('/{record}/edit'),
        ];
    }
}
