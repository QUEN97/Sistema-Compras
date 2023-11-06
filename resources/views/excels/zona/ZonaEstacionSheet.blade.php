<table>
    <thead>
        <th colspan="7" rowspan="2">
            {{ __('Estaciones en la Zona') }}
        </th>
    </thead>
</table>

<br><br><br>

<table>
    <thead>
        <tr>
            <th>{{ __('No. De Estación') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Gerente') }}</th>
            <th>{{ __('Supervisor') }}</th>
            {{-- <th>{{ __('Ubicacion') }}</th> --}}
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creado') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($zonasEsta as $item)
            @foreach ($item->estacions as $im)
                <tr>
                    <td>
                        {{ $im->id }}
                    </td>
                    <td>
                        {{ $im->name }}
                    </td>
                    <td>
                        @if ($im->user_id == null)
                            {{ __('Sin Gerente') }}
                        @else
                            {{ $im->user->name }}
                        @endif
                    </td>
                    <td>
                        @if ($im->supervisor_id == null)
                            {{ __('Sin Supervisor') }}
                        @else
                            {{ $im->supervisor->name }}
                        @endif
                    </td>
                    {{-- <td>
                        {{ $im->ubicacion }}
                    </td> --}}
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