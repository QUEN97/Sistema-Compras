<div class="" id="">

    <button wire:click="confirmEstacionEdit({{ $estacion_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="EditEstacion{{ $estacion_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>

    <x-dialog-modal wire:model="EditEstacion" id="EditEstacion{{ $estacion_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Editar Estación') }}
        </x-slot>

        <x-slot name="content">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Nombre de la Estación') }}" />
                        <x-input wire:model="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                            name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Zona') }}" />
                        <select id="zona" wire:model="zona"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('zona') ? 'is-invalid' : '' }}"
                            name="zona" required aria-required="true">
                            <option value="">Seleccionar Zona</option>
                            @foreach ($zonas as $zonal)
                                <option value="{{ $zonal->id }}"
                                    @if ($zona == $zonal->id) {{ 'selected' }} @endif>
                                    {{ $zonal->name }}</option>
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
                            @if ($this->isSuper == null)
                                <option hidden value="" selected>Seleccionar
                                    Supervisor</option>
                            @else
                                <option hidden value="" selected>Seleccionar
                                    Supervisor</option>
                                @foreach ($this->isSuper as $supervisorl)
                                    <option value="{{ $supervisorl->id }}"
                                        @if ($supervisor == $supervisorl->id) {{ 'selected' }} @endif>
                                        {{ $supervisorl->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <x-input-error for="supervisor"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Gerente') }}" />
                        <select id="gerente" wire:model.defer="gerente"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('gerente') ? 'is-invalid' : '' }}"
                            name="gerente" required aria-required="true">
                            @if ($this->isGeren == null)
                                <option hidden value="" selected>Seleccionar Gerente
                                </option>
                            @else
                                <option hidden value="" selected>Seleccionar Gerente
                                </option>
                                @foreach ($this->isGeren as $gerentel)
                                    <option value="{{ $gerentel->id }}"
                                        @if ($gerente == $gerentel->id) {{ 'selected' }} @endif>
                                        {{ $gerentel->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <x-input-error for="gerente"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Status') }}" />
                        <select id="status" wire:model="status"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('status') ? 'is-invalid' : '' }}"
                            name="status" required aria-required="true">
                            <option hidden value="">Seleccionar Status</option>
                            <option value="Activo" @if ($status == 'Activo') {{ 'selected' }} @endif>
                                Activo</option>
                            <option value="Inactivo" @if ($status == 'Inactivo') {{ 'selected' }} @endif>
                                Inactivo</option>
                        </select>
                        <x-input-error for="status"></x-input-error>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="EditarEstacion({{ $estacion_id }})"
                wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('EditEstacion')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
