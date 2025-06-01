@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Registrar Empresa') }}</h2>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <form method="POST" action="{{ route('insertarEmpresa') }}">
                                    @csrf
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Nombre empresa</label>
                                        <input type="text" class="form-control" id="" aria-describedby="" name="empresa" onkeyup="this.value = this.value.toUpperCase();" >
                                    </div>
                                    <div class="mb-3 ">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
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
    <script src='{{ asset('js/app/empresa.js') }}'></script>
@endsection
