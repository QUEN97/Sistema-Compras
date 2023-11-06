<div>
    <button wire:click="ConfirmDelete({{$proveedorID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-red-500 transition duration-300 bi bi-trash3-fill" viewBox="0 0 16 16">
            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
          </svg>
          <span class="tooltiptext">Eliminar</span>
    </button>
    
    <x-dialog-modal wire:model="modalDelete" class="flex items-center">
        <x-slot name="title">
        </x-slot>
        <x-slot name="content" class="relative">
            <div>
                <div class="flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-20 h-20 text-yellow-500 bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
                <span>¿Está seguro de eliminar a <i>"{{$pName}}"</i> ?</span>
            </div>
        </x-slot>
        <x-slot name="footer" >
            <div class="w-full flex justify-center gap-3">
                <x-danger-button class="mr-2" wire:click="DeleteProveedor({{$proveedorID}})" wire:loading.attr="disabled">
                    Aceptar
                </x-danger-button>
                <x-secondary-button wire:click="$set('modalDelete',false)" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>
            </div>
           
        </x-slot>
    </x-dialog-modal>
</div>
