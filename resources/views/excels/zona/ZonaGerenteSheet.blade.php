<table>
    <thead>
        <th colspan="5" rowspan="2">
            {{ __('Gerentes en la Zona') }}
        </th>
    </thead>
</table>

<br><br><br>

<table>
    <thead>
        <tr>
            <th>{{ __('No. De Usuario') }}</th>
            <th>{{ __('Nombre') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($zonasGeren as $item)
            @foreach ($item->users->where('permiso_id', 3) as $im)
                <tr>
                    <td>
                        {{ $im->id }}
                    </td>
                    <td>
                        {{ $im->name }}
                    </td>
                    <td>
                        {{ $im->estacion->name }}
                    </td>
                    <td>
                        @if ($im->flag_trash == 0)
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
        @endforeach
    </tbody>
</table>