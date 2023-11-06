<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PassResset extends Component
{
    public $confirminpassReset;

    public function mount(){
        $this->confirminpassReset=false;
    }

    public function show(){
        $this->confirminpassReset=true;
    }

    public function render()
    {
        return view('livewire.pass-resset');
    }
}
