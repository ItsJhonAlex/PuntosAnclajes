<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistemas de Ingenieria</title>
    <link rel="icon" href="https://www.isiseguridadindustrial.com/wp-content/uploads/2022/08/cropped-favicon-32x32.jpg" sizes="32x32">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Styles -->
    <link href="{{ asset('css/anclajes.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custompaginate.css') }}">

</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar-->
        @if (Auth::check())
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light" style="display:flex;justify-content: space-around;">
                    <img src="https://www.isiseguridadindustrial.com/wp-content/uploads/elementor/thumbs/Arte-LOGO-sin-fondo-ptk6xelhcamh2whobcc1e5k0bgdk3l3xwv5q780pgo.png"
                        alt="logo" style="width: 5rem; height: 50%;">
                </div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3"
                        href="{{ url('/home') }}">Listado Instalaciones</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3"
                        href="{{ url('/lista/recertificacion') }}">Listado Recertificaciones</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3"
                        href="{{ url('/registrarPuntoAnclaje') }}">Registro de instalacion</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3"
                        href="{{ url('/systemProject') }}">Registro de Recertificaciones</a>
                    <a href="#listCollapseOne" class="list-group-item list-group-item-action list-group-item-light p-3"
                        data-bs-toggle="collapse"> Configuraciones Maestras <i class="bi bi-caret-down-fill"></i></a>
                    <div class="collapse" id="listCollapseOne">
                        <a href="{{ url('/company') }}" class="list-group-item list-group-item-action">Empresas</a>
                        <a href="{{ url('/worker') }}" class="list-group-item list-group-item-action">Instalador</a>
                        <a href="{{ url('/protectionSystem') }}" class="list-group-item list-group-item-action">Sistema
                            de protección</a>
                        <a href="{{ url('/systemUse') }}" class="list-group-item list-group-item-action">Uso</a>

                    </div>
                </div>
            </div>
        @endif
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom" style="padding: 0.6rem 1.25rem">
                <div class="container-fluid">
                    @if (Auth::check())
                        <button class="btn btn-primary" id="sidebarToggle"
                            style="background-color: orangered; border-color: orangered">
                            <i id="sidebarToggleIcon" class="bi bi-list"></i></span></button>
                    @endif
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">

                            @if (Auth::check())
                                <div class="" style="display: flex; justify-content: center;">
                                    <Button class="btn btn-primary"
                                        style="background-color: orangered; border-color: orangered">
                                        <a class="" style="text-decoration: none; color: white; font-weight: 500"
                                            href="{{ route('logout') }} "
                                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            {{ __('Cerrar Sesion') }}
                                        </a>
                                    </Button>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            @else
                                <li class="nav-item active">
                                    <Button class="btn btn-primary"
                                        style="background-color: orangered; border-color: orangered"><a class="nav-link"
                                            href="{{ route('login') }}" style="color:white">{{ __('Iniciar sesión') }}
                                        </a>
                                    </Button>
                                </li>
                            @endif
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#!">Something else here</a>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="mt-5">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.js" crossorigin="anonymous"></script>


    <script>
        window.addEventListener('DOMContentLoaded', event => {

            // Toggle the side navigation
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains(
                        'sb-sidenav-toggled'));

                    if (document.body.classList.contains('sb-sidenav-toggled')) {
                        sidebarToggleIcon.classList.remove('bi-list'); // Quita el icono de barras
                        sidebarToggleIcon.classList.add('bi-x-square'); // Agrega el icono de "x"
                    } else {
                        sidebarToggleIcon.classList.remove('bi-x-square'); // Quita el icono de "x"
                        sidebarToggleIcon.classList.add('bi-list'); // Agrega el icono de barras
                    }
                });


            }

        });
    </script>

    @yield('scripts')

    </div>
</body>

</html>
