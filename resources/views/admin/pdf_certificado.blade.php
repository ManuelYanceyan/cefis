<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: a4 landscape;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            width: 100%;
            height: 100%;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .content {
            position: absolute;
            top: 38%;
            left: 15%;
            width: 80%;
            text-align: center;
        }
        .otorgado {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .nombre {
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 30px;
            color: #000;
        }
        .descripcion {
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            margin-bottom: 50px;
        }
        .negrita {
            font-weight: bold;
        }
        .fecha-lugar {
            text-align: right;
            font-style: italic;
            font-size: 14px;
            margin-top: 30px;
            margin-right: 50px;
        }
    </style>
</head>
<body>
    @php
        $path = storage_path('app/public/certificados/38.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp
    <img src="{{ $base64 }}" class="background" alt="Fondo Certificado">

    <div class="content">
        <div class="otorgado">OTORGADO A:</div>
        
        <div class="nombre">
            {{ $user->paternal_surname }} {{ $user->maternal_surname }} {{ $user->name }}
        </div>

        <div class="descripcion">
            por su destacada participación en calidad de <span class="negrita">{{ $rol }}</span> en las conferencias del<br>
            <span class="negrita">{{ $evento->name }}</span>, realizado el {{ $fechaTexto }}, organizado por la Facultad<br>
            de Ingeniería de Sistemas de la UNCP, con una duración de veinte (20) horas<br>
            académicas.
        </div>

        <div class="fecha-lugar">
            Huancayo, {{ $fechaTexto }}.
        </div>
        
    </div>
        
    <div style="position: absolute; bottom: 250px; left: 220px; text-align: left; z-index: 10;">
        <p style="font-size: 10px; color: #555; margin: 0;">Verificar en:</p>
        <p style="font-size: 10px; color: #000; margin: 0;">{{ $qrUrl }}</p>
    </div>

    <div style="position: absolute; bottom: 110px; right: 120px; z-index: 20;">
        <img src="{{ $qrCodeBase64 }}" alt="QR Code" style="width: 100px; height: auto;">
    </div>
</body>
</html>
