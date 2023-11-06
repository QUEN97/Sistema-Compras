<table>
    <thead>
        <tr>
            <th>{{ __('No. De Registro') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Categoría') }}</th>
            <th>{{ __('Archivo PDF') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($solici as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->estacion->name }}
                </td>
                <td>
                    {{ $item->categoria->name }}
                </td>
                <td>
                    {{ $item->pdf }}
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->created_format }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>