<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button class="btn-sm" wire:click="showModalFormPermiso">
            <i class="fa-solid fa-plus"></i>
            {{ __('Nuevo Rol') }}
        </x-button>
    </div>

    <x-dialog-modal wire:model="newgPermiso" id="modalPermiso" class="flex items-center">
        <x-slot name="title">
            {{ 'Nuevo Rol' }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-wrap">
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Nombre:') }}" />
                    <x-input wire:model="titulo_permiso"
                        class="{{ $errors->has('titulo_permiso') ? 'is-invalid' : '' }}" type="text"
                        name="titulo_permiso" :value="old('titulo_permiso')" maxlength="30" required autofocus
                        autocomplete="titulo_permiso" />
                    <x-input-error for="titulo_permiso"></x-input-error>
                </div>
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Descripción:') }}" />
                    <textarea wire:model="descripcion" id="descripcion" class="resize-none rounded-md{{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion"
                        required autofocus autocomplete="descripcion"  maxlength="200"></textarea>
                <x-input-error for="descripcion"></x-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addPermiso" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgPermiso')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
