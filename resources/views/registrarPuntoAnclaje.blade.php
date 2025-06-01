@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Registrar precinto') }}</h2>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->has('precinto'))
    `                       <div class="alert alert-danger">
                            {{ $errors->first('precinto') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <form method="POST" action="{{ route('insertarPuntoAnclaje') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Empresa</label>
                                        <select class="form-control form-select" id="id_empresa" name="id_empresa" required>
                                        <option value="" readonly selected>Selecciona una opción</option>
                                        @if ($empresas != 'undefined')
                                            @foreach ($empresas as $empresa)
                                                <option value="{{ $empresa->id }}" {{ old('id_empresa') == $empresa->id ? 'selected' : '' }}>
                                                    {{ $empresa->nombre }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="numero_propuesta" class="form-label">Número de propuesta</label>
                                        <input type="text" class="form-control" id="numero_propuesta" aria-describedby="" name="numero_propuesta" value="{{ old('numero_propuesta') }}" required>
                                    </div>    
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Instalador</label>
                                        <select class="form-control form-select" id="instalador" name="instalador" required>
                                            <option value="" readonly selected>Selecciona una opción</option>
                                            {{-- <option value="WILLIAM HERNÁNDEZ CÓRDOBA">WILLIAM HERNÁNDEZ CÓRDOBA</option>
                                            <option value="CARLOS FERNANDO ZAMBRANO">CARLOS FERNANDO ZAMBRANO</option>
                                            <option value="RONALDO SUAZA SUAZA">RONALDO SUAZA SUAZA</option> --}}
                                                @if ($instaladores != 'undefined')
                                                @foreach ($instaladores as $instaladores)
                                                    <option value="{{ $instaladores->nombre }}" {{ old('instalador') == $instaladores->nombre ? 'selected' : '' }}>
                                                        {{ $instaladores->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Persona calificada</label>
                                        <select class="form-control form-select" id="persona_calificada" name="persona_calificada" required>
                                            <option value="DANIEL VELÁSQUEZ ARTEAGA">DANIEL VELÁSQUEZ ARTEAGA</option>
                                            @if ($personaCalificada != 'undefined')
                                                @foreach ($personaCalificada as $personaCalificada)
                                                    <option value="{{ $personaCalificada->nombre }}" {{ old('persona_calificada') == $personaCalificada->nombre ? 'selected' : '' }}>
                                                        {{ $personaCalificada->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="0" class="form-label">Sistema protección</label>
                                        <select class="form-control form-select" id="sistema_proteccion" name="sistema_proteccion" required>
                                            {{-- <option value="PUNTO DE ANCLAJE">PUNTO DE ANCLAJE</option>
                                            <option value="LÍNEA DE VIDA VERTICAL">LÍNEA DE VIDA VERTICAL</option>
                                            <option value="LÍNEA DE VIDA HORIZONTAL">LÍNEA DE VIDA HORIZONTAL</option>
                                            <option value="ESCALERA">ESCALERA</option>
                                            <option value="CANASTILLA">CANASTILLA</option> --}}
                                            <option value="" readonly selected>Selecciona una opción</option>
                                            @if ($sistemaProteccion != 'undefined')
                                                @foreach ($sistemaProteccion as $sistemaProteccion)
                                                    <option value="{{ $sistemaProteccion->nombre }}" {{ old('sistema_proteccion') == $sistemaProteccion->nombre ? 'selected' : '' }}>
                                                        {{ $sistemaProteccion->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    {{--
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Número precinto Inicial</label>
                                        <input type="number" class="form-control" id="precinto_inicial" aria-describedby="" name="precinto_inicial" value="{{ old('precinto_inicial') }}" required>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Número precinto final</label>
                                        <input type="number" class="form-control" id="precinto_final" aria-describedby="" name="precinto_final" value="{{ old('precinto_final') }}" required>
                                        <label for="" class="form-label" id="error_preciento_final" style='display:none'>El número de precinto final no puede ser menor al inicial o igual.</label>
                                    </div>--}}


                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Listado de precintos <div class="badge badge-pill badge-outline-primary" id="precintosLabelCounter">0</div></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="question" style="display:none; cursor: default">
                                                        <div class="mb-2 flex items-center justify-center text-center">
                                                            <center>
                                                                <div class="rounded-full fi-color-custom bg-custom-100 dark:bg-custom-500/20 fi-color-danger p-3">
                                                                    <svg width="20px" height="20px" class="fi-modal-icon h-6 w-6 text-custom-600 dark:text-custom-400 svgRemoveIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#dc2626" aria-hidden="true" data-slot="icon">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
                                                                    </svg>
                                                                </div>
                                                            </center>
                                                        </div>
                                                        <h6 class="pb-2" style="color: #94949b">¿Desea eliminar la dupla del precinto?</h6>
                                                        <input type="button" id="no" value="Cancelar"  class="btn btn-outline-dark" style="width: 45%" />
                                                        <input type="button" id="yes" value="Confirmar" class="btn btn-danger" style="margin-left: 5px!important;width: 45%" />
                                                    </div>

                                                    <ul class="precintosULlist flex-container" id="precintosPairList">
                                                        <li id="fila-1" data-idtemp="1">
                                                            <article class="card card-x mb-3 rounded-xl">
                                                                <div class="card-body">
                                                                    <div class="card-headerCustom card-headerTMP">
                                                                        <h6 class="card-title">
                                                                            Rango de Precinto #<span class="spanCounterLabel">1</span>
                                                                            <span class="d-none rangeVisualData badge badge--success" style="margin-left: 10px!important;"></span>
                                                                            <div class="anclajeButtons">
                                                                                <svg width="20px" height="20px" class="editPercint" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#c0bfbc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#c0bfbc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                                                <svg width="20px" height="20px" class="editPercintActive d-none"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#d97706" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#d97706" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>

                                                                                <svg width="20px" height="20px" wire:loading.remove.delay.default="1" wire:target="mountFormComponentAction('data.items', 'delete', JSON.parse('{\u0022item\u0022:\u0022record-5\u0022}'))" class="fi-icon-btn-icon h-5 w-5 deletePrecintPair" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#c0bfbc" aria-hidden="true" data-slot="icon">
                                                                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd"></path>
                                                                                </svg>
                                                                            </div>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="card-text pt-4 card-bodyTMP">
                                                                        <div class="row d-none">
                                                                            <div class="col-12">
                                                                                <div class="alert alert-danger">
                                                                                    <strong>ATENCIÓN!</strong> <span class="rowPrecintoRangeError"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3 ">
                                                                                <label for="exampleInputPassword1" class="form-label">Número precinto Inicial</label>
                                                                                <input type="number" class="form-control inputPrecintoInicial inputPrecintoRange" id="precinto_inicial" aria-describedby="" name="precinto_inicial[]" value="{{ old('precinto_inicial') }}" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3 ">
                                                                                <label for="exampleInputPassword1" class="form-label">Número precinto final</label>
                                                                                <input type="number" class="form-control inputPrecintoFinal inputPrecintoRange" id="precinto_final" aria-describedby="" name="precinto_final[]" value="{{ old('precinto_final') }}" required>
                                                                                <label for="" class="form-label" id="error_preciento_final" style='display:none'>El número de precinto final no puede ser menor al inicial o igual.</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label for="exampleInputPassword1" class="form-label">Ubicación</label>
                                                                                <input type="text" class="form-control inputPrecintoUbicacion" id="ubicacion" aria-describedby="" name="ubicacion[]" required onkeyup="this.value = this.value.toUpperCase();" value="">
                                                                            </div>
                                                                        </div>
                                                                    </p>
                                                                </div>
                                                            </article>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row align-content-center">
                                                <div class="col-12 align-content-center align-content-lg-center text-center">
                                                    <button type="button" class="btn btn-primary btn-lg btnAddPrecint">
                                                        <div class="btnAddPrecintSpinner spinner-border  spinner-border-sm d-none"></div>
                                                        <svg class="btnAddPrecintSVGIcon" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="rgb(255, 69, 0)" stroke-width="1.5"></path> <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="rgb(255, 69, 0)" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
                                                        Añadir Precinto</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Estado</label>
                                        <select class="form-control form-select" id="estado" name="estado" required>
                                            <option value="APROBADO" {{ old('estado') == 'APROBADO' ? 'selected' : '' }}>APROBADO</option>
                                            <option value="NO APROBADO" {{ old('estado') == 'NO APROBADO' ? 'selected' : '' }}>NO APROBADO</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Fecha de instalación</label>
                                        <input type="date" class="form-control" id="fecha_instalacion" aria-describedby="" name="fecha_instalacion" value="{{ old('fecha_instalacion') }}" required>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Fecha de inspección</label>
                                        <input type="date" class="form-control" id="fecha_inspeccion" aria-describedby="fecha_inspeccion" name="fecha_inspeccion" value="{{ old('fecha_inspeccion') }}" required>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Resistencia en libras</label>
                                        <input type="text" class="form-control" id="" aria-describedby="" name="resistencia" value="{{ old('resistencia') }}" required>

                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Marca</label>
                                        <select class="form-control form-select" id="marca" name="marca" required>
                                            <option value="ISI INGENIERÍA">ISI INGENIERÍA</option>
                                            <option value="YOKE" {{ old('marca') == 'YOKE' ? 'selected' : '' }}>YOKE</option>
                                            <option value="OTRO" {{ old('marca') == 'OTRO' ? 'selected' : '' }}>OTRO</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                    <label for="" id="marca_otro" class="form-label" style='display:none'>Cual ?</label>
                                        <input type="text" class="form-control" id="marca_otro_input" aria-describedby="" name="marca_otro" onkeyup="this.value = this.value.toUpperCase();" style='display:none' value="">
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Número de usuarios</label>
                                        <select class="form-control form-select" id="numero_usuarios" name="numero_usuarios" readonly required>
                                            <option value="1" {{ old('numero_usuarios') == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('numero_usuarios') == '2' ? 'selected' : '' }}>2</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Uso</label>
                                        <select class="form-control form-select" id="uso" name="uso" required>
                                            <option value="" readonly selected>Selecciona una opción</option>
                                            @if ($usos != 'undefined')
                                                @foreach ($usos as $usos)
                                                    <option value="{{ $usos->uso_sistema_proteccion }}" {{ old('uso') == $usos->uso_sistema_proteccion ? 'selected' : '' }}>
                                                        {{ $usos->uso_sistema_proteccion }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Observaciones</label>
                                        <input type="text" class="form-control" id="" aria-describedby="" name="observaciones" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('observaciones') }}">
                                    </div>
                                    {{--
                                    <div class="mb-3 ">
                                        <label for="exampleInputPassword1" class="form-label">Ubicación</label>
                                        <input type="text" class="form-control" id="" aria-describedby="" name="ubicacion" required onkeyup="this.value = this.value.toUpperCase();" value="{{ old('ubicacion') }}">
                                    </div>
                                    --}}
                                    <div class="mb-3 ">
                                        <button type="submit" class="btn btn-primary" id="guardar" style="background-color: orangered; border-color: orangered">Guardar</button>
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
    <script src='{{ asset('js/jquery.blockUI.js') }}'></script>
    <script src='{{ asset('js/app/puntoAnclajes.js') }}'></script>
@endsection
