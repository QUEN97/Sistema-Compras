<table>
    <thead>
        <tr>
            <th>{{ __('Zona') }}</th>
            <th>{{ __('Producto') }}</th>
            <th>{{ __('Categoría') }}</th>
            <th>{{ __('Unidad') }}</th>
            {{-- <th>{{ __('Material') }}</th> --}}
            <th>{{ __('Stock') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produc as $item)
            @foreach ($item->zonas as $z)
                <tr>
                    <td>
                        {{$z->name}}  
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->categoria->name }}
                    </td>
                    {{-- <td>
                        {{ $item->marca->titulo_marca }}
                    </td>
                    <td>
                        {{ $item->modelo->titulo_modelo }}
                    </td> --}}
                    <td>
                        {{ $item->unidad }}
                    </td>
                    {{-- <td>
                        {{ $item->material }}
                    </td> --}}
                    <td>
                        {{ $item->stock }}
                    </td>
                    <td>
                        {{ $item->status }}
                    </td>
                    <td>
                        {{ $item->created_at }}
                    </td>
                </tr>
            @endforeach
        @endforeach
        
    </tbody>
</table>