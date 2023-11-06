<table>
    <thead>
        <tr>
            <th>{{ __('No. De Solicitud') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Cant. de Productos') }}</th>
            <th>{{ __('Cant. Total de Productos') }}</th>
            <th>{{ __('Total de Costo de Productos') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($solici as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->titulo_estacion }}
                </td>
                <td>
                    {{ $item->products }}
                </td>
                <td>
                    {{ $item->cant }}
                </td>
                <td>
                    {{ $item->tot }}
                </td>
            </tr>
            @if ($loop->last)
                <tr>
                    <td>{{ __('Total') }}</td>
                    <td colspan="3"></td>
                    <td>
                        {{ $solici->sum('tot') }}
                    </td>
                </tr>
            @endif
        @endforeach
        
    </tbody>
</table>