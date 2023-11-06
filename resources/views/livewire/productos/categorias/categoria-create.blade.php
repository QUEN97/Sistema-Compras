<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button class="float-right" wire:click="showModalFormCategoria">
            <i class="fa-solid fa-plus"></i>
            {{ __('Nueva Categoria') }}
        </x-button>
    </div>

    <x-dialog-modal wire:model="newgCategoria" id="modalCategoria" class="flex items-center">
        <x-slot name="title">
            {{ __('Nueva Categoria') }}
        </x-slot>

        <x-slot name="content">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Nombre de la Categoria') }}" />
                        <x-input wire:model="name" class="uppercase {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            type="text" name="name" :value="old('name')" required autofocus  />
                        <x-input-error for="name"></x-input-error>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addCategoria" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgCategoria')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
