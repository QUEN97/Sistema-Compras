<table>
    <thead>
        <tr>
            <th>{{ __('No. De Registro') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Producto') }}</th>
            <th>{{ __('Stock') }}</th>
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
                    {{ $item->producto }}
                </td>
                <td>
                    {{ $item->stock }}
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->created_at}}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>