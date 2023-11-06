<table>
    <thead>
        <tr>
            <th>Estación</th>
            <th>Subtotal Acumulado</th>
            <th>I.V.A Acumulado</th>
            <th>ISR Acumulado</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $d)
        <tr>
            @if ($d->total !=null && $d->totalex !=null)
                <th>{{$d->name}}</th>
                <th>{{(($d->total + $d->totalex) - (($d->total + $d->totalex)* 0.16)) - $d->isr}}</th>
                <th>{{($d->total + $d->totalex) * 0.16}}</th>
                @if ($d->isr > 0)
                    <th>{{$d->isr}}</th>
                    {{-- <th>{{(($d->total + $d->totalex) - (($d->total + $d->totalex)* 0.16))*0.125}}</th> --}}    
                @else
                    <th></th>
                @endif
                <th>{{($d->total + $d->totalex) - $d->isr}}</th>
            @elseif($d->total ==null)
                <th>{{$d->name}}</th>
                <th>{{($d->totalex - ($d->totalex* 0.16)) - $d->isr}}</th>
                <th>{{$d->totalex * 0.16}}</th>
                @if ($d->isr > 0)
                    <th>{{$d->isr}}</th>
                    {{-- <th>{{(($d->total + $d->totalex) - (($d->total + $d->totalex)* 0.16))*0.125}}</th> --}}    
                @else
                    <th></th>
                @endif
                <th>{{$d->totalex - $d->isr}}</th>
            @else
            <th>{{$d->name}}</th>
            <th>{{$d->total - ($d->total* 0.16)}}</th>
            <th>{{$d->total * 0.16}}</th>
            <th></th>
            <th>{{$d->total}}</th>
            @endif
        </tr>
        
            
        @endforeach
    </tbody>
</table>