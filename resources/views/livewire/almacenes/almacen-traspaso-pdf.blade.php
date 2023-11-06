{{-- <!DOCTYPE html>
<html>
<head>
    <title>{{ __( 'Traspaso de Productos con Folio:') }}</title>

    <!-- Styles AdminLTE 3 -->
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}">

    <style>
        .body {
            margin: 0;
            padding: 0;
            border: none;
            border-color: none;
        }

        .grid-container {
            width: 1000px;
            border: none;
            border-color: none;
        }

        .grid-item {
            display: inline-block;
            width: 490px;
            vertical-align: middle;
        }

        .grid-item-ii {
            display: inline-block;
            width: 1100px;
            vertical-align: middle;
            border: none;
            border-color: none;
        }

        .text-dark {
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .f-19 {
            font-size: 19px;
        }

        .m-0 {
            margin: 0;
        }

        .mt-0 {
            margin-top: 0;
        }

        .pl-2 {
            padding-left: 3em;
            padding-right: 3em;
        }

        .isTable {
            width: 480px;
            font-weight: bold;
            border: 1px solid #E8E8E8;
        }

        .isTable > tbody > tr {
            border: 2px solid #000;
        }

        .isSecondTable {
            width: 80px;
            font-weight: bold;
            border: 1px solid #E8E8E8;
        }

        .isSecondTable > tbody > tr {
            border: 2px solid #000;
        }

        .isRed {
            background-color: #E8E8E8;
            color: #000;
            margin: 2px;
            padding: 2px;
            width: 100px;
        }

        .isTirdTable {
            border: 2px solid #000;
            width: 100%;
            font-size: 13px;
        }

        .isTirdTable > thead {
            width: 100%;
            border: 2px solid #000;
        }

        .isTirdTable > thead > tr > th {
            border: 2px solid #000;
            text-align: center;
            background-color: #E8E8E8;
            color: #000;
            margin: 2px;
            padding: 2px;
        }

        .isTirdTable > tbody {
            border: 2px solid #000;
            text-align: center;
        }

        .isTirdTable > tbody > tr > td {
            margin: 4px;
            padding: 4px;
            font-size: 12px;
            border: 2px solid #000;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table style="width: 100% mt-0">
        <thead >
            <tr>
                <th class="text-left m-0">
                    <img src="{{ public_path('img/logo/FullGas.png') }}" alt="" style="width: 170px;">
                </th>
                <th class="text-center text-dark">
                    <h4 class="text-center f-19 pl-2">
                        {{ __('TRASPASO DE EQUIPOS') }}
                    </h4>
                </th>
                <th class="text-right text-dark m-0">
                    <img src="{{ public_path('img/logo/AbejaFullGas.png') }}" alt="" style="width: 190px;">
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
                            {{ __('Responsable de Entrega:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            {{ __('SISTEMAS') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Quien Solicita:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            ergrege
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Motivo:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            ergerg
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="grid-item">
            <table class="isSecondTable table-bordered">
                <tbody>
                    <tr>
                        <td class="text-left isRed">
                            {{ __('Fecha:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            erge
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Folio:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            ergerge
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <br>

    <div class="">
        <table class="isTirdTable table-bordered">
            <thead>
                <tr>
                    <th>{{ __('No.') }}</th>
                    <th>{{ __('Estación') }}</th>
                    <th style="width: 30%;">{{ __('Equipo/Material') }}</th>
                    <th>{{ __('Unidad') }}</th>
                    <th>{{ __('Cant.') }}</th>
                    <th style="width: 40%;">{{ __('Observación') }}</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td class="text-dark">
                            eg
                        </td>
                        <td class="text-dark">
                            erge
                        </td>
                        <td class="text-left text-dark">
                            ergreg
                        </td>
                        <td class="text-dark">
                            erg
                        </td>
                        <td class="text-dark">
                            ergrge
                        </td>
                        <td class="text-dark">
                            ergeg
                        </td>
                    </tr>
            </tbody>
        </table>
    <div>

    <br><br><br>

    <div class="grid-container">
        <div class="grid-item-ii">
            <p class="text-center text-dark">
                {{ __('________________________________') }} <br>
                {{ __('Nombre y Firma del Solicitante') }}
            </p>
        </div>
    </div>

    <br>

    <div>
        <p>
            {{ __('AL FIRMAR EL PRESENTE RESGUARDO ME OBLIGO A:') }}
        </p>
        <p>
            {{ __('CUBRIRÉ POR MI CUENTA EL IMPORTE DE LOS DAÑOS, FALTANTE DE EQUIPO, ACCESORIOS O HERRAMIENTAS DURANTE EL TIEMPO QUE EL BIEN ESTÉ BAJO MI RESGUARDO.') }}
        </p>
        <p>
            {{ __('CONSERVAR EN OPTIMAS CONDICIONES DE FUNCIONAMIENTO DEL BIEN, ASÍ COMO VIGILAR EL OPORTUNO MANTENIMIENTO DE ESTE.') }}
        </p>
        <p>
            {{ __('QUE SE ME RESPONSABILICE DE LO QUE PROCEDA EN CASO DE INCUMPLIMIENTO AL CUALQUIERA DE LOS PUNTOS ANTERIORES.') }}
        </p>
    </div>

    <br>

    <div>
        <strong>
            <p class="text-center text-dark" style="font-size: 20px;">
                {{ __('WWW.FULLGAS.COM.MX') }}
            </p>
        </strong>
    </div>

    <br>

    <div>
        <strong>
            <p class="text-center text-dark" style="font-size: 13px">
                {{ __('97125 Mérida, Yucatán, México | sistemas@fullgas.com.mx | 9999269020| 9999686823') }}
            </p>
        </strong>
    </div>

    <div>
        <img src="{{ public_path('img/logo/FullPower.png') }}" alt="" style="width: 100%;">
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
</html> --}}


<!DOCTYPE html>
<html>
<head>
    <title>{{ __( 'Traspaso de Productos con Folio:'. ' ' .$folioEntrada) }}</title>

    <!-- Styles AdminLTE 3 -->
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}">

    <style>
        .body {
            margin: 0;
            padding: 0;
            border: none;
            border-color: none;
        }

        .grid-container {
            width: 1000px;
            border: none;
            border-color: none;
        }

        .grid-item {
            display: inline-block;
            width: 490px;
            vertical-align: middle;
        }

        .grid-item-ii {
            display: inline-block;
            width: 1100px;
            vertical-align: middle;
            border: none;
            border-color: none;
        }

        .text-dark {
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .f-19 {
            font-size: 19px;
        }

        .m-0 {
            margin: 0;
        }

        .mt-0 {
            margin-top: 0;
        }

        .pl-2 {
            padding-left: 3em;
            padding-right: 3em;
        }

        .isTable {
            width: 480px;
            font-weight: bold;
            border: 1px solid #E8E8E8;
        }

        .isTable > tbody > tr {
            border: 2px solid #000;
        }

        .isSecondTable {
            width: 80px;
            font-weight: bold;
            border: 1px solid #E8E8E8;
        }

        .isSecondTable > tbody > tr {
            border: 2px solid #000;
        }

        .isRed {
            background-color: #E8E8E8;
            color: #000;
            margin: 2px;
            padding: 2px;
            width: 100px;
        }

        .isTirdTable {
            border: 2px solid #000;
            width: 100%;
            font-size: 13px;
        }

        .isTirdTable > thead {
            width: 100%;
            border: 2px solid #000;
        }

        .isTirdTable > thead > tr > th {
            border: 2px solid #000;
            text-align: center;
            background-color: #E8E8E8;
            color: #000;
            margin: 2px;
            padding: 2px;
        }

        .isTirdTable > tbody {
            border: 2px solid #000;
            text-align: center;
        }

        .isTirdTable > tbody > tr > td {
            margin: 4px;
            padding: 4px;
            font-size: 12px;
            border: 2px solid #000;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table style="width: 100% mt-0">
        <thead >
            <tr>
                <th class="text-left m-0">
                    <img src="{{ public_path('img/logo/FullGas.png') }}" alt="" style="width: 170px;">
                </th>
                <th class="text-left text-dark">
                    <h4 class="text-center f-19 pl-2">
                        {{ __('TRASPASO DE PRODUCTOS') }}
                    </h4>
                </th>
                <th class="text-right text-dark m-0">
                    <img src="{{ public_path('img/logo/AbejaFullGas.png') }}" alt="" style="width: 190px;">
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
                            {{ __('Responsable de Entrega:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            {{ $solicitadoPor }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Quien Solicita:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            {{ $solicitaEsta }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Motivo:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            {{ $elMotivo }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="grid-item">
            <table class="isSecondTable table-bordered">
                <tbody>
                    <tr>
                        <td class="text-left isRed">
                            {{ __('Fecha:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            {{ $fechaEntrada }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Folio:') }}
                        </td>
                        <td class="text-center text-dark isRed">
                            {{ $folioEntrada }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <br>

    <div class="">
        <table class="isTirdTable table-bordered">
            <thead>
                <tr>
                    <th>{{ __('No.') }}</th>
                    <th style="width: 30%;">{{ __('Equipo/Material') }}</th>
                    <th>{{ __('Unidad') }}</th>
                    <th>{{ __('Cant.') }}</th>
                    <th style="width: 40%;">{{ __('Observación') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($foliosPedidos as $item)
                    <tr>
                        <td class="text-dark">
                            {{ $item->id }}
                        </td>
                        <td class="text-left text-dark">
                            {{ $item->name }}
                        </td>
                        <td class="text-dark">
                            {{ $item->unidad }}
                        </td>
                        <td class="text-dark">
                            {{ $item->cantidad }}
                        </td>
                        <td class="text-dark">
                            {{ $item->observacion }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    <div>

    <br><br><br>

    <div class="grid-container">
        <div class="grid-item-ii">
            <p class="text-center text-dark">
                {{ __('________________________________') }} <br>
                {{ __('Nombre y Firma del Solicitante') }}
            </p>
        </div>
    </div>

    <br>

    <div>
        <p>
            {{ __('AL FIRMAR EL PRESENTE RESGUARDO ME OBLIGO A:') }}
        </p>
        <p>
            {{ __('CUBRIRÉ POR MI CUENTA EL IMPORTE DE LOS DAÑOS, FALTANTE DE EQUIPO, ACCESORIOS O HERRAMIENTAS DURANTE EL TIEMPO QUE EL BIEN ESTÉ BAJO MI RESGUARDO.') }}
        </p>
        <p>
            {{ __('CONSERVAR EN OPTIMAS CONDICIONES DE FUNCIONAMIENTO DEL BIEN, ASÍ COMO VIGILAR EL OPORTUNO MANTENIMIENTO DE ESTE.') }}
        </p>
        <p>
            {{ __('QUE SE ME RESPONSABILICE DE LO QUE PROCEDA EN CASO DE INCUMPLIMIENTO AL CUALQUIERA DE LOS PUNTOS ANTERIORES.') }}
        </p>
    </div>

    <br>

    <div>
        <strong>
            <p class="text-center text-dark" style="font-size: 20px;">
                {{ __('WWW.FULLGAS.COM.MX') }}
            </p>
        </strong>
    </div>

    <br>

    <div>
        <strong>
            <p class="text-center text-dark" style="font-size: 13px">
                {{ __('97125 Mérida, Yucatán, México | sistemas@fullgas.com.mx | 9999269020| 9999686823') }}
            </p>
        </strong>
    </div>

    <div>
        <img src="{{ public_path('img/logo/FullPower.png') }}" alt="" style="width: 100%;">
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