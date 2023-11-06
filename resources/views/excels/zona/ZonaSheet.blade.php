<table>
    <thead>
        <tr>
            <th>{{ __('No. De Registro') }}</th>
            <th>{{ __('Zona') }}</th>
           {{--  <th>{{ __('Ubicación') }}</th> --}}
            <th>{{ __('Cant. de Gerentes') }}</th>
            <th>{{ __('Cant. de Estaciones') }}</th>
            <th>{{ __('Cant. de Productos') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($zonas as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                {{-- <td>
                    {{ $item->ubicacion }}
                </td> --}}
                <td>
                    {{ $item->users->where('permiso_id', 3)->count() }}
                </td>
                <td>
                    {{ $item->estacions->count() }}
                </td>
                <td>
                    @foreach ($productos as $cant)
                        @if ($item->name ==$cant->name)
                            {{$cant->total_productos}}
                        @endif
                    @endforeach
                   {{--  {{ $item->productosZona->count() }} --}}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>