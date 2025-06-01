@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Registrar Uso') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('systemUse.store') }}">
                                    @csrf
                                    <div class="mb-3 col-md-12">
                                        <label for="uso_sistema_proteccion" class="form-label">Uso</label>
                                        <input type="text" class="form-control @error('uso_sistema_proteccion') is-invalid @enderror"
                                            id="uso_sistema_proteccion" aria-describedby="" name="uso_sistema_proteccion"
                                            onkeyup="this.value = this.value.toUpperCase();">
                                        @error('uso_sistema_proteccion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ">
                                        <button type="submit" class="btn btn-primary"
                                            style="background-color: orangered; border-color: orangered">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src='{{ asset('js/app/empresa.js') }}'></script>
    @endsection
