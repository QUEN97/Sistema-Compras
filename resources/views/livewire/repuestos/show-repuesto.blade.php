<div>

    <button wire:click="confirmShowRepuesto({{ $repuesto_show_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="ShowRepuesto{{ $repuesto_show_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>

    <x-dialog-modal wire:model="ShowgRepuesto" class="flex items-center">
        <x-slot name="title">
            {{ __('Información General del Repuesto Solicitado') }}
        </x-slot>
        <x-slot name="content" class="relative">
            <div class="flex flex-wrap justify-evenly gap-3">
                <div>
                    <div class="flex gap-2">
                        <x-label value="{{ __('Producto:') }}" />
                        <label>{{ $this->name }}</label>
                    </div>
                    <div class="flex gap-2">
                        <x-label value="{{ __('Cantidad:') }}" />
                        <label> {{ $this->cantidad }}</label>
                    </div>
                    <div class="flex gap-2">
                        <x-label value="{{ __('Estacion:') }}" />
                        <label> {{ $this->titulo_estacion }}</label>
                    </div>
                </div>
                <div>
                    <x-label value="{{ __('Fecha de Registro') }}" />
                    <label>{{ $this->created_at }}</label>
                </div>
            </div>
            <div class="py-2">
                <x-label value="{{ __('Descripción') }}" />
                <textarea readonly class="resize-none w-full rounded-md">
                    {{ $this->descripcion }}
                </textarea>
            </div>
            @if ($observaciones)
                <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                    <details>
                        <summary class="bg-gray-100 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                            Historial de Observaciones para este Repuesto</summary>
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Id</th>
                                    <th class="px-4 py-2">Observación</th>
                                    <th class="px-4 py-2">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($observaciones as $observa)
                                    <tr>
                                        <td class="border px-4 py-2">
                                            <span class="text-xs"> # {{ $observa->id }}</span>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <span class="text-xs"> {{ $observa->observacion }} </span>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <span class="text-xs">
                                                {{ $observa->created_format }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="border px-4 py-2" colspan="3">Sin datos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </details>
                </div>
            @endif
            @if ($repuestos->archivos->isnotEmpty())
                <div class="pt-2">
                    <label class="flex justify-center gap-3 border-b border-amber-600 items-center text-amber-600 p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="16" height="16"
                            viewBox="0 0 576 512">
                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z" />
                        </svg>
                        {{ __('Archivos de Evidencia Subidos') }}
                    </label>
                    <div class="flex justyfy-venly flex-wrap gap-3 py-2">
                        @foreach ($repuestos->archivos as $archivo)
                            @if ($archivo->flag_trash == 0)
                                <div class="col-3">
                                    @if ($archivo->mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                        <a href="{{ asset('storage/' . $archivo->archivo_path) }}" download=""
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Descargar"
                                            class="text-xs">
                                            <figure class="d-inline-block max-w-[40px]" tabindex="0"
                                                data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                data-bs-content="Presione para descargar" data-bs-placement="top">
                                                <img class="w-100" src="{{ asset('img/icons/word-2019.svg') }}">
                                                <p> {{ $archivo->nombre_archivo }} </p>
                                                @if (strlen($archivo->size) == 4)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 1) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 5)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 2) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 6)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 3) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 7)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 1) . ' ' . 'MB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 8)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 2) . ' ' . 'MB') }}
                                                    </p>
                                                @endif
                                            </figure>
                                        </a>
                                    @elseif ($archivo->mime_type == 'application/pdf')
                                        <a href="{{ asset('storage/' . $archivo->archivo_path) }}" download=""
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Descargar"
                                            class="text-xs">
                                            <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                data-bs-content="Presione para descargar" data-bs-placement="top">
                                                <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                                <p> {{ $archivo->nombre_archivo }} </p>
                                                @if (strlen($archivo->size) == 4)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 1) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 5)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 2) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 6)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 3) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 7)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 1) . ' ' . 'MB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 8)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 2) . ' ' . 'MB') }}
                                                    </p>
                                                @endif
                                            </figure>
                                        </a>
                                    @elseif (
                                        $archivo->mime_type == 'image/png' ||
                                            $archivo->mime_type == 'image/jpg' ||
                                            $archivo->mime_type == 'image/jpeg' ||
                                            $archivo->mime_type == 'image/webp')
                                        <a href="{{ asset('storage/' . $archivo->archivo_path) }}"
                                            data-lightbox="imagenes-show-{{ $archivo->repuesto_id }}"
                                            data-title="{{ $archivo->nombre_archivo }}" class="text-xs">
                                            <figure class="d-inline-block max-w-[120px]" tabindex="0"
                                                data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                data-bs-content="Presione para visualizar" data-bs-placement="top">
                                                <img class="w-100"
                                                    src="{{ asset('storage/' . $archivo->archivo_path) }}">
                                                <p> {{ $archivo->nombre_archivo }} </p>
                                                @if (strlen($archivo->size) == 4)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 1) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 5)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 2) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 6)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 3) . ' ' . 'KB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 7)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 1) . ' ' . 'MB') }}
                                                    </p>
                                                @elseif (strlen($archivo->size) == 8)
                                                    <p>
                                                        {{ __(substr($archivo->size, 0, 2) . ' ' . 'MB') }}
                                                    </p>
                                                @endif
                                            </figure>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('ShowgRepuesto')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
