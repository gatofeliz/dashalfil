<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Links;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads; // 👈 Importa el trait para subir archivos

class ImportLinks extends Component
{
    use WithFileUploads; // 👈 Usa el trait para habilitar las subidas de archivos

    public $users;
    public $userOption;
    public $file;

    public function mount(){
        $this->users = User::all()->filter->hasRole('espectador');
    }

    public function render()
    {
        return view('livewire.import-links');
    }

    public function save()
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:2048', // Validación del archivo
            'userOption' => 'required', // Validar que la opción de usuario esté seleccionada
        ]);
        
        // Leer el archivo Excel
        $datos = Excel::toArray(null, $this->file);

        // Procesar las filas
        $this->mensaje = ''; // Limpiar mensaje
        $enviarDato = false;

        foreach ($datos[0] as $fila) {
            // Saltar encabezados
            if ($fila[0] == 'Link' || $fila[1] == 'Oferta') {
                continue;
            }
            if($fila[0] == null || $fila[1] == null || $fila[0] == '' || $fila[1] == '') {
                continue;
            }

            Links::create([
                'link' => $fila[0],
                'offer' => $fila[1],
                'user_id' => $this->userOption
            ]);
        }

        return redirect()->route('filament.dashboard.resources.links.index'); // Redirige a la lista de usuarios
    }
}
