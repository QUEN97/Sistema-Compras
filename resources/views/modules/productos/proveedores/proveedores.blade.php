<x-app-layout>
    @section('title', 'Proveedores')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('PROVEEDORES') }}
            </h2>

            @if ($valid->pivot->wr == 1)
                @livewire('productos.proveedores.new-proveedor')
            @endif
        </div>
    </x-slot>
    <div class="dark:bg-dark-eval-2">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="col-span-2 ">
            <form action="{{ route('proveedores.search') }}" method="GET" class="w-full">
                <input type="text" name="q"
                    class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md dark:bg-dark-eval-0 dark:text-black"
                    id="" placeholder="Buscar...">
            </form>
        </div>
        @if ($valid->pivot->de == 1)
                    <a href="{{ route('proveedores.trash') }}"
                        class="relative group rounded-lg flex items-center gap-2 p-2 text-sm">
                        @if ($trash > 0)
                            <div
                                class="absolute left-0 bottom-0 bg-red-500 rounded-full w-6 h-6 flex justify-center items-center text-white font-bold">
                                {{ $trash }}</div>
                        @endif
                        <div class="flex items-center justify-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-8 h-8 text-gray-400 hover:text-red-500 dark:text-white dark:hover:text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                    </a>
                @endif
        </div>

        <div class="w-full h-full text-center flex justify-center items-center py-2 ">
            @if ($dat->count() > 0)
                <div class="max-w-[650px] px-2 flex flex-col justify-center gap-2">
                    @foreach ($dat as $d)
                        <div
                            class="group relative bg-white dark:bg-dark-eval-1 rounded-lg p-5 flex justify-evenly items-center flex-wrap gap-2.5 md:gap-3 transition duration-500 md:hover:shadow-lg  dark:text-white">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor"
                                    class="w-11 h-11 bi bi-file-person text-blue-800 dark:text-blue-500"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z" />
                                    <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg>
                            </div>
                            <div class="text-start flex flex-col gap-1">
                                <div class="border-b border-gray-300 max-w-[350px] dark:border-gray-500">
                                    <span class="px-1 py-1 text-xs font-bold uppercase mr-3">Nombre:</span>
                                    {{ $d->titulo_proveedor }}
                                </div>
                                <div class="border-b border-gray-300 dark:border-gray-500">
                                    <span class="px-1 py-1 text-xs font-bold uppercase mr-3">RFC:</span>
                                    {{ $d->rfc_proveedor }}
                                </div>
                                <div class="border-b border-gray-300 dark:border-gray-500">
                                    <span class="px-1 py-1 text-xs font-bold uppercase mr-3">Tipo de pago:</span>
                                    <div>
                                        @if (is_numeric($d->condicion_pago))
                                            REF. NUMERICA: {{ $d->condicion_pago }}
                                        @else
                                            {{ $d->condicion_pago }}
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div>
                                <div>Acciones</div>
                                <div class="flex gap-1.5 transition duration-300 justify-center">
                                    @if ($valid->pivot->vermas == 1)
                                        @livewire('productos.proveedores.show-proveedor', ['proveedorID' => $d->id])
                                    @endif

                                    @if ($valid->pivot->de == 1)
                                        @livewire('productos.proveedores.delete-proveedor', ['proveedorID' => $d->id])
                                    @endif
                                </div>
                                <div
                                    class="absolute top-2 left-2 text-gray-400 md:dark:text-slate-800 md:dark:group-hover:text-white md:text-white md:group-hover:text-gray-400 transition duration-300">
                                    @if ($valid->pivot->ed == 1)
                                        @livewire('productos.proveedores.edit-proveedor', ['proveedorID' => $d->id])
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{--  {{$dat}} --}}
            @else
                <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="max-w-[200px] bi bi-x-circle"
                        viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <span class="text-2xl">No se encontraron datos</span>
                </div>
            @endif
        </div>
        <div class="flex justify-center mt-6">
            {{ $dat->links() }}
        </div>
    </div>
</x-app-layout>
