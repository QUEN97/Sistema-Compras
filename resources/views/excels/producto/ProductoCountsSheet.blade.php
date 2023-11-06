<table>
    <thead>
        <th colspan="6" rowspan="2">
            {{ __('Apariciones de Productos') }}
        </th>
    </thead>
</table>

<br><br><br>

<table>
    <thead>
        <tr>
            <th rowspan="2">{{ __('No. De Producto') }}</th>
            <th rowspan="2">{{ __('Producto') }}</th>
            <th rowspan="2">{{ __('Creado') }}</th>
            <th colspan="3">{{ __('Cant. de Veces En:') }}</th>
        </tr>
        <tr>
            <th>{{ __('Almacenes') }}</th>
            <th>{{ __('Repuestos') }}</th>
            <th>{{ __('Solicitudes') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produc as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->titulo_producto }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
                <td>
                    {{ $item->alma }}
                </td>
                <td>
                    {{ $item->repues }}
                </td>
                <td>
                    {{ $item->solici }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>