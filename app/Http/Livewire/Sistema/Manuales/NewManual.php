<?php

namespace App\Http\Livewire\Sistema\Manuales;

use Livewire\Component;
use App\Models\Manual;
use App\Models\Panel;
use App\Models\Permiso;
use App\Models\ManualPermiso;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewManual extends Component
{
    use WithFileUploads;

    public $newgManual, $manual, $panel;
    public $permis = [];

    public function resetFilters()
    {
        $this->reset(['manual', 'panel', 'permis']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->newgManual = false;
    }

    public function showModalFormManual()
    {
        $this->resetFilters();

        $this->newgManual=true;
    }

    public function addManual()
    {
        $this->validate( [
            'panel' => ['required', 'not_in:0'],
            'permis' => ['required'],
            'manual' => 'required|max:5024|file|mimetypes:application/pdf',
        ],
        [
            'panel.required' => 'El campo Panel es obligatorio',
            'permis.required' => 'Debes elegir un permiso',
            'manual.max' => 'El archivo no debe ser mayor a 5 MB',
            'manual.required' => 'El campo Manual es obligatorio',
            'manual.mimetypes' => 'Solo se aceptan archivos con extensión .pdf',
        ]);

        $this->urlArchi = $this->manual->storeAs('manuales-pdfs', $this->manual->getClientOriginalName(), 'public');

        DB::transaction(function () {
            return tap(Manual::create([
                'panel_id' => $this->panel,
                'titulo_manual' => $this->manual->getClientOriginalName(),
                'manual_path' => $this->urlArchi,
                'size' => $this->manual->getSize(),
                'flag_trash' => 0,
            ]));
        });

        $ultid = Manual::latest('id')->first();

        foreach ($this->permis as $key => $value) {
            ManualPermiso::create([
                'manual_id' => $ultid->id,
                'permiso_id' => $value,
                'flag_trash' => 0,
            ]);
        }

        $this->mount();

        Alert::success('Nuevo Manual', "El Manual". ' '.$ultid->titulo_manual. ' '. "ha sido subido al sistema");

        return redirect()->route('manuales');
    }

    public function render()
    {
        $this->paneles = Auth::user()->permiso->panels;

        $this->permisos = Permiso::all();

        return view('livewire.sistema.manuales.new-manual');
    }
}
