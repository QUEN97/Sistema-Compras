<div>
    <x-responsive-nav-link wire:loading.class.remove="text-muted text-decoration-none" wire:click="show"
        href="javascript:void(0);"
        class="text-gray-400 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-gray-200">
        <span>{{ __('No puedo acceder') }}</span>
    </x-responsive-nav-link>

    <x-dialog-modal wire:model="confirminpassReset" id="modalPass" class="flex items-center">
        <x-slot name="title">
            {{ __('¿No puede acceder al sistema?') }}
        </x-slot>

        <x-slot name="content">
            <div class="bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded relative" role="alert">
                <span class="font-bold">Favor de contactar al Administrador:</span>
                <ul>
                    <li>sistemas@fullgas.com.mx</li>
                </ul>
                <span class="font-bold">para que se le pueda restablecer el acceso.</span> 
                <span class="font-bold text-red-500 float-right mt-4">FULLGAS &copy;</span>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-danger-button wire:click="$toggle('confirminpassReset')" wire:loading.attr="disabled">
                {{ __('Entendido') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
