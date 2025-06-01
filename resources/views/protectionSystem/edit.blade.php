@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Editar tipo de sistema de protección') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('protectionSystem.update',$protectionSystem->id) }}">
                                    @csrf
                                     @method('PUT')
                                    <div class="mb-3 col-md-12">
                                        <label for="nombre" class="form-label">Razon social</label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                            id="nombre" aria-describedby="" name="nombre"
                                            onkeyup="this.value = this.value.toUpperCase();" value="{{$protectionSystem->nombre}}">
                                        @error('nombre')
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
