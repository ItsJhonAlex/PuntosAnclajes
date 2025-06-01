<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Sistema de protección</th>
                <th>Empresa</th>
                <th>Precinto</th>
                <th>Serial</th>
                <th>Instalador</th>
                <th>Persona calificada</th>
                <th>Fecha instalación</th>
                <th>Fecha inspección</th>
                <th>Fecha próxima inspección</th>
                <th>Marca</th>
                <th>Número de usuarios</th>
                <th>Uso</th>
                <th>Resistencia</th>
                <th>Estado</th>
                <th>Ubicación</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($precintos as $precinto)
            <tr>
                <td>{{ $precinto->sistema_proteccion}}</td>
                <td>{{ $precinto->empresa ? $precinto->empresa->nombre : 'No disponible'}}</td>
                <td>{{ $precinto->precinto }}</td>
                <td>{{ $precinto->serial }}</td>
                <td>{{ $precinto->instalador }}</td>
                <td>{{ $precinto->persona_calificada }}</td>
                <td>{{ $precinto->fecha_instalacion }}</td>
                <td>{{ $precinto->fecha_inspeccion }}</td>
                <td>{{ $precinto->fecha_proxima_inspeccion }}</td>
                <td>{{ $precinto->marca }}</td>
                <td>{{ $precinto->numero_usuarios }}</td>
                <td>{{ $precinto->uso }}</td>
                <td>{{ $precinto->resistencia }}</td>
                <td>{{ $precinto->estado }}</td>
                <td>{{ $precinto->ubicacion }}</td>
                <td>{{ $precinto->observaciones }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>