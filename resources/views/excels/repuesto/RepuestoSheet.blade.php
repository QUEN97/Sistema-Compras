<table>
    <thead>
        <tr>
            <th>{{ __('No. De Registro') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Producto') }}</th>
            <th>{{ __('Cantidad') }}</th>
            <th>{{ __('Descripción') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($repues as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->estacion->name }}
                </td>
                <td>
                    {{ $item->producto->name }}
                </td>
                <td>
                    {{ $item->cantidad }}
                </td>
                <td>
                    {{ $item->descripcion }}
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