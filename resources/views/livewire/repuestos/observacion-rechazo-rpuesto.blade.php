<div>

    <button  wire:click="confirmRepuestoRechazo({{ $repuesto_id }})" wire:loading.attr="disabled" 
        class="tooltip" data-target="rechazarRepues{{ $repuesto_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-red-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <span class="tooltiptext">Rechazar</span>
    </button>


    <x-dialog-modal wire:model="rechazarRepues" id="rechazarRepues{{ $repuesto_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Motivo de Rechazo') }}
        </x-slot>

        <x-slot name="content">
            <div class="row">

                <div class="mb-3 col-12">
                    <x-label value="{{ __('Observación') }}" />

                    <textarea wire:model="observacion" class="form-control {{ $errors->has('observacion') ? 'is-invalid' : '' }} resize-none" name="observacion"
                        required autofocus autocomplete="observacion" cols="30" rows="8"></textarea>

                    <x-input-error for="observacion"></x-input-error>
                </div>

            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="ml-2" wire:click="rechazarRepuesto({{ $repuesto_id }})" wire:loading.attr="disabled">
                {{ __('Aceptar')}}
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('rechazarRepues')" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>