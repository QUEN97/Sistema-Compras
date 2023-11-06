<div >
    <x-button class="float-right" wire:click="showModalFormZona">
        <i class="fa-solid fa-user-plus"></i>
        {{ __('Nueva Zona') }}
    </x-button>

    <x-dialog-modal wire:model="newgZona" id="modalZona" class="flex items-center">
        <x-slot name="title">
            Nueva Zona
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-wrap">
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Nombre') }}" />
    
                    <x-input wire:model="name" class="uppercase {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                        name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error for="name"></x-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addZona" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgZona')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
