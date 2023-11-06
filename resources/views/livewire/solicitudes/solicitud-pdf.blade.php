<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" href="{{ asset('img/favicon/faviconnew.png') }}" type="image/x-icon">
    <title>{{ __('Solicitud de Productos Para' . ' ' . $estacio) }}</title>

    <!-- Styles AdminLTE 3 -->
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}">

    <style>
        .grid-container {
            width: 1000px;
        }

        .grid-item {
            display: inline-block;
            width: 400px;
            vertical-align: middle;
        }

        .text-dark {
            color: #000;
        }

        .isTable {
            width: 360px;
            font-weight: bold;
            border: 2px solid #CC0000;
        }

        .isTable>tbody>tr {
            border: 2px solid #CC0000;
        }

        .isSecondTable {
            width: 300px;
        }

        .isRed {
            background-color: #CC0000;
            color: #fff;
            margin: 2px;
            padding: 2px;
            width: 120px;
        }

        .isTirdTable {
            border: 2px solid #CC0000;
            width: 100%;
            font-size: 13px;
        }

        .isTirdTable>thead {
            width: 100%;
            border: 2px solid #CC0000;
        }

        .isTirdTable>thead>tr>th {
            border: 2px solid #CC0000;
            text-align: center;
            background-color: #CC0000;
            color: #fff;
            margin: 2px;
            padding: 2px;
        }

        .isTirdTable>tbody {
            border: 2px solid #CC0000;
            text-align: center;
        }

        .isTirdTable>tbody>tr>td {
            margin: 4px;
            padding: 4px;
            font-size: 12px;
            border: 2px solid #CC0000;
            font-weight: bold;
        }
        .motivo{
            margin: 4px;
            padding: 4px;
            font-size: 12px;
            border: 2px solid #CC0000;
            font-weight: bold;
        }
        .motiv{
            background-color: #CC0000;
            color: #fff;
            padding: 2px;
        }
    </style>
</head>

<body>

    <table style="width: 100%">
        <thead>
            <tr>
                <th class="text-left">
                    <img src="{{ public_path('img/logo/FullGas_rojo2.png') }}" alt="" style="width: 150px;">
                </th>
                <th class="text-left text-dark">
                    <h4>
                        {{ __('Requisición de Compras') }}
                    </h4>
                </th>
                <th class="text-right text-dark">
                    {{ date('d-m-Y') }}
                </th>
            </tr>
        </thead>
    </table>

    <br><br><br>

    <div class="grid-container">
        <div class="grid-item">
            <table class="isTable table-bordered">
                <tbody>
                    <tr>
                        <td class="isRed">
                            {{ __('Departamento:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ __('SISTEMAS') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Fecha:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ $fechaSolicitud }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Agente:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ __($estacio) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Zona:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ _($zonaEsta) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Categoria:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ __($catego) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('No. Solicitud') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ __('#' . $numSolicitud) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="grid-item">
            <table class="isSecondTable">
                <tbody>
                    <tr>
                        <td class="text-right">
                            <img src="{{ public_path('img/logo/AbejaFullGas.png') }}" alt=""
                                style="width: 250px">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-responsive">
        <table class="isTirdTable table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Imagen</th>
                    <th style="width: 70%;">Producto</th>
                    <th>Ud.</th>
                    <th>Cant.</th>
                    <th>Prioridad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitudproducto->productos as $item)
                    @if ($item->pivot->flag_trash == 0)
                        <tr>
                            <td class="text-dark">
                                {{ $item->id }}
                            </td>
                            <td>
                                @if ($item->product_photo_path == null)
                                    <img name="photo"
                                        src="{{ public_path('storage/product-photos/imagedefault.jpg') }}"
                                        style="width: 60px;" />
                                @else
                                    <img name="photo" src="{{ public_path('storage/' . $item->product_photo_path) }}"
                                        style="width: 60px;" />
                                @endif
                            </td>
                            <td class="text-left text-dark">
                                {{ $item->name }}
                            </td>
                            <td class="text-dark">
                                {{ $item->unidad }}
                            </td>
                            <td class="text-dark">
                                {{ $item->pivot->cantidad }}
                            </td>
                            <td class="text-dark">ALTO</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <br>

    <div>
        <label for="motivo" class="motiv">Motivo de la solicitud</label>
        <textarea name="motivo" class="motivo" cols="30" rows="10">{{$motivo}}</textarea>
    </div>

    <br>

    <div>
        <label for="motivo" class=" motiv">Monto total de la solicitud</label>
        <div class="input-group mt-3">
          <p><b>Subtotal: </b>${{$totalSoli}}</p>
            <p><b>IVA: </b>${{$iva}}</p>
            <p><b>ISR: </b>${{$isr}}</p>
            <p><b>Total:</b>$ {{number_format($total,2)}}</p>
         </div>
    </div>

    <br> 

    <div>
        <img src="{{ public_path('img/logo/FullPower.png') }}" alt="" style="width: 100%;">
    </div>

    <div>
        <strong>
            <p class="text-center text-dark" style="font-size: 20px; text-align:center;">
                {{ __('WWW.FULLGAS.COM.MX') }}
            </p>
        </strong>
    </div>



    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 780, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>
</body>

</html>