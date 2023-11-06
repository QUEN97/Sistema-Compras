<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">

    <div class="">
        <x-button class="float-right" wire:click="showModalFormEstacion">
            <i class="fa-solid fa-plus"></i>
            {{ __('Nueva Estación') }}
        </x-button>
    </div>

    <x-dialog-modal wire:model="newgEstacion" id="modalEstacion" class="flex items-center">
        <x-slot name="title">
            Nueva Estación
        </x-slot>

        <x-slot name="content">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Nombre de la Estación') }}" />
                        <x-input wire:model="name" class="uppercase border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Zona') }}" />
                        <select id="zona" wire:model="zona"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('zona') ? 'is-invalid' : '' }}"
                            name="zona" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Zona</option>
                            @foreach ($zonas as $zona)
                                @if ($zona->status == 'Activo')
                                    <option value="{{ $zona->id }}">
                                        {{ $zona->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error for="zona"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">

                        <x-label value="{{ __('Supervisor') }}" />
                        <select id="supervisor" wire:model.defer="supervisor"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('supervisor') ? 'is-invalid' : '' }}"
                            name="supervisor" required aria-required="true">
                            @if ($this->isSuper )
                            <option hidden value="" selected>Seleccionar
                                Supervisor</option>
                            @foreach ($this->isSuper as $superviso)
                                <option value="{{ $superviso->id }}">
                                    {{ $superviso->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <x-input-error for="supervisor"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Gerente') }}" />
                        <select id="gerente" wire:model.defer="gerente"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('gerente') ? 'is-invalid' : '' }}"
                            name="gerente" required aria-required="true">
                            @if ($this->isGeren == null)
                            <option hidden value="" selected>Seleccionar Gerente
                            </option>
                        @else
                            <option hidden value="" selected>Seleccionar Gerente
                            </option>
                            @foreach ($this->isGeren as $gerent)
                                @if ($gerent->estacion == null)
                                    <option value="{{ $gerent->id }}">
                                        {{ $gerent->name }}</option>
                                @else
                                    <option hidden value="" selected>Seleccionar
                                        Gerente</option>
                                @endif
                            @endforeach
                        @endif
                        </select>
                        <x-input-error for="gerente"></x-input-error>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addEstacion" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgEstacion')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>

