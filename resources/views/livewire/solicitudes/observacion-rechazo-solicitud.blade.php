<div>

    <button  wire:click="confirmSolicitudRechazo({{ $solicitud_obser_id }})" wire:loading.attr="disabled" 
        class="tooltip"
        data-target="rechazarSoli{{ $solicitud_obser_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-red-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <span class="tooltiptext">Rechazar Solicitud</span>
    </button>


    <x-dialog-modal wire:model="rechazarSoli" id="rechazarSoli{{ $solicitud_obser_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Motivo de Rechazo') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col">

                <div class="mb-3 col-12">
                    <x-label value="{{ __('Observación') }}" />

                    <textarea wire:model="observacion" class="resize-none rounded-md{{ $errors->has('observacion') ? 'is-invalid' : '' }}" name="observacion"
                        required autofocus placeholder="El motivo por el cuál esta solicitud se rechaza es..."></textarea>

                    <x-input-error for="observacion"></x-input-error>
                </div>

            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="rechazarSolici({{ $solicitud_obser_id }})" wire:loading.attr="disabled">
                {{ __('Aceptar')}}
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('rechazarSoli')" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
