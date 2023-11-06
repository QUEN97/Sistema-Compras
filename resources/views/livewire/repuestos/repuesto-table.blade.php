<div
    class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md lg:flex-row md:justify-between dark:bg-dark-eval-1">
    <div class="w-full">
        <div class="grid grid-cols-2 mb-2 mt-2">
            <div class="ml-2">
                <form action="{{ route('solicitudes') }}" method="GET">
                    <label for="search" class="sr-only">
                        Search
                    </label>
                    <input type="text" name="s"
                        class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md dark:bg-dark-eval-0 dark:text-black"
                        placeholder="Buscar..." />
                </form>
            </div>
            <div class="mr-2">
                @if ($valid->pivot->de == 1)
                    <a class="inline-flex items-center px-3 py-2.5 text-sm font-medium text-center float-right text-white bg-gray-400 rounded-lg dark:bg-dark-eval-3"
                        href="{{ route('repuestos.trash') }}"">
                        Eliminados
                        <span
                            class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                            {{ $trash }}
                        </span>
                    </a>
                @endif
            </div>
        </div>
        {{-- Table --}}
        @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 4)
            <table
                class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-black">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Id</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Producto</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Imagen</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Estación</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Cantidad</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Status</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Fecha Registro</th>
                        @if ($isSuper->isnotEmpty() || $isGeren->isnotEmpty() || Auth::user()->permiso_id != 1)
                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                    Opciones</th>
                            @endif
                        @else
                            <th
                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                Opciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach ($allRepuesto as $allma)
                        @foreach ($allma->repuestos as $produc)
                            @if ($produc->flag_trash == 0)
                                <tr>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ $produc->id }}</div>
                                        </div>
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Producto</span>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ $produc->producto->name }}</div>
                                        </div>
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Imagen</span>
                                        @if ($produc->producto->product_photo_path == null)
                                            <img class="rounded-full" name="photo"
                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                style="height: 4rem;" />
                                        @else
                                            <img class="rounded-full" name="photo"
                                                src="{{ asset('storage/' . $produc->producto->product_photo_path) }}"
                                                style="height: 4rem;" />
                                        @endif
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Estación</span>
                                        {{ $produc->estacion->name }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Cantidad</span>
                                        {{ $produc->cantidad }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Status</span>
                                        @if ($produc->status == 'Solicitado a Compras')
                                            <span
                                                class="rounded bg-blue-200 py-1 px-3 text-xs text-blue-500 font-bold dark:bg-blue-600 dark:text-blue-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Solicitado al Supervisor')
                                            <span
                                                class="rounded bg-purple-200 py-1 px-3 text-xs text-purple-500 font-bold dark:bg-purple-600 dark:text-purple-200">
                                                {{ $produc->status }}
                                            </span>
                                            @elseif ($produc->status == 'Enviado a Administración')
                                            <span
                                                class="rounded bg-pink-200 py-1 px-3 text-xs text-pink-500 font-bold dark:bg-pink-600 dark:text-pink-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Repuesto Rechazado')
                                            <span
                                                class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold dark:bg-red-600 dark:text-red-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Repuesto Aprobado')
                                            <span
                                                class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold dark:bg-green-600 dark:text-green-200">
                                                {{ $produc->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Fecha</span>
                                        {{ $produc->created_format }}
                                    </td>
                                    @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                        <td
                                            class="w-full lg:w-auto p-3 text-gray-800  border border-b block lg:table-cell relative lg:static">
                                            <span
                                                class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                            <div style="display: flex; justify-content: center;">
                                                <div class="flex gap-2">
                                                    @if ($valid->pivot->vermas == 1)
                                                        @livewire('repuestos.show-repuesto', ['repuesto_show_id' => $produc->id])
                                                    @endif


                                                    @if ($produc->status != 'Solicitado al Supervisor' && $produc->status != 'Solicitado a Compras')
                                                        @if ($valid->pivot->ed == 1 && $produc->status != 'Repuesto Aprobado')
                                                            @livewire('repuestos.edit-repuesto', ['repuesto_id' => $produc->id])
                                                        @endif
                                                    @endif

                                                    @if ($produc->status != 'Solicitado al Supervisor' && $produc->status != 'Solicitado a Compras')
                                                        @if ($valid->pivot->de == 1)
                                                            @livewire('repuestos.repuesto-delete', ['repuestoID' => $produc->id])
                                                        @endif
                                                    @endif

                                                    @if ($produc->status != 'Repuesto Rechazado' && $produc->status != 'Repuesto Aprobado' && $produc->status != 'Solicitado a Compras')
                                                        @if ($produc->status != 'Solicitado al Supervisor' && $produc->status != 'Solicitado a Compras')
                                                            <button
                                                                wire:click="aceptarAdmin({{ $produc->id }})"
                                                                wire:loading.attr="disabled" class="tooltip">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor"
                                                                    class="w-6 h-6 text-gray-400 hover:text-green-500">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M4.5 12.75l6 6 9-13.5" />
                                                                </svg>
                                                                <span class="tooltiptext">Aceptar Repuesto</span>
                                                            </button>
                                                        @endif

                                                        @if ($produc->status != 'Solicitado al Supervisor')
                                                            @livewire('repuestos.observacion-rechazo-rpuesto', ['repuesto_id' => $produc->id])
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @elseif (Auth::user()->permiso_id == 4)
            <table id="table_repuestos"
                class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-black"
                style="width: 100%;">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Id</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Producto</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Imagen</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Estación</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Cantidad</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Status</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Fecha Registro</th>
                        @if ($isSuper->isnotEmpty() || $isGeren->isnotEmpty() || Auth::user()->permiso_id != 1)
                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                    Opciones</th>
                            @endif
                        @else
                            <th
                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                Opciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach ($isCompras as $compra)
                        @foreach ($compra->repuestos as $produc)
                            @if ($produc->flag_trash == 0)
                                <tr>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ $produc->id }}</div>
                                        </div>
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ $produc->producto->name }}</div>
                                        </div>
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Imagen</span>
                                        @if ($produc->producto->product_photo_path == null)
                                            <img class="rounded-full" name="photo"
                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                style="height: 4rem;" />
                                        @else
                                            <img class="rounded-full" name="photo"
                                                src="{{ asset('storage/' . $produc->producto->product_photo_path) }}"
                                                style="height: 4rem;" />
                                        @endif
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Estación</span>
                                        {{ $produc->estacion->name }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Cantidad</span>
                                        {{ $produc->cantidad }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                        @if ($produc->status == 'Solicitado a Compras')
                                            <span
                                                class="rounded bg-blue-200 py-1 px-3 text-xs text-blue-500 font-bold dark:bg-blue-600 dark:text-blue-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Solicitado al Supervisor')
                                            <span
                                                class="rounded bg-purple-200 py-1 px-3 text-xs text-purple-500 font-bold dark:bg-purple-600 dark:text-purple-200">
                                                {{ $produc->status }}
                                            </span>
                                            @elseif ($produc->status == 'Enviado a Administración')
                                            <span
                                                class="rounded bg-pink-200 py-1 px-3 text-xs text-pink-500 font-bold dark:bg-pink-600 dark:text-pink-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Repuesto Rechazado')
                                            <span
                                                class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold dark:bg-red-600 dark:text-red-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Repuesto Aprobado')
                                            <span
                                                class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold dark:bg-green-600 dark:text-green-200">
                                                {{ $produc->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                                        {{ $produc->created_format }}
                                    </td>
                                    @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                        <td
                                            class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span
                                                class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                            <div class="flex gap-2">
                                                @if ($valid->pivot->vermas == 1)
                                                    @livewire('repuestos.show-repuesto', ['repuesto_show_id' => $produc->id])
                                                @endif

                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $produc->status != 'Repuesto Aprobado' &&
                                                        $produc->status != 'Solicitado al Supervisor' &&
                                                        $produc->status != 'Enviado a Administración')
                                                    @livewire('repuestos.edit-repuesto', ['repuesto_id' => $produc->id])
                                                @endif

                                                @if ($valid->pivot->de == 1 && $produc->status != 'Repuesto Aprobado' && $produc->status != 'Solicitado al Supervisor' )
                                                    @livewire('repuestos.repuesto-delete', ['repuestoID' => $produc->id])
                                                @endif

                                                @if ($produc->status != 'Repuesto Rechazado' && $produc->status != 'Repuesto Aprobado')
                                                    @if ($produc->status != 'Solicitado al Supervisor' && $produc->status == 'Solicitado a Compras')
                                                        <button wire:click="aceptarRepuesCompr({{ $produc->id }})"
                                                            wire:loading.attr="disabled" class="tooltip">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-6 h-6 text-gray-400 hover:text-green-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M4.5 12.75l6 6 9-13.5" />
                                                            </svg>
                                                            <span class="tooltiptext">Enviar a Administración</span>
                                                        </button>
                                                        @livewire('repuestos.observacion-rechazo-rpuesto', ['repuesto_id' => $produc->id])
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @elseif (Auth::user()->permiso_id == 2)
            <table id="table_repuestos"
                class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-black"
                style="width: 100%;">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Id</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Producto</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Imagen</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Estación</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Cantidad</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Status</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Fecha Registro</th>
                        @if ($isSuper->isnotEmpty() || $isGeren->isnotEmpty() || Auth::user()->permiso_id != 1)
                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                    Opciones</th>
                            @endif
                        @else
                            <th
                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                Opciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach ($isSuper as $supervisor)
                        @foreach ($supervisor->repuestos as $produc)
                            @if ($produc->flag_trash == 0)
                                <tr>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ $produc->id }}</div>
                                        </div>
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ $produc->producto->name }}</div>
                                        </div>
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Imagen</span>
                                        @if ($produc->producto->product_photo_path == null)
                                            <img class="rounded-full" name="photo"
                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                style="height: 4rem;" />
                                        @else
                                            <img class="rounded-full" name="photo"
                                                src="{{ asset('storage/' . $produc->producto->product_photo_path) }}"
                                                style="height: 4rem;" />
                                        @endif
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Estación</span>
                                        {{ $produc->estacion->name }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Cantidad</span>
                                        {{ $produc->cantidad }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                        @if ($produc->status == 'Solicitado a Compras')
                                            <span
                                                class="rounded bg-blue-200 py-1 px-3 text-xs text-blue-500 font-bold dark:bg-blue-600 dark:text-blue-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Solicitado al Supervisor')
                                            <span
                                                class="rounded bg-purple-200 py-1 px-3 text-xs text-purple-500 font-bold dark:bg-purple-600 dark:text-purple-200">
                                                {{ $produc->status }}
                                            </span>
                                            @elseif ($produc->status == 'Enviado a Administración')
                                            <span
                                                class="rounded bg-pink-200 py-1 px-3 text-xs text-pink-500 font-bold dark:bg-pink-600 dark:text-pink-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Repuesto Rechazado')
                                            <span
                                                class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold dark:bg-red-600 dark:text-red-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Repuesto Aprobado')
                                            <span
                                                class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold dark:bg-green-600 dark:text-green-200">
                                                {{ $produc->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                                        {{ $produc->created_format }}
                                    </td>
                                    @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                        <td
                                            class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span
                                                class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                            <div class="flex gap-2">
                                                @if ($valid->pivot->vermas == 1)
                                                    @livewire('repuestos.show-repuesto', ['repuesto_show_id' => $produc->id])
                                                @endif

                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $produc->status != 'Repuesto Aprobado' &&
                                                        $produc->status != 'Solicitado a Compras' &&
                                                        $produc->status != 'Enviado a Administración')
                                                    @livewire('repuestos.edit-repuesto', ['repuesto_id' => $produc->id])
                                                @endif

                                                @if ($valid->pivot->de == 1 && $produc->status != 'Repuesto Aprobado' && $produc->status != 'Solicitado a Compras')
                                                    @livewire('repuestos.repuesto-delete', ['repuestoID' => $produc->id])
                                                @endif

                                                @if ($produc->status != 'Repuesto Rechazado' && $produc->status != 'Repuesto Aprobado')
                                                    @if ($produc->status == 'Solicitado al Supervisor' && $produc->status != 'Solicitado a Compras')
                                                        <button wire:click="aceptarRepues({{ $produc->id }})"
                                                            wire:loading.attr="disabled" class="tooltip">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-6 h-6 text-gray-400 hover:text-green-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M4.5 12.75l6 6 9-13.5" />
                                                            </svg>
                                                            <span class="tooltiptext">Enviar a Compras</span>
                                                        </button>
                                                        @livewire('repuestos.observacion-rechazo-rpuesto', ['repuesto_id' => $produc->id])
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @elseif (Auth::user()->permiso_id == 3)
            <table id="table_repuestos"
                class="tborder-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-black"
                style="width: 100%;">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Id</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Producto</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Imagen</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Estación</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Cantidad</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Status</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Fecha Registro</th>
                        @if ($isSuper->isnotEmpty() || $isGeren->isnotEmpty() || Auth::user()->permiso_id != 1)
                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                    Opciones</th>
                            @endif
                        @else
                            <th
                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                Opciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach ($isGeren as $gerente)
                        @forelse ($gerente->repuestos as $produc)
                            @if ($produc->flag_trash == 0)
                                <tr>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ $produc->id }}</div>
                                        </div>
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ $produc->producto->name }}</div>
                                        </div>
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Imagen</span>
                                        @if ($produc->producto->product_photo_path == null)
                                            <img class="rounded-full" name="photo"
                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                style="height: 4rem;" />
                                        @else
                                            <img class="rounded-full" name="photo"
                                                src="{{ asset('storage/' . $produc->producto->product_photo_path) }}"
                                                style="height: 4rem;" />
                                        @endif
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Estación</span>
                                        {{ $produc->estacion->name }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Cantidad</span>
                                        {{ $produc->cantidad }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                        @if ($produc->status == 'Solicitado a Compras')
                                            <span
                                                class="rounded bg-blue-200 py-1 px-3 text-xs text-blue-500 font-bold dark:bg-blue-600 dark:text-blue-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Solicitado al Supervisor')
                                            <span
                                                class="rounded bg-purple-200 py-1 px-3 text-xs text-purple-500 font-bold dark:bg-purple-600 dark:text-purple-200">
                                                {{ $produc->status }}
                                            </span>
                                            @elseif ($produc->status == 'Enviado a Administración')
                                            <span
                                                class="rounded bg-pink-200 py-1 px-3 text-xs text-pink-500 font-bold dark:bg-pink-600 dark:text-pink-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Repuesto Rechazado')
                                            <span
                                                class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold dark:bg-red-600 dark:text-red-200">
                                                {{ $produc->status }}
                                            </span>
                                        @elseif ($produc->status == 'Repuesto Aprobado')
                                            <span
                                                class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold dark:bg-green-600 dark:text-green-200">
                                                {{ $produc->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                                        {{ $produc->created_format }}
                                    </td>
                                    @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                        <td
                                            class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span
                                                class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                            <div class="flex justify-center items-center">
                                                @if ($valid->pivot->vermas == 1)
                                                    @livewire('repuestos.show-repuesto', ['repuesto_show_id' => $produc->id])
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="8">
                                    <p style="display: flex; justify-content: center;"><img
                                            src="{{ asset('img/logo/buzon.png') }}" style="max-width: 150px"
                                            alt="Buzón Vacío"></p>
                                </td>
                            </tr>
                        @endforelse
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
