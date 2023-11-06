<table>
    <thead class="head">
        <th colspan="7" rowspan="2" style="background-color: red;color:white;vertical-align:middle; text-align:center;">
            {{ __('Reporte General de Solicitudes') }}
        </th>
    </thead>
</table>

<br>
<br>
<br>

@foreach ($zonas as $zon)
    <table>
        <tr>
            <th colspan="3" style="background-color: black;color:white;vertical-align:middle; text-align:center;">{{$zon->name}}</th>
        </tr>
        <thead>
            <tr>
                <th style="background-color: red;color:white;">Estación</th>
                <th style="background-color: red;color:white;">Categoría</th>
                <th style="background-color: red;color:white;">Cantidad Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categ as $cate)
                @foreach ($zon->estacions as $estac)
                    <tr>
                        <td>{{$estac->name}}</td>
                        <td>{{ $cate->name }}</td>
                        <td style="text-align: center;">
                            @foreach ($soliTot as $total)
                                @if ($total->estID == $estac->id && $total->catID == $cate->id)
                                    {{ $total->total }}
                                @endif
                            @endforeach
                        </td>    
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    {{-- <table>
        <thead>
            <tr>
                <th rowspan="2" style="background-color: black;color:white;vertical-align:middle; text-align:center;">Categoría</th>
                <th colspan="{{ $zon->estacions->count() }}" style="vertical-align:middle; text-align:center;">{{ $zon->name }}</th>
            </tr>
            <tr>
                @foreach ($zon->estacions as $estac)
                    <th style="vertical-align:middle; text-align:center;">{{ $estac->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($categ as $cate)
                <tr>
                    <td>{{ $cate->name }}</td>

                    @foreach ($zon->estacions as $estac)
                        <td style="text-align: center;">
                            @foreach ($soliTot as $total)
                                @if ($total->estID == $estac->id && $total->catID == $cate->id)
                                    {{ $total->total }}
                                @endif
                            @endforeach
                        </td>    
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table> --}}
@endforeach