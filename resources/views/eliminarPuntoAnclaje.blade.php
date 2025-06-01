@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Eliminar sistemas de ingeniería') }}</h2>
                    </div>

                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success" id="alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <form method="post" action="{{ route('eliminarSistemas') }}">
                                    @csrf
                                    <div>
                                        <div class="alert alert-primary" role="alert">
                                            Ingresa los números de los sistemas de ingeniería que deseas eliminar, ten en
                                            cuenta que el número de precinto inicial es obligatorio y debe ser menor al
                                            número de precinto final.
                                        </div>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Número de precinto
                                            incial</label>
                                        <input type="text" class="form-control" id="precinto_inicial" aria-describedby=""
                                            name="precinto_inicial" required>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Número de precinto
                                            final</label>
                                        <input type="text" class="form-control" id="precinto_final" aria-describedby=""
                                            name="precinto_final">
                                    </div>
                                    <div class="mb-3 ">
                                        <button type="submit" class="btn btn-primary" style="background-color: orangered; border-color: orangered">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/app/eliminarPrecintos.js') }}"></script>
@endsection