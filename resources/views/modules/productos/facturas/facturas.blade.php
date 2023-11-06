<x-app-layout>
    @section('title', 'Facturas')
    <x-slot name="header">
        <div class="grid grid-cols-2 gap-4 items-center max-[440px]:grid-cols-1 max-[440px]:grid-rows-2">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex gap-3 items-center dark:text-gray-300">
                    {{ __('FACTURAS') }}
                </h2>
            </div>
            <div class="flex gap-3 justify-end items-center">
                @if ($valid->pivot->wr == 1)
                    @livewire('productos.facturas.add-factura')
                @endif
                <a href="https://verificacfdi.facturaelectronica.sat.gob.mx/" target="_blank"
                    class="text-white px-4 py-1 flex items-center justify-center felx-col gap-2 bg-green-700 rounded-md hover:bg-green-800 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                    <p>Validar en el SAT</p>
                </a>
            </div>
        </div>
    </x-slot>
    <div class="dark:bg-dark-eval-2">
        <div class="w-full h-full text-center flex justify-center items-center py-4">
            @if ($facturas->count() > 0)
                <div class=" px-2 flex flex-col justify-center gap-2">
                    @foreach ($facturas as $fact)
                        <div
                            class="group relative bg-white border dark:border-gray-700 border-gray-300 rounded-lg p-5 flex justify-evenly items-center flex-wrap gap-2.5 md:gap-3 transition duration-500 md:hover:shadow-lg dark:bg-slate-800 dark:text-slate-400">
                            <div class="flex justify-center items-center flex-col gap-2 py-2">
                                <div class="text-xs font-bold">
                                    <span class="py-1 uppercase">Registro #</span>
                                    {{ $fact->id }}
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor"
                                    class="w-11 h-11 text-blue-800 dark:text-blue-500">
                                    <path
                                        d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.2-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8V488c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.2 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488V24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96zM80 352c0 8.8 7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96z" />
                                </svg>
                                <div class="text-xs font-bold max-w-[200px]">
                                    <span class="py-1 uppercase">Folio Fiscal: </span>
                                    <p>{{ $fact->folio_fiscal }}</p>
                                </div>
                            </div>
                            <div class="text-start flex flex-row flex-wrap gap-3 items-strech">
                                <div class=" border-b border-gray-300 max-w-[300px] dark:border-gray-500 text-center">
                                    <span class="px-1 py-1 text-xs font-bold uppercase">Proveedor:</span>
                                    {{ $fact->titulo_proveedor }}
                                </div>

                                <div
                                    class="flex items-center justify-center border-b border-gray-300 dark:border-gray-500 text-center">
                                    <span class="px-1 py-1 text-xs font-bold uppercase">Monto: $</span>
                                    {{ $fact->monto }}
                                </div>
                                <div
                                    class=" flex items-center flex-col justify-center border-b border-gray-300 dark:border-gray-500 text-center">
                                    <span class="px-1 py-1 text-xs font-bold uppercase mr-3">Subido el día:</span>
                                    <p>{{ $fact->created_at }}</p>
                                </div>
                            </div>
                            <div>
                                <div>Acciones</div>
                                <div class="flex gap-1.5 transition duration-300 justify-center">
                                    @if ($valid->pivot->vermas == 1)
                                        @livewire('productos.facturas.show-factura', ['facturaID' => $fact->id])
                                    @endif

                                    @if ($valid->pivot->de == 1)
                                        @livewire('productos.facturas.delete-factura', ['facturaID' => $fact->id])
                                    @endif
                                </div>
                                
                                    <div
                                        class="absolute top-2 left-2 text-gray-400 md:dark:text-slate-800 md:dark:group-hover:text-white md:text-white md:group-hover:text-gray-400 transition duration-300">
                                        @if ($valid->pivot->ed == 1)
                                        @livewire('productos.facturas.edit-factura', ['facturaID' => $fact->id])
                                        @endif
                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
        <div class="max-w-[600px] m-auto">
            {{ $facturas->links() }}
        </div>
    </div>
</x-app-layout>
