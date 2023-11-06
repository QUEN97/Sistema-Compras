<table>
    <thead>
        <th colspan="7" rowspan="2">
            {{ __('Productos en el Almacen') }}
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
            <th>{{ __('Stock') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Disponibilidad') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($estac as $item)
            @foreach ($item->productos as $key => $val)
                <tr>
                    <td>
                        {{ $val->pivot->id }}
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        @foreach ($producto as $p)
                            @if ($val->pivot->producto_id==$p->id)
                                {{$p->name}}
                            @endif
                        @endforeach
                    </td>
                    <td>
                        {{ $val->pivot->stock }}
                    </td>
                    <td>
                        {{ $val->pivot->status }}
                    </td>
                    <td>
                        @if ($val->pivot->flag_trash == 0)
                            {{ __('En Su Bodega') }}
                        @else
                            {{ __('En Su Papelera') }}
                        @endif
                    </td>
                    <td>
                        {{ $val->created_at }}
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>