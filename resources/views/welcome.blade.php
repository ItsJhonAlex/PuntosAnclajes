@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Consultar Sistema de Ingeniería') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="GET" action="{{ route('welcome') }}">
                                    <div class="row mb-2">
                                        <div class="col-md-2">
                                            <label for="puntoAnclaje" class="">{{ __('Precinto') }}</label>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-1">
                                            <input id="puntoAnclaje" type="text" class="form-control" name="puntoAnclaje"
                                                required autocomplete="current-puntoAnclaje">
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100"
                                                style="background-color: orangered; border-color: orangered">
                                                {{ __('Consultar') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12  pt-4">
                                @php
                                    // var_dump($pageWasRefreshed);
                                @endphp
                                @if ($puntoAnclaje != null)
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <h5 class="card-title" style="font-weight: bold">Sistema de ingenieria</h5>
                                            <h6 class="card-subtitle mb-2 ">Precinto:{{ $puntoAnclaje->precinto }}</h6>
                                            <table style="width:100%" class="table">
                                                <tr>
                                                    <th>Empresa:</th>
                                                    <td>{{ $puntoAnclaje->empresa->nombre }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Instalador:</th>
                                                    <td>{{ $puntoAnclaje->instalador }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Persona Calificada:</th>
                                                    <td>{{ $puntoAnclaje->persona_calificada }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Sistema protección:</th>
                                                    <td>{{ $puntoAnclaje->sistema_proteccion }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Serial:</th>
                                                    <td>{{ $puntoAnclaje->serial }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Precinto:</th>
                                                    <td>{{ $puntoAnclaje->precinto }}</td>
                                                </tr>
                                                <tr>
                                                    @if ($puntoAnclaje->estado == 'NO APROBADO')
                                                        <th>Estado:</th>
                                                        <td><button type="button" class="btn btn-danger btn-sm">NO
                                                                APROBADO</button></td>
                                                    @elseif ($puntoAnclaje->estado == 'APROBADO')
                                                        <th>Estado:</th>
                                                        <td><button type="button"
                                                                class="btn btn-success btn-sm">APROBADO</button></td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th>Fecha de instalación:</th>
                                                    <td>{{ $puntoAnclaje->fecha_instalacion }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Fecha que se inspeccionó:</th>
                                                    <td>{{ $puntoAnclaje->fecha_inspeccion }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Fecha próxima inspección:</th>
                                                    <td>{{ $puntoAnclaje->fecha_proxima_inspeccion }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Marca:</th>
                                                    <td>{{ $puntoAnclaje->marca }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Número de usuarios:</th>
                                                    <td>{{ $puntoAnclaje->numero_usuarios }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Uso:</th>
                                                    <td>{{ $puntoAnclaje->uso }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Resistencia:</th>
                                                    <td>{{ $puntoAnclaje->resistencia }} lbs/f</td>
                                                </tr>
                                                <tr>
                                                    <th>Ubicación:</th>
                                                    <td>{{ $puntoAnclaje->ubicacion }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Observaciones:</th>
                                                    <td>{{ $puntoAnclaje->observaciones }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Propuesta instalación:</th>
                                                    <td>{{ $puntoAnclaje->propuesta_instalacion }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Propuesta Recertificacion:</th>
                                                    <td>{{ $puntoAnclaje->propuesta_recertificacion }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    @if ($showAlert)
                                        <div class="alert alert-danger  alert-dismissible fade show" role="alert"
                                            id="alert-index">

                                            {!! $message !!}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            {{-- <div class="col-md-12">
                                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleCaptions"
                                            data-bs-slide-to="0" class="active" aria-current="true"
                                            aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions"
                                            data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions"
                                            data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{URL::asset('/images/142305303_3878864728802035_6920617284091527904_o.jpg')}}" loading="lazy" class="d-block img-fluid" style="width:30em;max-height:30em" alt="...">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>First slide label</h5>
                                                <p>Some representative placeholder content for the first slide.</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{URL::asset('/images/Escalera.PNG')}}" loading="lazy" class="d-block w-100 img-fluid" style="width:30em;max-height:30em" alt="...">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Second slide label</h5>
                                                <p>Some representative placeholder content for the second slide.</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{URL::asset('/images/IMG_0186 2.JPG')}}" loading="lazy" class="d-block w-100 img-fluid" style="width:30em;max-height:30em" alt="...">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Third slide label</h5>
                                                <p>Some representative placeholder content for the third slide.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src='{{ asset('js/app/index.js') }}'></script>
@endsection
