<table>
    <thead>
        <tr>
            <th>{{ __('No. De Estación') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Gerente') }}</th>
            <th>{{ __('Supervisor') }}</th>
            <th>{{ __('Zona') }}</th>
            {{-- <th>{{ __('Ubicación') }}</th> --}}
            <th>{{ __('Cant. de Productos') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($estac as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    @if ($item->user_id == null)
                        {{ __('Sin Gerente') }}
                    @else
                        {{ $item->user->name }}
                    @endif
                </td>
                <td>
                    @if ($item->supervisor_id == null)
                        {{ __('Sin Supervisor') }}
                    @else
                        {{ $item->supervisor->name }}
                    @endif
                </td>
                <td>
                    {{ $item->zona->name }}
                </td>
                {{-- <td>
                    {{ $item->ubicacion }}
                </td> --}}
                <td>
                    @foreach ($total as $tl)
                        @if ($item->id== $tl->estacion)
                            {{$tl->total}}
                        @endif
                    @endforeach
                    {{-- @foreach ($item->productos as $val)
                        @if ($val->where('flag_trash', 0)->count() == 0 || $val->pivot->where('flag_trash', 0)->count() == null || $val->pivot == null)
                            {{ __('Sin Productos') }}
                        @else
                            {{ $val->where('flag_trash', 0)->where('estacion_id',$item->id)->count() }}
                        @endif
                    @endforeach --}}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>