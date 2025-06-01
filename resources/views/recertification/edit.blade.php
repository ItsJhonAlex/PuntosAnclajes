@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Editar Recertificación') }} - ID: {{ $recertification->id }}</h2>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-12">
                                <form method="POST" action="{{ route('recertification.update', $recertification->id) }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="propuesta_principal" class="form-label">Propuesta Principal</label>
                                                <input type="text" class="form-control" id="propuesta_principal" 
                                                    value="{{ $recertification->propuesta_principal }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="propuesta_recertificacion" class="form-label">Número de propuesta recertificación *</label>
                                                <input type="text" class="form-control" id="propuesta_recertificacion" 
                                                    name="propuesta_recertificacion" 
                                                    value="{{ old('propuesta_recertificacion', $recertification->propuesta_recertificacion) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sistema_proteccion" class="form-label">Sistema de protección *</label>
                                                <select class="form-control form-select" id="sistema_proteccion" name="sistema_proteccion" required>
                                                    @foreach ($sistemaProteccion as $sistema)
                                                        <option value="{{ $sistema->id }}" 
                                                            {{ old('sistema_proteccion', $recertification->sistema_proteccion) == $sistema->id ? 'selected' : '' }}>
                                                            {{ $sistema->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="serial" class="form-label">Serial *</label>
                                                <input type="text" class="form-control" id="serial" name="serial" 
                                                    value="{{ old('serial', $recertification->serial) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="precinto" class="form-label">Precinto *</label>
                                                <input type="text" class="form-control" id="precinto" name="precinto" 
                                                    value="{{ old('precinto', $recertification->precinto) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="fecha_recertificacion" class="form-label">Fecha de recertificación *</label>
                                                <input type="date" class="form-control" id="fecha_recertificacion" 
                                                    name="fecha_recertificacion" 
                                                    value="{{ old('fecha_recertificacion', $recertification->fecha_recertificacion) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="marca" class="form-label">Marca *</label>
                                                <select class="form-control form-select" id="marca" name="marca" required>
                                                    <option value="ISI INGENIERÍA" {{ old('marca', $recertification->marca) == 'ISI INGENIERÍA' ? 'selected' : '' }}>ISI INGENIERÍA</option>
                                                    <option value="YOKE" {{ old('marca', $recertification->marca) == 'YOKE' ? 'selected' : '' }}>YOKE</option>
                                                    <option value="OTRO" {{ old('marca', $recertification->marca) == 'OTRO' || (!in_array($recertification->marca, ['ISI INGENIERÍA', 'YOKE'])) ? 'selected' : '' }}>OTRO</option>
                                                </select>
                                                <label for="marca_otro" id="marca_otro" class="form-label mt-2" 
                                                    style="display: {{ old('marca', $recertification->marca) == 'OTRO' || (!in_array($recertification->marca, ['ISI INGENIERÍA', 'YOKE'])) ? 'block' : 'none' }}">
                                                    ¿Cuál?
                                                </label>
                                                <input type="text" class="form-control" id="marca_otro_input" name="marca_otro" 
                                                    value="{{ (!in_array($recertification->marca, ['ISI INGENIERÍA', 'YOKE'])) ? $recertification->marca : old('marca_otro') }}"
                                                    style="display: {{ old('marca', $recertification->marca) == 'OTRO' || (!in_array($recertification->marca, ['ISI INGENIERÍA', 'YOKE'])) ? 'block' : 'none' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="numero_usuarios" class="form-label">Número de usuarios *</label>
                                                <select class="form-control form-select" id="numero_usuarios" name="numero_usuarios" required>
                                                    <option value="1" {{ old('numero_usuarios', $recertification->numero_usuarios) == 1 ? 'selected' : '' }}>1</option>
                                                    <option value="2" {{ old('numero_usuarios', $recertification->numero_usuarios) == 2 ? 'selected' : '' }}>2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="uso" class="form-label">Uso *</label>
                                                <select class="form-control form-select" id="uso" name="uso" required>
                                                    @foreach ($usos as $sistemaUso)
                                                        <option value="{{ $sistemaUso->uso_sistema_proteccion }}" 
                                                            {{ old('uso', $recertification->uso) == $sistemaUso->uso_sistema_proteccion ? 'selected' : '' }}>
                                                            {{ $sistemaUso->uso_sistema_proteccion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="estado" class="form-label">Estado *</label>
                                                <select class="form-control form-select" id="estado" name="estado" required>
                                                    <option value="APROBADO" {{ old('estado', $recertification->estado) == 'APROBADO' ? 'selected' : '' }}>APROBADO</option>
                                                    <option value="NO APROBADO" {{ old('estado', $recertification->estado) == 'NO APROBADO' ? 'selected' : '' }}>NO APROBADO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="ubicacion" class="form-label">Ubicación *</label>
                                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                                            value="{{ old('ubicacion', $recertification->ubicacion) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="observaciones" class="form-label">Observaciones</label>
                                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $recertification->observaciones) }}</textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ url('/lista/recertificacion') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary" style="background-color: orangered; border-color: orangered">
                                            <i class="fas fa-save"></i> Actualizar Recertificación
                                        </button>
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
    <script>
        $(document).ready(function() {
            // Inicializar Select2
            $('#sistema_proteccion').select2({ theme: 'bootstrap-5' });
            $('#uso').select2({ theme: 'bootstrap-5' });

            // Manejar cambios en el sistema de protección
            $("#sistema_proteccion").on("change", function(e) {
                if (e.target.value == 0 || e.target.value == 3) {
                    $("#numero_usuarios").val(1);
                } else {
                    $("#numero_usuarios").val(2);
                }
            });

            // Manejar cambios en la marca
            $("#marca").on("change", function(e) {
                if (e.target.value == "OTRO") {
                    $("#marca_otro").show();
                    $("#marca_otro_input").show();
                } else {
                    $("#marca_otro").hide();
                    $("#marca_otro_input").hide();
                }
            });
        });
    </script>
@endsection 