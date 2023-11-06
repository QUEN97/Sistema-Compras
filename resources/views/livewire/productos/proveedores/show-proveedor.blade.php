<div>
    <button wire:click="ShowRepuesto({{$proveedorID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/>
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>
    <x-dialog-modal wire:model="showProveedor">
        <x-slot name="title">
            {{ __('Información del Proveedor') }}
        </x-slot>
        <x-slot name="content" class="relative">
            <div class="flex flex-wrap justify-evenly items-center gap-3 w-full">
                <div class="flex flex-wrap justify-evenly items-center gap-3 w-full">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span>Nombre:</span>
                        <div>{{$pName}}</div>
                    </div>
                    <div class="flex flex-wrap gap-2 items-center">
                        <span>RFC:</span>
                        <div>{{$rfc}}</div>
                    </div>
                    <div class="flex flex-wrap gap-2 items-center">
                        <span>Tipo de Pago:</span>
                        <div>{{$mpago}}</div>
                    </div>
                </div>
                {{-- <div>
                    <span>Categoría:</span>
                    <p class="text-violet-800 font-bold">{{strtoupper($categoria)}}</p>
                </div> --}}
            </div>
            <div class="p-2">
                <label class="flex justify-center gap-3 items-center border-b border-sky-700 text-sky-700 p-1 mb-1 my-2 dark:border-sky-500 dark:text-sky-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 512 512">
                    <path d="M243.4 2.6l-224 96c-14 6-21.8 21-18.7 35.8S16.8 160 32 160v8c0 13.3 10.7 24 24 24H456c13.3 0 24-10.7 24-24v-8c15.2 0 28.3-10.7 31.3-25.6s-4.8-29.9-18.7-35.8l-224-96c-8.1-3.4-17.2-3.4-25.2 0zM128 224H64V420.3c-.6 .3-1.2 .7-1.8 1.1l-48 32c-11.7 7.8-17 22.4-12.9 35.9S17.9 512 32 512H480c14.1 0 26.5-9.2 30.6-22.7s-1.1-28.1-12.9-35.9l-48-32c-.6-.4-1.2-.7-1.8-1.1V224H384V416H344V224H280V416H232V224H168V416H128V224zM256 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                </svg>
                {{ __('Información Bancaria') }}
                </label>
                <div class="py-2 flex flex-wrap justify-evenly items-center gap-3">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span>Nombre del Banco:</span>
                        <div>{{$bank}}</div>
                    </div>
                    <div class="flex flex-wrap gap-2 items-center">
                        <span>No. de Cuenta:</span>
                        <div>{{$nCuenta}}</div>
                    </div>
                    <div class="flex flex-wrap gap-2 items-center">
                        <span>Clave:</span>
                        <div>{{$clave}}</div>
                    </div>
                </div>
            </div>
            <div class="absolute right-1.5	top-1.5">
                <button wire:click="$toggle('showProveedor')" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg"fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-orange-800 transition duration-300" viewBox="0 0 320 512" >
                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
                    </svg>
                </button>
            </div>
        </x-slot>
        <x-slot name="footer">
        </x-slot>
    </x-dialog-modal>
</div>