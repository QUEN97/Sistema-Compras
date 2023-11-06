<table>
    <thead>
        <tr>
            <th>Estación</th>
            <th>Subtotal</th>
            <th>I.V.A</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $d)
            <tr>
                <th>{{$d->name}}</th>
                <th>{{$d->total - ($d->total * 0.16)}}</th>
                <th>{{$d->total * 0.16}}</th>
                <th>{{$d->total}}</th>
            </tr>
        @endforeach
    </tbody>
</table>