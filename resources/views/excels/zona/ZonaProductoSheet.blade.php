<table>
    <thead>
        <th colspan="6" rowspan="2">
            {{ __('Productos en la Zona') }}
        </th>
    </thead>
</table>

<br><br><br>

<table>
    <thead>
        <tr>
            <th>{{ __('Zona Del Producto') }}</th>
            <th>{{ __('Nombre') }}</th>
            <th>{{ __('Categoria') }}</th>
            <th>{{ __('Stock') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $im)
                <tr>
                    <td>
                        {{ $im->zona }}
                    </td>
                    <td>
                        {{ $im->name }}
                    </td>
                    <td>
                        {{ $im->categoria}}
                    </td>
                    <td>
                        {{ $im->stock }}
                    </td>
                    <td>
                        @if ($im->deleted_at == null)
                           {{ __('En Sistema') }} 
                        @else
                            {{ __('En Papelera') }}
                        @endif
                    </td>
                    <td>
                        {{ $im->created_at }}
                    </td>
                </tr>
            @endforeach
        {{-- @foreach ($zonasProdu as $item)
            @foreach ($item->productos as $im)
                <tr>
                    <td>
                        {{ $im->id }}
                    </td>
                    <td>
                        {{ $im->titulo_producto }}
                    </td>
                    <td>
                        {{ $im->categoria->titulo_categoria }}
                    </td>
                    <td>
                        {{ $im->stock }}
                    </td>
                    <td>
                        @if ($im->flag_trash == 0)
                           {{ __('En Sistema') }} 
                        @else
                            {{ __('En Papelera') }}
                        @endif
                    </td>
                    <td>
                        {{ $im->created_format }}
                    </td>
                </tr>
            @endforeach
        @endforeach --}}
    </tbody>
</table>