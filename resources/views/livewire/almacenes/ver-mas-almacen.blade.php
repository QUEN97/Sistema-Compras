<div>
    @if (Auth::user()->permiso_id == 3)
        @if ($almaCe->flag_trash == 1)
            <button class="text-center rounded-lg p-4 bg-white dark:bg-dark-eval-3 dark:text-white  text-gray-700 font-bold text-lg" wire:click="confirmShowAlmacen({{ $almacen_show_id }})"
            wire:loading.attr="disabled" data-target="ShowAlma{{ $almacen_show_id }}">
                Ver más
            </button>
        @else
            <a class="text-center rounded-lg p-4 bg-white dark:bg-dark-eval-3 dark:text-white text-gray-700 font-bold text-lg"
                wire:click="confirmShowAlmacen({{ $almacen_show_id }})" role="button" wire:loading.attr="disabled"
                data-target="ShowAlma{{ $almacen_show_id }}">
                Ver más
            </a>
        @endif
        @else
        <button wire:click="confirmShowAlmacen({{ $almacen_show_id }})" wire:loading.attr="disabled"
            class="hover:scale-110 tooltip"
            data-target="ShowAlma{{ $almacen_show_id }}" type="button">
            @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
                @if (DB::table('folios_historials')->where('status', 'Solicitado')->where('estacion_producto_id', $almacen_show_id)->count() != 0)
                    <span
                        class="absolute top-0 right-0 -translate-y-2 inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-red-500 bg-red-300  rounded-full">
                        {{ DB::table('folios_historials')->where('status', 'Solicitado')->where('estacion_producto_id', $almacen_show_id)->count() }}
                        <span class="hidden">Solicitudes sin responder</span>
                    </span>
                @endif
            @elseif (Auth::user()->permiso_id == 2 && Auth::user()->permiso_id != 3)
                @if (DB::table('folios_historials')->join('folios', 'folios_historials.folio_id', '=', 'folios.id')->where('folios.isentrada_issalida', '!=', 'Traspaso')->where('status', 'Solicitado')->where('estacion_producto_id', $almacen_show_id)->count() != 0)
                    <span
                        class="absolute top-0 right-0 -translate-y-2 inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-red-500 bg-red-300  rounded-full">
                        {{ DB::table('folios_historials')->join('folios', 'folios_historials.folio_id', '=', 'folios.id')->where('folios.isentrada_issalida', '!=', 'Traspaso')->where('status', 'Solicitado')->where('estacion_producto_id', $almacen_show_id)->count() }}
                        <span class="hidden">Solicitudes sin responder</span>
                    </span>
                @endif
            @endif
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-indigo-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="tooltiptext">Ver Más</span>
        </button>
    @endif


    <x-dialog-modal wire:model="ShowgAlmacen" id="ShowAlmacen{{ $almacen_show_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Información General del Producto Almacenado') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col justify-center items-center">
                <div class="grid grid-cols-2 w-full">
                    <div
                        class="flex flex-col justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:shadow-none">
                        <p class="text-sm text-gray-600 dark:bg-dark-eval-0 p-1 rounded-md">Producto:</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            <span class="uppercase">{{ $this->producto }}</span>
                        </p>
                    </div>
                    <div
                        class="flex flex-col justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:shadow-none">
                        <p class="text-sm text-gray-600 dark:bg-dark-eval-0 p-1 rounded-md">Estación:</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            <span class="uppercase">{{ $this->name }}</span>
                        </p>
                    </div>
                    <div
                        class="flex flex-col justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:shadow-none">
                        <p class="text-sm text-gray-600 dark:bg-dark-eval-0 p-1 rounded-md">Stock:</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            @if ($this->stock <=5)
                            <span class="uppercase text-red-500">{{ $this->stock }}</span>
                            @else
                            <span class="uppercase text-green-500">{{ $this->stock }}</span>
                            @endif
                        </p>
                    </div>
                    <div
                        class="flex flex-col justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:shadow-none">
                        <p class="text-sm text-gray-600 dark:bg-dark-eval-0 p-1 rounded-md">Fecha de registro:</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            <span class="uppercase">{{ $this->created_at }}</span>
                        </p>
                    </div>
                </div>
                @if ($this->foliosHisto)
                    <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                        <details>
                            <summary class="bg-gray-100 dark:bg-dark-eval-3 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                Historial de Entradas y Salidas de este Producto</summary>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 dark:bg-dark-eval-2">Id</th>
                                        <th class="px-4 py-2 dark:bg-dark-eval-2">Archivos</th>
                                        <th class="px-4 py-2 dark:bg-dark-eval-2">Cantidad</th>
                                        <th class="px-4 py-2 dark:bg-dark-eval-2">Folio</th>
                                        <th class="px-4 py-2 dark:bg-dark-eval-2">Operación</th>
                                        <th class="px-4 py-2 dark:bg-dark-eval-2">Status</th>
                                        @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
                                            @if ($this->stat == 'Solicitado')
                                                <th class="px-4 py-2">Opciones</th>
                                            @endif
                                        @elseif (Auth::user()->permiso_id == 2 && Auth::user()->permiso_id != 3)
                                            @if ($this->stat == 'Solicitado' && $this->traspa != 'Traspaso')
                                                <th class="px-4 py-2">Opciones</th>
                                            @endif
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($this->foliosHisto as $histo)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $histo->id }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <form method="post" action="">
                                                    <div align="center">
                                                        <p>
                                                            <select name="select" size="1" select
                                                                class="block w-full p-1 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                style="FONT-SIZE: 12px; "
                                                                onChange="window.open(this.options[this.selectedIndex].value,'_blank')">
                                                                <option hidden value="" selected>Archivos
                                                                </option>
                                                                @if ($histo->folio->isentrada_issalida == 'Entrada' || $histo->folio->isentrada_issalida == 'Salida')
                                                                    <option
                                                                        value="{{ asset('storage/entradas-salidas-pdfs/' . $histo->folio->pdf) }}">
                                                                        Evidencia PDF
                                                                    </option>
                                                                    <option
                                                                        value="{{ asset('storage/evidencias-almacen/' . $histo->archivosfohisto->path_remision) }}">
                                                                        Nota de Remisión
                                                                    </option>
                                                                    @if ($histo->archivosfohisto->path_condiciones != null)
                                                                        <option
                                                                            value="{{ asset('storage/evidencias-almacen/' . $histo->archivosfohisto->path_condiciones) }}">
                                                                            Condiciones del Equipo
                                                                        </option>
                                                                    @endif
                                                                @elseif ($histo->folio->isentrada_issalida == 'Traspaso')
                                                                    <option
                                                                        value="{{ asset('storage/entradas-salidas-pdfs/' . $histo->folio->pdf) }}">
                                                                        Evidencia PDF
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        </p>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $histo->cantidad }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs">{{ $histo->folio->folio }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                @if ($histo->folio->isentrada_issalida == 'Entrada')
                                                    <div style="display: flex; justify-content: center;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4 text-green-500">
                                                        <path fill-rule="evenodd"
                                                            d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M19 10a.75.75 0 00-.75-.75H8.704l1.048-.943a.75.75 0 10-1.004-1.114l-2.5 2.25a.75.75 0 000 1.114l2.5 2.25a.75.75 0 101.004-1.114l-1.048-.943h9.546A.75.75 0 0019 10z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs">{{ $histo->folio->isentrada_issalida }}</span>
                                                    </div>
                                                @elseif ($histo->folio->isentrada_issalida == 'Salida')
                                                    <div style="display: flex; justify-content: center;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4 text-red-600">
                                                        <path fill-rule="evenodd"
                                                            d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M6 10a.75.75 0 01.75-.75h9.546l-1.048-.943a.75.75 0 111.004-1.114l2.5 2.25a.75.75 0 010 1.114l-2.5 2.25a.75.75 0 11-1.004-1.114l1.048-.943H6.75A.75.75 0 016 10z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs">{{ $histo->folio->isentrada_issalida }}</span>
                                                    </div>
                                                @elseif ($histo->folio->isentrada_issalida == 'Traspaso')
                                                    <div style="display: flex; justify-content: center;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4 text-blue-500">
                                                        <path fill-rule="evenodd"
                                                            d="M13.2 2.24a.75.75 0 00.04 1.06l2.1 1.95H6.75a.75.75 0 000 1.5h8.59l-2.1 1.95a.75.75 0 101.02 1.1l3.5-3.25a.75.75 0 000-1.1l-3.5-3.25a.75.75 0 00-1.06.04zm-6.4 8a.75.75 0 00-1.06-.04l-3.5 3.25a.75.75 0 000 1.1l3.5 3.25a.75.75 0 101.02-1.1l-2.1-1.95h8.59a.75.75 0 000-1.5H4.66l2.1-1.95a.75.75 0 00.04-1.06z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs">{{ $histo->folio->isentrada_issalida }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">
                                                @if ($histo->status == 'Aprobado')
                                                    <div style="display: flex; justify-content: center;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4 text-green-500">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs">{{ $histo->status }}</span>
                                                    </div>
                                                @elseif ($histo->status == 'Rechazado')
                                                    <div style="display: flex; justify-content: center;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4 text-red-500">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs">{{ $histo->status }}</span>
                                                    </div>
                                                @elseif ($histo->status == 'Solicitado')
                                                    <div style="display: flex; justify-content: center;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4 text-blue-500">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h4.59l-2.1 1.95a.75.75 0 001.02 1.1l3.5-3.25a.75.75 0 000-1.1l-3.5-3.25a.75.75 0 10-1.02 1.1l2.1 1.95H6.75z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs">{{ $histo->status }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            @if (Auth::user()->permiso_id != 3 && $histo->status == 'Solicitado' && $histo->folio->isentrada_issalida != 'Traspaso')
                                                <td class="border px-4 py-2">
                                                    <button class="tooltip" data-target="AprobarAlma"
                                                     wire:click="acepEntradaSali({{ $histo->id }}, {{ $histo->cantidad }}, '{{ $histo->folio->isentrada_issalida }}', {{ $histo->estacion_producto_id }}, '{{ $histo->folio->folio }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4 text-green-500">
                                                            <path fill-rule="evenodd"
                                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="tooltiptext">Aprobar</span>
                                                    </button>

                                                    <button class="tooltip" data-target="RechazarAlma"
                                                        wire:click="rechaEntradaSali({{ $histo->id }}, '{{ $histo->folio->folio }}', {{ $histo->estacion_producto_id }}, '{{ $histo->folio->isentrada_issalida }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4 text-red-500">
                                                            <path
                                                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                                        </svg>
                                                        <span class="tooltiptext">Rechazar</span>
                                                    </button>
                                                </td>
                                            @elseif (Auth::user()->permiso_id != 2 &&
                                                    Auth::user()->permiso_id != 3 &&
                                                    $histo->status == 'Solicitado' &&
                                                    $histo->folio->isentrada_issalida == 'Traspaso')
                                                <td class="border px-4 py-2">
                                                    <button class="btn btn-info" data-target="AprobarTrasp"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Aprobar Traspaso"
                                                        wire:click="acepTraspaso({{ $histo->id }}, {{ $histo->cantidad }}, '{{ $histo->folio->isentrada_issalida }}', {{ $histo->estacion_producto_id }}, '{{ $histo->folio->folio }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4 text-green-500">
                                                            <path fill-rule="evenodd"
                                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>

                                                    <button class="tooltip" data-target="RechazarAlma"
                                                        wire:click="rechaEntradaSali({{ $histo->id }}, '{{ $histo->folio->folio }}', {{ $histo->estacion_producto_id }}, '{{ $histo->folio->isentrada_issalida }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4 text-red-500">
                                                            <path
                                                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                                        </svg>
                                                        <span class="tooltiptext">Rechazar</span>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="7">Sin datos.</td>
                                        </tr>
                                    @endforelse
                                   
                                </tbody>
                            </table>
                            @endif
                        </details>
                    </div>

            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgAlmacen')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
