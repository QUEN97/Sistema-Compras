<x-app-layout>
    @section('title','Proveedores Eliminados')
    <x-slot name="header">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex gap-3 items-center dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-8 h-8" fill="currentColor">
                        <path d="M174.7 45.1C192.2 17 223 0 256 0s63.8 17 81.3 45.1l38.6 61.7 27-15.6c8.4-4.9 18.9-4.2 26.6 1.7s11.1 15.9 8.6 25.3l-23.4 87.4c-3.4 12.8-16.6 20.4-29.4 17l-87.4-23.4c-9.4-2.5-16.3-10.4-17.6-20s3.4-19.1 11.8-23.9l28.4-16.4L283 79c-5.8-9.3-16-15-27-15s-21.2 5.7-27 15l-17.5 28c-9.2 14.8-28.6 19.5-43.6 10.5c-15.3-9.2-20.2-29.2-10.7-44.4l17.5-28zM429.5 251.9c15-9 34.4-4.3 43.6 10.5l24.4 39.1c9.4 15.1 14.4 32.4 14.6 50.2c.3 53.1-42.7 96.4-95.8 96.4L320 448v32c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-64-64c-9.4-9.4-9.4-24.6 0-33.9l64-64c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2v32l96.2 0c17.6 0 31.9-14.4 31.8-32c0-5.9-1.7-11.7-4.8-16.7l-24.4-39.1c-9.5-15.2-4.7-35.2 10.7-44.4zm-364.6-31L36 204.2c-8.4-4.9-13.1-14.3-11.8-23.9s8.2-17.5 17.6-20l87.4-23.4c12.8-3.4 26 4.2 29.4 17L182 241.2c2.5 9.4-.9 19.3-8.6 25.3s-18.2 6.6-26.6 1.7l-26.5-15.3L68.8 335.3c-3.1 5-4.8 10.8-4.8 16.7c-.1 17.6 14.2 32 31.8 32l32.2 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32.2 0C42.7 448-.3 404.8 0 351.6c.1-17.8 5.1-35.1 14.6-50.2l50.3-80.5z"/>
                    </svg>
                    {{ __('Papelera') }}
                </h2>
            </div>
            <div>
                {{-- @livewire('productos.proveedores.new-proveedor') --}}
            </div>
        </div>
    </x-slot>
    <div class="dark:bg-gray-900">

        <div class="px-6 pt-2 pb-5">
            <a href="{{ route('proveedores') }}" class="flex gap-2 items-center text-lg text-gray-500 hover:text-black transition duration-300 dark:hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="w-6 h-6 text-xl bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                </svg>
                Regresar              
            </a>
        </div>
        <div class="flex flex-col justify-center items-center gap-2.5 max-w-[650px] m-auto ">
            @if ($list->count() >0)
                @foreach ($list as $l)
                    <div class="group relative w-full bg-white border border-gray-300 rounded-lg p-5 flex justify-evenly items-center flex-wrap gap-2.5 md:gap-4 transition duration-500 md:hover:shadow-lg dark:bg-slate-800 dark:text-slate-400 dark:border-slate-800">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-11 h-11 bi bi-file-person text-blue-800 dark:text-blue-500" viewBox="0 0 16 16">
                                <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                              </svg>
                        </div>
                        <div class="text-start flex flex-col gap-1">
                            <div class="max-w-[315px]">
                                <span class=" py-1 font-bold uppercase">Nombre:</span>
                                {{$l->titulo_proveedor}}
                            </div>
                            <div><span class=" py-1 font-bold uppercase">RFC:</span>
                                {{$l->rfc_proveedor}}
                            </div>
                            <div>
                                <span class="py-1 font-bold uppercase">Eliminado el dia:</span>
                                {{$l->updated_at}}
                            </div>
                        </div>
                        <div class="p-2">
                            @livewire('productos.proveedores.restore-proveedor',['proveedorID'=>$l->id])
                        </div>
                    </div>
                @endforeach
                <div>{{$list->links()}}</div>
            @else
                <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="max-w-[200px] bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                      </svg>
                    <span class="text-2xl">La papelera está vacía</span>
                </div>
            @endif
        </div>
    </div>
      
</x-app-layout>