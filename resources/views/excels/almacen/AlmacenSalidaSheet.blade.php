<table>
    <thead>
        <th colspan="8" rowspan="2">
            {{ __('Salidas del Almacen') }}
        </th>
    </thead>
</table>

<br><br><br>

<table>
    <thead>
        <tr>
            <th>{{ __('No. De Registro') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Folio') }}</th>
            <th>{{ __('Cantidad') }}</th>
            <th>{{ __('pdf') }}</th>
            <th>{{ __('Motivo') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($almac as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->estacion }}
                </td>
                <td>
                    {{ $item->folio }}
                </td>
                <td>
                    {{ $item->cantidad }}
                </td>
                <td>
                    {{ $item->pdf }}
                </td>
                <td>
                    {{ $item->motivo }}
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