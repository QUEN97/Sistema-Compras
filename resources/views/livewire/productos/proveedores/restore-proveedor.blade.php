<div class="flex items-center">
    <button wire:click="ConfirmRestore({{$proveedorID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 text-gray-400 hover:text-indigo-500  hover:rotate-180 transition duration-500" fill="currentColor">
            <path d="M89.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L370.3 160H320c-17.7 0-32 14.3-32 32s14.3 32 32 32H447.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L398.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C57.2 122 39.6 150.7 28.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM23 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V448c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L109.6 352H160c17.7 0 32-14.3 32-32s-14.3-32-32-32H32.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/>
        </svg>
        <span class="tooltiptext">Restaurar</span>
    </button>
    <x-dialog-modal wire:model="modalRestore" class="flex items-center">
        <x-slot name="title">
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col justify-center text-center gap-2">
                <div class="flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-20 h-20 text-yellow-500 bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
                <span>La información del proveedor  <i>"{{$pName}}"</i> será restaurada</span>
                <p>¿Está de acuerdo?</p>
            </div>
        </x-slot>
        <x-slot name="footer" >
            <div class="w-full flex justify-center gap-3">
                <x-danger-button class="mr-2" wire:click="RestoreProveedor({{$proveedorID}})" wire:loading.attr="disabled">
                    Aceptar
                </x-danger-button>
                <x-secondary-button wire:click="$set('modalRestore',false)" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>
            </div>
           
        </x-slot>
    </x-dialog-modal>
</div>
