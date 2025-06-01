@extends('layouts.app')

@section('content')

    <style>

        .swal2-actions{
           position: relative!important;
            z-index: 991!important;
        }

        .autocomplete-suggestion{
            padding-top: 5px!important;
            height: 45px!important;
            text-align: left!important;
            margin-left: 4%!important;
        }

        .autocomplete-suggestion:hover{
            background-color: #233357!important;
            color: white!important;
            cursor: pointer!important;
            z-index: 999!important;
            position: relative!important;
        }


        .autocomplete-suggestions{
            position: absolute!important;
            z-index: 9999!important;
            width: 80% !important;
            background-color: antiquewhite!important;
            margin-left: 2%!important;
            overflow-y: scroll!important;
            height: 150px!important;
            text-align: left!important;
        }

        div:where(.swal2-container) h2:where(.swal2-title) {
            position: absolute!important;
            max-width: 100%;
            margin: 0;
            padding: .8em 1em 0;
            color: inherit;
            font-size: 1.50em !important;
            font-weight: 600;
            text-align: center;
            text-transform: none;
            word-wrap: break-word;
        }


        .swal2-input::placeholder {
            color: #202e4a;
            opacity: 1; /* Firefox */
        }

        .swal2-input::-ms-input-placeholder { /* Edge 12-18 */
            color: #202e4a;
        }

        .swal2-input {
            height: 2.425em !important;
            padding: 0 0.75em !important;
            margin-left: 10px !important;
            width: 90% !important;
        }

        .iconoPassword1{
            position: absolute!important;
            margin-top: 30px!important;
            right: 80px!important;
        }
        .iconoPassword1:hover{
            cursor: pointer!important;
        }





        ul{
            display: inline-flex!important;
            text-align: center!important;
            align-content: center!important;
            list-style: none!important;
        }

        li {
            /*float: left;*/
            margin-left: 5px!important;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 16px;
            text-decoration: none;
        }

        .btn-CustomOrange{
            background-color: #f0bc74!important;
            color:#202e4a!important;
            border: solid 1px #f0bc74!important;
        }

        .btn-CustomOrange:hover{
            background-color: #202e4a!important;
            color:white!important;
            border: solid 1px #f0bc74!important;
        }

        .btn-CustomOrange:hover svg {
            fill: white!important;
            stroke: white!important;
        }


        li a:hover {
            background-color: #111111;
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            @if($listaPrecintosDuplicadosSTR!="")
                <div class="containr col-md-10">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading h4">ATENCION</h4>
                        <hr>
                        <p>Error: Los siguientes precintos ya existen y no se pudieron registrar: </p>
                        <p class="card-text">{{$listaPrecintosDuplicadosSTR}} !</p>

                    </div>
                </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Sistemas de ingeniería.') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row pb-4 d-flex flex-row-reverse mb-2">
                            <center>
                                <ul>
                                    <li class="mb-2">
                                        <a class="btn btn-CustomOrange ml-1" href="{{ url('/exportar') }}" role="button"
                                            style="background-color: orangered; border-color: orangered">
                                            <svg width="25px" height="25px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title>file_type_excel2</title><path d="M28.781,4.405H18.651V2.018L2,4.588V27.115l16.651,2.868V26.445H28.781A1.162,1.162,0,0,0,30,25.349V5.5A1.162,1.162,0,0,0,28.781,4.405Zm.16,21.126H18.617L18.6,23.642h2.487v-2.2H18.581l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2H28.941Z" style="fill:#20744a;fill-rule:evenodd"></path><rect x="22.487" y="7.439" width="4.323" height="2.2" style="fill:#20744a"></rect><rect x="22.487" y="10.94" width="4.323" height="2.2" style="fill:#20744a"></rect><rect x="22.487" y="14.441" width="4.323" height="2.2" style="fill:#20744a"></rect><rect x="22.487" y="17.942" width="4.323" height="2.2" style="fill:#20744a"></rect><rect x="22.487" y="21.443" width="4.323" height="2.2" style="fill:#20744a"></rect><polygon points="6.347 10.673 8.493 10.55 9.842 14.259 11.436 10.397 13.582 10.274 10.976 15.54 13.582 20.819 11.313 20.666 9.781 16.642 8.248 20.513 6.163 20.329 8.585 15.666 6.347 10.673" style="fill:#ffffff;fill-rule:evenodd"></polygon></g></svg>
                                            Descargar en excel</a>
                                    </li>
                                    <li class="">
                                        <a class="btn btn-CustomOrange ml-1" href="{{ url('/registrarPuntoAnclaje') }}" role="button"
                                            style="background-color: orangered; border-color: orangered">
                                            <svg width="25px" height="25px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M810.666667 149.333333H213.333333c-23.466667 0-42.666667 19.2-42.666666 42.666667v128c0 23.466667 19.2 42.666667 42.666666 42.666667h597.333334c23.466667 0 42.666667-19.2 42.666666-42.666667V192c0-23.466667-19.2-42.666667-42.666666-42.666667zM810.666667 405.333333H213.333333c-23.466667 0-42.666667 19.2-42.666666 42.666667v128c0 23.466667 19.2 42.666667 42.666666 42.666667h597.333334c23.466667 0 42.666667-19.2 42.666666-42.666667v-128c0-23.466667-19.2-42.666667-42.666666-42.666667zM810.666667 661.333333H213.333333c-23.466667 0-42.666667 19.2-42.666666 42.666667v128c0 23.466667 19.2 42.666667 42.666666 42.666667h597.333334c23.466667 0 42.666667-19.2 42.666666-42.666667v-128c0-23.466667-19.2-42.666667-42.666666-42.666667z" fill="#width=" 25px"="" height="25px" "=""></path><path d="M810.666667 810.666667m-213.333334 0a213.333333 213.333333 0 1 0 426.666667 0 213.333333 213.333333 0 1 0-426.666667 0Z" fill="#43A047"></path><path d="M768 682.666667h85.333333v256h-85.333333z" fill="#FFFFFF"></path><path d="M682.666667 768h256v85.333333H682.666667z" fill="#FFFFFF"></path></g></svg>
                                            Registrar Precinto</a>
                                    </li>
                                    <li class="">
                                        <a class="btn btn-CustomOrange ml-1 modifyProposalNumber" href="javascript:;" role="button"
                                           style="background-color: orangered; border-color: orangered">
                                            <svg width="25px" height="25px" fill="#202e4a" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 43.916 43.916" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M34.395,0H9.522c-2.762,0-5,2.239-5,5v33.916c0,2.761,2.238,5,5,5h24.871c2.762,0,5-2.239,5-5V5 C39.395,2.239,37.154,0,34.395,0z M9.265,22.646l1.745-3.396c0.024-0.047,0.055-0.088,0.092-0.125l14.522-14.52 c0.194-0.195,0.513-0.195,0.707,0l1.649,1.65c0.095,0.094,0.146,0.221,0.146,0.354c0,0.133-0.053,0.26-0.146,0.354L13.458,21.484 c-0.037,0.035-0.08,0.066-0.125,0.091L9.938,23.32c-0.193,0.1-0.429,0.063-0.583-0.092C9.202,23.075,9.165,22.841,9.265,22.646z M32.708,39.454h-21.5c-1.104,0-2-0.896-2-2s0.896-2,2-2h21.5c1.104,0,2,0.896,2,2S33.812,39.454,32.708,39.454z M32.708,31.954 h-21.5c-1.104,0-2-0.896-2-2s0.896-2,2-2h21.5c1.104,0,2,0.896,2,2S33.812,31.954,32.708,31.954z M32.708,24.454h-14 c-1.104,0-2-0.896-2-2s0.896-2,2-2h14c1.104,0,2,0.896,2,2S33.812,24.454,32.708,24.454z"></path> </g> </g></svg>
                                            Editar Propuesta</a>
                                    </li>
                                    <li class="">

                                        <a class="btn btn-CustomOrange ml-1" href="{{ url('/eliminarPuntosAnclaje') }}" role="button"
                                            style="background-color: orangered; border-color: orangered">
                                            {{-- <svg width="25px" height="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.001 512.001" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#F4B2B0;" d="M285.792,328.774c0-58.717,47.599-106.316,106.316-106.316c7.124,0,14.08,0.714,20.812,2.05 c2.964-10.219,4.579-21.011,4.579-32.187c0-63.739-51.671-115.41-115.411-115.41c-45.413,0-84.67,26.248-103.507,64.385 c-14.531-13.426-33.95-21.64-55.294-21.64c-45.018,0-81.512,36.494-81.512,81.512c0,44.562,35.763,80.748,80.151,81.477 c-0.456,0.008-0.907,0.034-1.364,0.034c-36.146,0-66.776-23.535-77.454-56.11c-29.277,13.884-49.53,43.7-49.53,78.255l0,0 c0,47.811,38.759,86.57,86.57,86.57H306.21C293.381,373.828,285.792,352.192,285.792,328.774z"></path> <g> <path style="fill:#B3404A;" d="M484.618,252.505c-4.772-5.784-13.33-6.6-19.113-1.83c-5.782,4.774-6.602,13.33-1.83,19.113 c13.653,16.543,21.172,37.491,21.172,58.986c0,51.136-41.603,92.739-92.739,92.739c-46.34,0-84.851-34.165-91.668-78.627 c-0.001-0.011-0.003-0.023-0.004-0.034c-0.21-1.374-0.38-2.762-0.53-4.156c-0.038-0.354-0.071-0.709-0.105-1.063 c-0.105-1.101-0.187-2.208-0.254-3.32c-0.023-0.395-0.052-0.79-0.069-1.185c-0.067-1.443-0.11-2.893-0.11-4.354 c0-51.137,41.603-92.74,92.739-92.74c6.067,0,12.181,0.601,18.17,1.789c6.911,1.371,13.718-2.771,15.68-9.534 c3.396-11.706,5.117-23.807,5.117-35.968c0-71.125-57.863-128.988-128.986-128.988c-43.922,0-83.811,21.765-107.536,57.746 c-15.203-9.756-32.921-15.002-51.266-15.002c-52.432,0-95.089,42.657-95.089,95.089c0,5.803,0.519,11.531,1.531,17.127 C19.265,236.109,0,269.201,0,304.826c0,55.221,44.926,100.147,100.147,100.147H299.61c22.008,26.669,55.302,43.696,92.499,43.696 c66.109,0,119.893-53.783,119.893-119.893C512,300.987,502.276,273.902,484.618,252.505z M282.674,377.819H100.147 c-40.248,0-72.993-32.745-72.993-72.993c0-23.271,11.28-45.059,29.607-58.679c16.329,30.523,48.241,50.111,83.8,50.111 c0.418,0,0.834-0.012,1.248-0.027l0.314-0.009c7.416-0.109,13.372-6.146,13.379-13.562c0.007-7.417-5.938-13.467-13.353-13.589 c-36.831-0.604-66.796-31.065-66.796-67.902c0-37.46,30.476-67.936,67.936-67.936c17.128,0,33.494,6.406,46.08,18.035 c3.143,2.905,7.475,4.16,11.686,3.378c4.21-0.779,7.805-3.499,9.702-7.337c17.31-35.049,52.309-56.822,91.334-56.822 c56.151,0,101.833,45.682,101.833,101.834c0,5.704-0.481,11.394-1.432,17.01c-3.458-0.301-6.926-0.452-10.381-0.452 c-66.109,0-119.893,53.783-119.893,119.894c0,1.047,0.014,2.091,0.041,3.132c0.015,0.603,0.045,1.202,0.069,1.803 c0.018,0.426,0.029,0.854,0.05,1.279c0.042,0.84,0.1,1.679,0.16,2.517c0.012,0.172,0.02,0.346,0.034,0.519 C273.621,351.877,277.035,365.287,282.674,377.819z"></path> <path style="fill:#B3404A;" d="M433.359,342.352h-82.503c-7.498,0-13.577-6.08-13.577-13.577c0-7.497,6.078-13.577,13.577-13.577 h82.503c7.498,0,13.577,6.08,13.577,13.577C446.936,336.272,440.858,342.352,433.359,342.352z"></path> </g> </g></svg>--}}
                                            <svg fill="#ed333b" width="25px" height="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 418.662 418.662" xml:space="preserve" stroke="#ed333b"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M343.291,225.251h-10.668c-2.535,0-4.639,1.854-5.042,4.275h20.752C347.93,227.104,345.826,225.251,343.291,225.251z"></path> <path d="M319.594,276.903c-3.251,0-5.888,2.637-5.888,5.889v51.865c0,3.252,2.636,5.887,5.888,5.887 c3.252,0,5.887-2.635,5.887-5.887v-51.865C325.481,279.54,322.845,276.903,319.594,276.903z"></path> <path d="M382.627,205.251l7.101-47.93c1.073-7.238-1.059-14.584-5.839-20.125c-4.479-5.191-10.868-8.315-17.674-8.686V76.038 c0-25.563-20.797-46.359-46.361-46.359h-75.278c-25.052,0-38.351,10.578-48.062,18.303c-7.807,6.207-12.518,9.955-22.626,9.955 H65.099c-22.78,0-41.313,18.063-41.313,40.264v30.311c-6.806,0.371-13.196,3.494-17.674,8.686 c-4.78,5.541-6.912,12.887-5.839,20.125l30.194,203.803c1.828,12.338,12.417,21.475,24.89,21.475h225.399 c5.591,4.012,12.436,6.385,19.828,6.385h71.491c18.798,0,34.091-15.293,34.091-34.092v-72.406 c7.55-5.285,12.497-14.047,12.497-23.941v-10.092C418.662,226.925,403.093,208.979,382.627,205.251z M54.081,128.472V98.2 c0-6.24,5.602-9.969,11.018-9.969h108.788c20.687,0,32.219-9.172,41.484-16.541c8.552-6.803,14.732-11.717,29.204-11.717h75.278 c8.858,0,16.066,7.205,16.066,16.065v52.434H54.081z M395.29,258.544c0,2.322-1.883,4.205-4.205,4.205h-8.292v92.143 c0,5.021-4.07,9.092-9.091,9.092h-71.491c-5.021,0-9.091-4.07-9.091-9.092v-92.143h-8.292c-2.322,0-4.205-1.883-4.205-4.205 v-10.092c0-10.436,8.489-18.926,18.924-18.926h18.186c0.438-7.834,6.948-14.072,14.889-14.072h10.668 c7.941,0,14.451,6.238,14.889,14.072h18.186c10.435,0,18.924,8.49,18.924,18.926V258.544z"></path> <path d="M356.321,276.903c-3.252,0-5.888,2.637-5.888,5.889v51.865c0,3.252,2.636,5.887,5.888,5.887 c3.251,0,5.887-2.635,5.887-5.887v-51.865C362.208,279.54,359.572,276.903,356.321,276.903z"></path> </g> </g></svg>
                                            Eliminar serie de Precintos</a>
                                    </li>
                                </ul>
                            </center>
                        </div>
                        <table class="table " id="puntosAnclajeTabla" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Número Propuesta</th>
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
                                    <th>Editar</th>
                                    <th>Id</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src='{{ asset('js/app/homePage.js') }}'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://unpkg.com/jquery-mockjax@2.6.0/dist/jquery.mockjax.js"></script>
    <script src='{{ asset('js/jquery.autocomplete.js') }}'></script>

    <script>

        $(document).on('click', '.modifyProposalNumber', function (){
            const { value: formValues } = Swal.fire({
                showCancelButton: true,
                showConfirmButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Cambiar",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                },
                title: "<svg width=\"30px\" height=\"30px\" fill=\"#202e4a\" version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" viewBox=\"0 0 43.916 43.916\" xml:space=\"preserve\"><g id=\"SVGRepo_bgCarrier\" stroke-width=\"0\"></g><g id=\"SVGRepo_tracerCarrier\" stroke-linecap=\"round\" stroke-linejoin=\"round\"></g><g id=\"SVGRepo_iconCarrier\"> <g> <path d=\"M34.395,0H9.522c-2.762,0-5,2.239-5,5v33.916c0,2.761,2.238,5,5,5h24.871c2.762,0,5-2.239,5-5V5 C39.395,2.239,37.154,0,34.395,0z M9.265,22.646l1.745-3.396c0.024-0.047,0.055-0.088,0.092-0.125l14.522-14.52 c0.194-0.195,0.513-0.195,0.707,0l1.649,1.65c0.095,0.094,0.146,0.221,0.146,0.354c0,0.133-0.053,0.26-0.146,0.354L13.458,21.484 c-0.037,0.035-0.08,0.066-0.125,0.091L9.938,23.32c-0.193,0.1-0.429,0.063-0.583-0.092C9.202,23.075,9.165,22.841,9.265,22.646z M32.708,39.454h-21.5c-1.104,0-2-0.896-2-2s0.896-2,2-2h21.5c1.104,0,2,0.896,2,2S33.812,39.454,32.708,39.454z M32.708,31.954 h-21.5c-1.104,0-2-0.896-2-2s0.896-2,2-2h21.5c1.104,0,2,0.896,2,2S33.812,31.954,32.708,31.954z M32.708,24.454h-14 c-1.104,0-2-0.896-2-2s0.896-2,2-2h14c1.104,0,2,0.896,2,2S33.812,24.454,32.708,24.454z\"></path> </g> </g></svg>Edición de Número de propuesta",
                html: `<div id="container-numeroPropuesta1"><input type="text" id="numeroPropuesta1" class="swal2-input" placeholder="Número Actual" value="" required></div>
                       <div><input type="text" id="numeroPropuesta2" class="swal2-input" placeholder="Número Nuevo" value="" required></div>
                       <br/><br/>`,
                focusConfirm: false,
                showLoaderOnConfirm: true,
                preConfirm:  async () => {
                    let numeroPropuesta1 = document.getElementById("numeroPropuesta1").value;
                    let numeroPropuesta2 = document.getElementById("numeroPropuesta2").value;
                    if(numeroPropuesta1.length==0 && numeroPropuesta2.length==0){
                        Swal.showValidationMessage("¡Llene todos los campos antes de continuar!");
                        return null;
                    }
                    if(numeroPropuesta1.length==0){
                        Swal.showValidationMessage("¡El campo Número Actual es requerido!");
                        return null;
                    }
                    if(numeroPropuesta2.length==0){
                        Swal.showValidationMessage("¡El campo Nuevo Número es requerido!");
                        return null;
                    }

                    if(numeroPropuesta1==numeroPropuesta2){
                        Swal.showValidationMessage("Para continuar los campos no deben coincidir!");
                        return null;
                    }else{
                        try {
                                const updateUrl = "{{route('ActualizarPropuesta')}}";
                                const response = await fetch(updateUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        '_token': "{{ csrf_token() }}",
                                        'propuesta_instalacion_anterior': numeroPropuesta1,
                                        'propuesta_instalacion_nuevo':numeroPropuesta2
                                    })
                                });
                                if (!response.ok) {
                                    return Swal.showValidationMessage(`${JSON.stringify(await response.json())} `);
                                }
                                var responseData =  await response.json();
                                console.log(responseData);
                                if(responseData.statusCode==200 && responseData.success==true){
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: responseData.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    setTimeout(function () {
                                        location.href="{{route('home')}}";
                                    }, 1500);

                                }else {
                                        Swal.showValidationMessage(responseData.message);
                                        /*if(responseData.errors['user_id'])
                                            Swal.showValidationMessage(responseData.errors['user_id']);
                                        else if(responseData.errors['password'])
                                            Swal.showValidationMessage(responseData.errors['password'][0]);
                                        else if(responseData.errors['confirmPassword'])
                                            Swal.showValidationMessage(responseData.errors['confirmPassword'][0]);*/
                                }
                        } catch (error) {
                            Swal.showValidationMessage(`¡Ha ocurrido un error: ${error}. Intente otra vez!`);
                        }
                        allowOutsideClick: () => !Swal.isLoading();
                    }

                }
            });

            var data={
                'query': function() {
                    return $('#numeroPropuesta1').val();
                },
                '_token': function() {
                    return "{{ csrf_token() }}";
                }
            };

            // Initialize ajax autocomplete:
            /*$('#numeroPropuestaTMP').autocomplete({*/
            $('#numeroPropuesta1').autocomplete({
                serviceUrl: '/ajax/numeros_propuesta/',
                ajaxSettings: {
                    dataType: "json",
                    method: "POST",
                    data: data
                },
                /*minChars: 3,*/
                appendTo: '#container-numeroPropuesta1',
                /*lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                    var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                    return re.test(suggestion.value);
                },
                onSelect: function(suggestion) {
                    $('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
                },
                onHint: function (hint) {
                    $('#autocomplete-ajax-x').val(hint);
                },
                onInvalidateSelection: function() {
                    $('#selction-ajax').html('You selected: none');
                }*/
            });
        });
    </script>
@endsection



