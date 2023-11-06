<x-app-layout>
    @section('title', 'Repuestos Eliminados')
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Repuestos Eliminados') }}
            </h2>
        </div>
    </x-slot>
    <div class="content">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    {{-- inicio tabla usuarios --}}
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5 mt-12">
                        @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
                            <table class="border-collapse w-full bg-white text-center text-sm text-gray-500">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                            Id</th>
                                        <th
                                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                            Producto</th>
                                        <th
                                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                            Imagen</th>
                                        <th
                                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                            Estación</th>
                                        <th
                                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                            Cantidad</th>
                                        <th
                                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                            Eliminado</th>
                                        @if ($isSuper->isnotEmpty() || $isGeren->isnotEmpty() || Auth::user()->permiso_id != 1)
                                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                                    Opciones</th>
                                            @endif
                                        @else
                                            <th
                                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                                Opciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                    @foreach ($allRepuesto as $allma)
                                        @foreach ($allma->repuestos as $produc)
                                            @if ($produc->flag_trash == 1)
                                                <tr
                                                    class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        # {{ $produc->id }} </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        {{ $produc->producto->name }} </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
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
                                                        {{ $produc->estacion->name }}
                                                    </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        {{ $produc->cantidad }}
                                                    </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        {{ $produc->updated_at }} </td>
                                                    @if ($valid->pivot->vermaspap == 1 || $valid->pivot->restpap == 1)
                                                        <td
                                                            class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                            @if ($valid->pivot->vermaspap == 1)
                                                                @livewire('repuestos.show-repuesto', ['repuesto_show_id' => $produc->id])
                                                            @endif

                                                            {{-- @if ($valid->pivot->restpap == 1)
                                                        @livewire('trash.repuestos.restore-repuesto', ['repuesto_restore_id' => $produc->id, 'repuesto_restore_name' => $produc->producto->titulo_producto])
                                                    @endif --}}
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif ($isSuper->isnotEmpty())
                            <table class="border-collapse w-full bg-white text-center text-sm text-gray-500">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">ID</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Producto</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Imagen</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Estacion</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Cantidad</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Eliminado</th>
                                        @if ($isSuper->isnotEmpty() || $isGeren->isnotEmpty() || Auth::user()->permiso_id != 1)
                                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Opciones</th>
                                            @endif
                                        @else
                                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Opciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                    @foreach ($isSuper as $supervi)
                                        @foreach ($supervi->repuestos as $produc)
                                            @if ($produc->flag_trash == 1)
                                                <tr>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"># {{ $produc->id }} </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"> {{ $produc->producto->name }} </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        @if ($produc->producto->product_photo_path == null)
                                                            <img class="rounded-circle" name="photo"
                                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                                style="height: 4rem;" />
                                                        @else
                                                            <img class="rounded-circle" name="photo"
                                                                src="{{ asset('storage/' . $produc->producto->product_photo_path) }}"
                                                                style="height: 4rem;" />
                                                        @endif
                                                    </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        {{ $produc->estacion->name }}
                                                    </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        {{ $produc->cantidad }}
                                                    </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"> {{ $produc->updated_at }} </td>
                                                    @if ($valid->pivot->vermaspap == 1 || $valid->pivot->restpap == 1)
                                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                            @if ($valid->pivot->vermaspap == 1)
                                                                @livewire('repuestos.show-repuesto', ['repuesto_show_id' => $produc->id])
                                                            @endif

                                                            {{-- @if ($valid->pivot->restpap == 1)
                                                                @livewire('trash.repuestos.restore-repuesto', ['repuesto_restore_id' => $produc->id, 'repuesto_restore_name' => $produc->producto->titulo_producto])
                                                            @endif --}}
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif ($isGeren->isnotEmpty())
                            <table class="border-collapse w-full bg-white text-center text-sm text-gray-500">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">ID</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Producto</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Imagen</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Cantidad</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Eliminado</th>
                                        @if ($isSuper->isnotEmpty() || $isGeren->isnotEmpty() || Auth::user()->permiso_id != 1)
                                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Opciones</th>
                                            @endif
                                        @else
                                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Opciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                    @foreach ($isGeren as $gere)
                                        @foreach ($gere->repuestos as $produc)
                                            @if ($produc->flag_trash == 1)
                                                <tr>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"># {{ $produc->id }} </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"> {{ $produc->producto->name }} </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        @if ($produc->producto->product_photo_path == null)
                                                            <img class="rounded-circle" name="photo"
                                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                                style="height: 4rem;" />
                                                        @else
                                                            <img class="rounded-circle" name="photo"
                                                                src="{{ asset('storage/' . $produc->producto->product_photo_path) }}"
                                                                style="height: 4rem;" />
                                                        @endif
                                                    </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        {{ $produc->cantidad }}
                                                    </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                        {{ $produc->updated_at }}
                                                    </td>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"> {{ $produc->updated_at }} </td>
                                                    @if ($valid->pivot->vermaspap == 1 || $valid->pivot->restpap == 1)
                                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                            @if ($valid->pivot->vermaspap == 1)
                                                                @livewire('repuestos.show-repuesto', ['repuesto_show_id' => $produc->id])
                                                            @endif

                                                            {{-- @if ($valid->pivot->restpap == 1)
                                                                @livewire('trash.repuestos.restore-repuesto', ['repuesto_restore_id' => $produc->id, 'repuesto_restore_name' => $produc->producto->titulo_producto])
                                                            @endif --}}
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <div class="mt-2 ml-2 mb-2">
                            <a class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                                href="{{ route('repuestos') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    {{-- fin tabla usuarios --}}
                </div>
            </div>
        </div>
</x-app-layout>
