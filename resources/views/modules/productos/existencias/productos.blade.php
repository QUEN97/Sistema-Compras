<x-app-layout>
    @section('title', 'Productos')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('PRODUCTOS') }}
            </h2>
            @if ($valid->pivot->wr == 1)
                @livewire('productos.existencias.producto-create')
            @endif
        </div>
    </x-slot>

    <div
        class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md lg:flex-row md:justify-between dark:bg-dark-eval-1">
        <div class="w-full">
            <div class="grid grid-cols-2 mb-2 mt-2">
                <div class="ml-2">
                    <form action="{{ route('productos') }}" method="GET">
                        <label for="search" class="sr-only">
                            Search
                        </label>
                        <input type="text" name="s"
                            class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md dark:text-white dark:bg-dark-eval-0"
                            placeholder="Buscar..." />
                    </form>
                </div>
                <div class="mr-2">
                    @if ($valid->pivot->de == 1)
                        <a class="inline-flex items-center px-3 py-2.5 text-sm font-medium text-center float-right text-white bg-gray-400 rounded-lg dark:bg-dark-eval-3"
                            href="{{ route('productos.trashed') }}">
                            Eliminados
                            <span
                                class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                                {{ $trashed }}
                            </span>
                        </a>
                    @endif
                </div>
            </div>
            <table class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-black">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Nombre</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Categoria</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Unidad</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Status</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Stock</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Zona</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Fecha de Registro</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Opciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @forelse($productos as $producto)
                        <tr>
                            <th
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Nombre</span>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        @if ($producto->product_photo_path == null)
                                            <img class="w-full h-full rounded-full"
                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                alt="" />
                                        @else
                                            <img class="w-full h-full rounded-full"
                                                src="{{ asset('storage/' . $producto->product_photo_path) }}"
                                                alt="" />
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $producto->name }}
                                        </p>
                                    </div>
                                </div>
                            </th>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Categoria</span>
                                {{ $producto->categoria->name }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Unidad</span>
                                {{ $producto->unidad }}
                            </td>
                            
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Status</span>
                                @if ($producto->status == 'Activo')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold">{{ $producto->status }}</span>
                                @else
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold">{{ $producto->status }}</span>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Stock</span>
                                {{ number_format($producto->stock, 0, ',') }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Zona</span>
                                <div class="tooltip text-xs">Zonas: {{ $producto->name }}
                                    <span class="tooltiptext">
                                        @foreach ($producto->zonas as $zona)
                                            {{ $zona->name }} -
                                        @endforeach
                                    </span>
                                </div>
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Fecha</span>
                                {{ $producto->created_at }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                <div class="grid grid-cols-2">
                                    <div>
                                        @if ($valid->pivot->ed == 1)
                                            @livewire('productos.existencias.producto-edit', ['producto_id' => $producto->id])
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->de == 1)
                                            @livewire('productos.existencias.producto-delete', ['prodID' => $producto->id])
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"
                                colspan="7">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Sin
                                    registros</span>
                                No hay productos en el sistema
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2 mb-2 mr-2">
                {{ $productos->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
