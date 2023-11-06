<table>
    <thead>
        <tr>
            <th>{{ __('No. De Registro') }}</th>
            <th>{{ __('Estación') }}</th>
            <th>{{ __('Proveedor') }}</th>
            <th>{{ __('Nombre del archivo') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($facturas as $item)
            <tr>
                <th>{{$item->id}}</th>
                <th>{{$item->estacion}}</th>
                <th>{{$item->proveedor}}</th>
                <th>{{$item->nombre_archivo}}</th>
            </tr>
        @endforeach
    </tbody>
</table>