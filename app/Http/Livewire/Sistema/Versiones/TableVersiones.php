<?php

namespace App\Http\Livewire\Sistema\Versiones;

use Livewire\Component;
use App\Models\Version;

class TableVersiones extends Component
{
    public function render()
    {
        $this->versions = Version::where('flag_trash', 0)->orderBy('created_at', 'desc')->get();

        // foreach ($this->versions as $key => $value) {
        //     foreach ($value->panels as $key => $vue) {
        //         dd($vue->pivot->subdescripcionversions);
        //     }
        // }

        return view('livewire.sistema.versiones.table-versiones');
    }
}
