<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>I.V.A</th>
            <th>ISR</th>
            <th>Total</th>
            <th>Categoría</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $d)
            @foreach ($d->extraordinarios as $ex)
                <tr>
                    <th>{{$ex->producto_extraordinario}}</th>
                    <th>{{$ex->cantidad}}</th>
                    <th>{{$ex->total - ($ex->total * 0.16)}}</th>
                    <th>{{$ex->total * 0.16}}</th>
                    @if ($ex->tipo=="Servicio")
                        <th>{{($ex->total - ($ex->total * 0.16)) * 0.0125}}</th>
                        <th>{{$ex->total -(($ex->total - ($ex->total * 0.16)) * 0.0125)}}</th>
                    @else
                        <th></th>
                        <th>{{$ex->total}}</th>
                    @endif
                    
                    <th>{{$d->categoria->name}}</th>
                </tr>
            @endforeach
        @endforeach
        <tr>
            <th colspan="2" style="background-color: #ff0000; color:white" >TOTAL</th>
            @foreach ($total as $t)
                <th style="background-color: #ff0000; color:white">{{$t->total - ($t->total * 0.16)}}</th>
                <th style="background-color: #ff0000; color:white">{{$t->total * 0.16}}</th>
                <th style="background-color: #ff0000; color:white">{{$t->isr}}</th>
                <th style="background-color: #ff0000; color:white">{{$t->total - $t->isr}}</th>
            @endforeach
            
        </tr>
    </tbody>
</table>