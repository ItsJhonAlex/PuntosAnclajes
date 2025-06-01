@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Instaladores') }}</div>
                    <div class="card-body">
                        <div class="row pb-4 d-flex flex-row-reverse mb-2">
                            <div class="col-md-2 ">
                                <a class="btn btn-primary ml-1" href="{{ url('/worker/create') }}" role="button"
                                    style="background-color: orangered; border-color: orangered">Registrar instalador</a>
                            </div>
                        </div>
                        <table class="table " id="workersTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src='{{ asset('js/app/worker.js') }}'></script>
    @endsection
