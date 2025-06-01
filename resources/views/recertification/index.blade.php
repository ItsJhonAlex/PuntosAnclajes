@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Sistemas de Anclajes por propuesta') }}</div>
                    <div class="card-body">
                        <form action="{{ route('system-project-data') }}" method="GET">
                            <div class="row pb-4 d-flex mb-2">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="propouse_system" class="form-label">Seleccione las propuestas que desea
                                            consultar</label>
                                        <select class="form-control form-select" id="propouse_system"
                                            name="systemProyects[]" required multiple="multiple">
                                            @foreach ($systemProjects as $systemProject)
                                                <option value="{{ $systemProject->propuesta_instalacion }}">
                                                    {{ $systemProject->propuesta_instalacion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="">
                                        <button type="submit" class="btn btn-primary" style="background-color: orangered; border-color: orangered">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if (count($dataTableSystemProjects) === 0)
                            <div class="alert alert-warning" role="alert">
                                No hay datos disponibles, por favor seleccione una o mas propuesta de instalación
                            </div>
                        @else
                            <table class="table table-hover table-bordered" id="protectionSystemTable" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Empresa</th>
                                        <th>Propuesta de Instalación</th>
                                        <th>Fecha de Instalación</th>
                                        <th>Recertificaciones</th>
                                        <th>Fecha de Recertificación</th>
                                        <th>Cantidad de sistemas Instalados</th>
                                        <th>Cantidad de sistemas Recertificados</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTableSystemProjects as $data)
                                        <tr>
                                            <td>{{ $data['empresa'] }}</td>
                                            <td>{{ $data['propuesta_instalacion'] }}</td>
                                            <td>{{ $data['fecha_instalacion'] }}</td>
                                            <td>
                                                <ul>
                                                    @if (count($data['recertificaciones']) === 0)
                                                        <span>No hay recertificaciones</span>
                                                    @else
                                                        @foreach ($data['recertificaciones'] as $recertificacion)
                                                            <li>{{ $recertificacion }}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($data['instalaciones_recertificacion'] as $instalacionRecertificacion)
                                                        <li>
                                                            {{ $instalacionRecertificacion['fecha_recertificacion'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($data['instalaciones'] as $instalacion)
                                                        <li>{{ $instalacion['total'] . ' ' . $instalacion['sistema_proteccion'] }}
                                                            - Fecha de instalacion {{ $instalacion['fecha_instalacion'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($data['instalaciones_recertificacion'] as $instalacionRecertificacion)
                                                        <li>{{ $instalacionRecertificacion['total'] . ' ' . $instalacionRecertificacion['sistema_proteccion']['nombre'] }}
                                                            - Fecha de instalacion
                                                            {{ $instalacionRecertificacion['fecha_recertificacion'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <!-- Botón para redirigir a la ruta de creación de recertificación -->
                                                <a href="{{ route('recertification.create', ['propouse' => $data['propuesta_instalacion']]) }}"
                                                    class="btn btn-primary" style="background-color: orangered; border-color: orangered">Registrar Recertificación</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src='{{ asset('js/app/systemProjects.js') }}'></script>
@endsection
