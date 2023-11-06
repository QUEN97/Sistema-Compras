<table>
    <thead>
        <th colspan="6" rowspan="2">
            {{ __('Costo de Repuestos') }}
        </th>
    </thead>
</table>

<br><br><br>

<table>
    <thead>
        <tr>
            <th>{{ __('No. De Registro') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Producto') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Cantidad') }}</th>
            <th>{{ __('Costo Total') }}</th>
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
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->cantidad }}
                </td>
                <td>
                    {{ $item->cantidad * $item->producto->precio  }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>