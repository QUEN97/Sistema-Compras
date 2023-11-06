<table>
    <thead>
        <tr>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Cant. de Categorias') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($solici as $item)
            <tr>
                <td>
                    {{ $item->estacion->name }}
                </td>
                <td>
                    {{ $item->cantidad }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>