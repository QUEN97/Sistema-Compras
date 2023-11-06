<table>
    <thead>
        <tr>
            <th>{{ __('No. De Categoría') }}</th>
            <th>{{ __('Categoria') }}</th>
            <th>{{ __('Cant. Productos') }}</th>
            <th>{{ __('Cant. Solicitudes') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{dd($catego);}} --}}
        @foreach ($catego as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->titulo_categoria }}
                </td>
                <td>
                    {{ $item->produs }}
                </td>
                <td>
                    {{ $item->solici }}
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>