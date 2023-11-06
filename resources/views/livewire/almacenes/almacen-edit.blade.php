<div>

    <button wire:click="confirmAlmacenEdit({{ $almacen_edit_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="EditAlmacen{{ $almacen_edit_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-blue-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
        </svg>
        <span class="tooltiptext">Traspaso</span>
    </button>

    <x-dialog-modal wire:model="EditAlmacen" id="EditAlmacen{{ $almacen_edit_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Realizar Traspaso') }}
        </x-slot>

        <x-slot name="content">

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-3">
                    <x-label value="{{ __('Motivo') }}" />
                    <x-input wire:model="motivo"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                        type="text" name="motivo" :value="old('motivo')" required autofocus autocomplete="motivo" />
                    <x-input-error for="motivo"></x-input-error>
                </div>
                <div class="mb-3">
                    <x-label value="{{ __('Cantidad') }}" />
                    <x-input wire:model="cantidad"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                        type="text" name="cantidad" :value="old('cantidad')" required autofocus autocomplete="cantidad"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                    <x-input-error for="cantidad"></x-input-error>
                </div>
                @if (Auth::user()->permiso_id == 2)
                    <div class="mb-3">
                        <x-label value="{{ __('Estacion') }}" />
                        <select id="estacion" wire:model="estacion"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                            name="estacion" required aria-required="true">
                            <option hidden value="" selected>Seleccionar estacion</option>
                            @foreach ($allSuperStation as $estacion)
                                @if ($estacion->flag_trash == 0)
                                    <option value="{{ $estacion->id }}">{{ $estacion->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error for="estacion"></x-input-error>
                    </div>
                @elseif (Auth::user()->permiso_id != 3)
                    <div class="mb-3">
                        <x-label value="{{ __('Estacion') }}" />
                        <select id="estacion" wire:model="estacion"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                            name="estacion" required aria-required="true">
                            <option hidden value="" selected>Seleccionar estacion</option>
                            @foreach ($allStation as $estacio)
                                @if ($estacio->flag_trash == 0)
                                    <option value="{{ $estacio->id }}">{{ $estacio->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error for="estacion"></x-input-error>
                    </div>
                @endif
                <div class="mb-3">
                    <x-label value="{{ __('Observaciones') }}" />
                    <textarea wire:model="observacion"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 resize-none {{ $errors->has('observacion') ? 'is-invalid' : '' }} "
                        name="observacion" required autofocus autocomplete="observacion"></textarea>
                    <x-input-error for="observacion"></x-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="EditarAlmacen({{ $almacen_edit_id }})"
                wire:loading.attr="disabled">
                <div wire:loading wire:target="EditarAlmacen({{ $almacen_edit_id }})"
                    class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>

                {{ __('Aceptar') }}
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('EditAlmacen')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
