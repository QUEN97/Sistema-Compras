<table>
    <thead>
        <tr>
            <th rowspan="2">No. de Registro</th>
            <th rowspan="2">Proveedor</th>
            <th rowspan="2">Categoría</th>
            <th rowspan="2">RFC</th>
            <th colspan="4">Datos Bancarios</th>
            <th rowspan="2">Fecha de Registro en el sistema</th>
        </tr>
        <tr>
            <th>Clave</th>
            <th>No. de Cuenata</th>
            <th>Tipo de Banco</th>
            <th>Método de Pago</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($proveedores as $p)
            <tr>
                <th>{{$p->id}}</th>
                <th>{{$p->titulo_proveedor}}</th>
                <th>{{$p->categoria->name}}</th>
                <th>{{$p->rfc_proveedor}}</th>
                <th>{{$p->clabe}}</th>
                <th>{{$p->cuenta}}</th>
                <th>{{$p->banco}}</th>
                <th>
                    @if (is_numeric($p->condicion_pago))
                        REF. NUMERICA: {{$p->condicion_pago}}
                    @else
                        {{$p->condicion_pago}}
                    @endif
                </th>
                <th>{{$p->created_at}}</th>
            </tr>
        @endforeach
    </tbody>
</table>