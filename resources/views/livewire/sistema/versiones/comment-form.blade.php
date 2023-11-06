<div>
    <x-button wire:click="$set('contentForm', true)" class="float-right flex gap-2 items-center">
        {{ __('Ayúdanos a mejorar') }}
    </x-button>

    <x-dialog-modal wire:model="contentForm" class="flex items-center">
        <x-slot name="title">
            <span>Deja tu comentario</span>
        </x-slot>
        <x-slot name="content">
            <div class="w-full mx-2">
                <input wire:model="content" class="w-full rounded-full border border-gray-400 dark:text-black" type="text" value="" placeholder="Aa" autofocus />
                <x-input-error for="content"></x-input-error>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button class="mr-2" wire:click="saveComment" wire:loading.attr="disabled">
                Enviar
            </x-danger-button>
            <x-secondary-button wire:click="$set('contentForm', false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>

@push('scripts')


    <script>
        ClassicEditor
            .create(document.querySelector('#content')) 
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('content', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>



@endpush