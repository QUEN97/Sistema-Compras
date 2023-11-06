@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'SistemaCompras')
<img src="{{asset('img/logo/FullGas_rojo2.png')}}" style="width:250px;" class="logo" alt="Sistema Compras Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
