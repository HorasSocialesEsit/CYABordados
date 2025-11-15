<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('cyabordados.png') }}" type="image/x-icon">

    <!-- Bootstrap 4.6 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('css/admin/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <style>
        :root {
            --verde-principal: #195231;
            --negro: #000000;
            --blanco: #ffffff;
            --verde-claro: #28a745;
            --gris-texto: #f4f4f4;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: linear-gradient(180deg, var(--negro) 0%, var(--verde-principal) 100%);
        }

        .sidebar .nav-item .nav-link {
            color: var(--blanco);
            transition: all 0.2s ease;
        }

        .sidebar .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #aef3c1;
        }

        .sidebar .nav-item.active .nav-link {
            background-color: var(--verde-claro);
            color: var(--negro);
            font-weight: bold;
        }

        .sidebar-brand {
            background-color: var(--blanco);
            color: var(--verde-principal) !important;
            font-weight: bold;
        }

        .sidebar-brand-icon i {
            color: var(--verde-principal);
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background-color: var(--verde-principal) !important;
        }

        .topbar .nav-link,
        .topbar .navbar-brand {
            color: var(--blanco) !important;
        }

        .topbar .nav-link:hover {
            color: #aef3c1 !important;
        }

        .dropdown-menu a:hover {
            background-color: var(--verde-principal);
            color: var(--blanco);
        }

        /* ===== BOTONES ===== */
        .btn-primary {
            background-color: var(--verde-principal);
            border: none;
        }

        .btn-primary:hover {
            background-color: #14722a;
        }

        /* ===== FOOTER ===== */
        footer.sticky-footer {
            background-color: var(--negro);
            color: var(--gris-texto);
        }

        /* ===== TABLAS ===== */
        .table thead {
            background-color: var(--verde-principal);
            color: var(--blanco);
        }

        /* Print etiqueta */
        @media print {
            body * {
                visibility: hidden;
            }

            #etiquetaModal,
            #etiquetaModal * {
                visibility: visible;
            }

            #etiquetaModal {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            #etiquetaModal .modal-footer {
                display: none;
            }

            #etiquetaModal .modal-content {
                width: 10cm;
                height: 10cm;
            }
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('index.dashboardGeneral') }}">
                <div class="sidebar-brand-icon rotate-n-15">

                    <img src="{{ asset('cyabordados.png') }}" style="width: 100%" alt="">
                </div>
                <div class="sidebar-brand-text mx-3">CYABordados</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('index.dashboardGeneral') }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading text-light">Panel Operativo</div>

            @auth
                @if (auth()->user()->hasRole(['admin']))
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecepcion"
                            aria-expanded="false" aria-controls="collapseRecepcion">
                            <i class="fa-solid fa-bell-concierge text-success"></i>
                            <span>Ventas</span>
                        </a>
                        <div id="collapseRecepcion" class="collapse" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Recepción de Órdenes:</h6>
                                <a class="collapse-item" href="{{ route('ordenes.create') }}">Crear Orden</a>
                                <a class="collapse-item" href="{{ route('ordenes.index') }}">Ver Órdenes</a>
                            </div>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['admin', 'supervisor']))
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBodega"
                            aria-expanded="false" aria-controls="collapseBodega">
                            <i class="fa-solid fa-book-open-reader text-success"></i>
                            <span>Producción</span>
                        </a>
                        <div id="collapseBodega" class="collapse" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Producción:</h6>
                                <a class="collapse-item" href="{{ route('produccion.arte.index') }}">Ordenes Nuevas</a>
                                <a class="collapse-item" href="#">Asignar Orden</a>
                                <a class="collapse-item" href="#">Tiempos Estimados</a>
                                <a class="collapse-item" href="{{ route('ordenProceso.index') }}">Orden en Proceso</a>
                            </div>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['admin', 'supervisor']))
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRuteo"
                            aria-expanded="false" aria-controls="collapseRuteo">
                            <i class="fa-solid fa-clipboard text-success"></i>
                            <span>Inventario</span>
                        </a>
                        <div id="collapseRuteo" class="collapse" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Inventario de Hilo:</h6>
                                <a class="collapse-item" href="{{ route('inventario.index') }}">Ver Material</a>
                            </div>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['admin', 'supervisor']))
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapseconfiguraciones" aria-expanded="false"
                            aria-controls="collapseconfiguraciones">
                            <i class="fa-solid fa-gear text-warning"></i>
                            <span>Configuraciones</span>
                        </a>
                        <div id="collapseconfiguraciones" class="collapse" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Configuraciones:</h6>
                                <a class="collapse-item" href="{{ route('clientes.index') }}">Clientes</a>
                                <a class="collapse-item" href="#">Materias</a>
                                <a class="collapse-item" href="#">Medidas</a>
                                <a class="collapse-item" href="#">Código de Hilos</a>
                            </div>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['admin']))
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapseAdministracion" aria-expanded="false"
                            aria-controls="collapseAdministracion">
                            <i class="fa-solid fa-user-gear text-danger"></i>
                            <span>Administración</span>
                        </a>
                        <div id="collapseAdministracion" class="collapse" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Administración:</h6>
                                <a class="collapse-item" href="{{ route('usuarios.index') }}">Usuarios</a>
                            </div>
                        </div>
                    </li>
                @endif
            @endauth

            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-white">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        @auth
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline small">
                                        {{ optional(Auth::user())->name }}
                                    </span>

                                    @if (!empty(optional(Auth::user())->foto))
                                        <img class="img-profile rounded-circle" width="35" height="35"
                                            src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Empleado">
                                    @else
                                        <i class="fa-solid fa-user-circle fa-2x text-white"></i>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('perfil') }}">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Perfil
                                    </a>

                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Configuración
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <form class="bg-danger" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">@yield('PasosProcesos')</h1>
                    @yield('contenido')
                </div>
            </div>

            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto">
                        <span>Copyright &copy; CYABordados 2025</span><br>
                        <small>Todos los derechos reservados</small>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js/admin/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts')
</body>

</html>
