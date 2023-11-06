<?php

namespace App\Http\Livewire\Sistema\Versiones;

use Livewire\Component;
use App\Models\Panel;
use App\Models\Version;
use App\Models\SubDescripcionVersion;
use App\Models\PanelVersion;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class NewVersion extends Component
{
    public $newgVersion;
    public $titulo_version, $panel, $catego, $descripcion, $version, $released;
    public $inputs = [];
    public $pan = [];
    public $inputCat = [];
    public $i = 1;
    public $j = 1;
    public $h = 1;

    public function resetFilters()
    {
        $this->reset(['titulo_version', 'panel', 'catego', 'descripcion', 'version', 'released']);
    
        $this->inputs = [];
    }

    public function mount()
    {
        $this->resetFilters();

        $this->newgVersion = false;
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }
 
    public function remove($i, $te)
    {
        unset($this->inputs[$i]);
        unset($this->catego[$te]);
    }

    public function addPanel($j)
    {
        $j = $j + 1;
        $this->j = $j;
        array_push($this->pan ,$j);
    }

    public function addCat($h)
    {
        $h = $h + 1;
        $this->h = $h;
        array_push($this->inputCat ,$h);
    }

    public function removePanel($j, $je)
    {
        unset($this->pan[$j]);
        unset($this->inputCat[$j]);
        unset($this->catego[$je]);
    }
 
    public function removeCat($h, $he)
    {
        unset($this->inputCat[$h]);
        unset($this->catego[$he]);
    }

    public function showModalFormVersion()
    {
        $this->resetFilters();

        $this->newgVersion=true;
    }

    public function addVersion()
    {
        $this->validate([
            'titulo_version' => ['required', 'string', 'max:50'],
            'version' => ['required', 'string', 'max:20'],
            'released' => ['required', 'not_in:0'],
            'panel.1' => ['required', 'not_in:0'],
            'catego.1.1' => ['required', 'not_in:0'],
            'descripcion.1.1' => ['required', 'not_in:0'],
            'catego.1.*' => ['required', 'not_in:0'],
            'descripcion.1.*' => ['required', 'not_in:0'],
            'panel.*' => ['required', 'not_in:0'],
            'catego.*.*' => ['required', 'not_in:0'],
            'descripcion.*.*' => ['required', 'not_in:0'],
        ],[
            'titulo_version.required' => 'EL titulo para la versión es requerido',
            'titulo_version.string' => 'El titulo debe ser sólo texto',
            'titulo_version.max'=>'El titulo no debe contener más de 50 caracteres',
            'version.required' => 'Ingrese la nueva version',
            'released.required'=>'Seleccione un opción',
            'panel.1.required' =>'Seleccione un módulo',
            'panel.*.required' =>'Seleccione un módulo',
            'catego.1.1.required' =>'Seleccione el tipo de actualizacion del módulo',
            'catego.1.*.required' =>'Seleccione el tipo de actualizacion del módulo',
            'catego.*.*.required' =>'Seleccione el tipo de actualizacion del módulo',
            'descripcion.1.1.required' => 'Ingrese una descripción',
            'descripcion.1.*.required' => 'Ingrese una descripción',
            'descripcion.*.*.required' => 'Ingrese una descripción'
        ]);

        DB::transaction(function () {

            $ultVer = Version::latest('id')->first();

            $ultVer->forceFill([
                'status' => 'Antiguo'
            ])->save();

            Version::create([
                'titulo_version' => $this->titulo_version,
                'version' => $this->version,
                'status' => $this->released,
                'flag_trash' => 0,
            ]);

            $ultId = Version::latest('id')->first();

            //dd($this->catego);
            foreach ($this->panel as $key => $pan) {

                PanelVersion::create([
                    'version_id' => $ultId->id,
                    'panel_id' => $this->panel[$key],
                ]);

                $ultVerId = PanelVersion::latest('id')->first();

                foreach ($this->catego[$key] as $keyC => $cat) {
                    SubDescripcionVersion::create([
                        'panel_version_id' => $ultVerId->id,
                        'categoria' => $cat,
                        'descripcion' => $this->descripcion[$key][$keyC],
                    ]);
                }
            }
        });
        return redirect()->route('versiones');
    }

    public function render()
    {
        $this->panels = Panel::all();

        return view('livewire.sistema.versiones.new-version');
    }
}