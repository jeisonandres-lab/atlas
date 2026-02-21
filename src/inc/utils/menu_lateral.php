<!-- navbar -->
<nav class="navbar app-header navbar " style=" box-shadow: none !important;" id="narvarPrincipal">
    <div class="navbar_content me-3 ms-2">
        <li class="nav-item ms-3" style="list-style: none; ">
            <a class="" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
            </a>
        </li>
        <li class="nav-item d-flex align-items-center">
            <span class="<?php echo $classActivo ?> me-2"></span>
            <span><?php echo $act ?> </span>
        </li>
    </div>
    <div id="contenedor-buscar" class="search_bar">
        <input type="text" id="buscador" placeholder="Buscar" />

        <div id="resultadosBusqueda"></div>
    </div>
    <div class="navbar_content me-3">
        <li class="nav-item">
            <a href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen" style="display: block;"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
            </a>
        </li>
        <i class='bx bx-sun' id="darkLight"></i>

        <!-- NOTIFICACIONES -->
        <li class="nav-item dropdown dropdown-sin-triangulo " id="contenNoti">
            <a class="dropdown-toggle " href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-bell'></i>
                <span class="badge badge-warning contarNoti bg-success" id="contadorNoti"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-xxlg dropdown-menu-right" style="left: inherit; right: 0px; min-width: 400px;" id="subContentNofi">
                <div class="container-fluid " id="conten-notificaciones">
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
            </div>
        </li>

        <!-- foto de perfil -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <!-- <img src="./src/global/photos/<?php echo $_SESSION['cedula']; ?>.png" alt="" class="profile nav-item dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" /> -->
                <img src="./src/assets/img/icons/avtar_1.png" alt="" class="profile nav-item dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" />
                <span class="ms-2 d-none d-md-inline"><?php echo $datosUser ?></span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" id="cerrarSession">Cerrar Sesion</a></li>
            </ul>
        </li>
    </div>
</nav>

<!-- sidebar -->
<div class="sidebar app-sidebar " style="
    /* min-width: 70px !important; */">
    <div class="menu-btn">
        <i class="ph-bold ph-caret-left"></i>
    </div>
    <div class="head">
        <div class="user-img">
            <img src="./src/assets/img/icons/logo_atlas.svg" alt="">
        </div>

        <div class="user-details">
            <p class="title mb-0 fs-6 ">SISTEMA</p>
            <p class="name atlas fs-5">ATLAS</p>

        </div>
    </div>
    <!-- Contenido del sidebar -->
    <div class="menu_container">
        <div class="nav">
            <!-- Submenu de navegacion del sidebar -->
            <div class="menu">
                <!-- Inicio -->
                <p class="title">Principal</p>
                <ul>
                    <li class="active">
                        <a href="inicio">
                            <i class="icon fa-regular fa-house"></i>
                            <span class="text">Inicio</span>
                        </a>
                    </li>
                </ul>
                <p class="title">Paginas</p>
                <ul>

                    <li>
                        <a href="#">
                            <i class="icon fa-regular fa-user-tie"></i>
                            <span class="text">Empleado</span>
                            <i class="arrow ph-bold ph-caret-down"></i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="registrarEmpleado">
                                    <span class="text">Registrar Empleados</span>
                                </a>
                            </li>
                            <li>
                                <a href="registrarFamiliar">
                                    <span class="text">Registrar Familiar</span>
                                </a>
                            </li>

                            <li>
                                <a href="registrosEmpleados">
                                    <span class="text">Empleados Registros </span>
                                </a>
                            </li>

                            <li>
                                <a href="registrosFamiliares">
                                    <span class="text">Familiares Registros</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- Datos Instalaciones -->
                    <li>
                        <a href="#">
                            <i class="icon fa-regular fa-house"></i>
                            <span class="text">Datos Instalaciones</span>
                        </a>
                    </li>
                    <!-- Vacaciones -->
                    <li>
                        <a href="#">
                            <i class="icon fa-light fa-island-tropical"></i>
                            <span class="text">Vacaciones</span>
                            <i class="arrow ph-bold ph-caret-down"></i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="#">
                                    <span class="text">Asignar Vacaciones</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="text">Asignar Ausento</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Bienestar Social -->
                    <li>
                        <a href="#">
                            <i class="icon fa-regular fa-handshake"></i>
                            <span class="text">Bienestar Social</span>
                            <i class="arrow ph-bold ph-caret-down"></i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="#">
                                    <span class="text">Ficha Tecnica</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="text">Renuncia</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Usuarios  -->
                    <li>
                        <a href="#">
                            <i class="icon fa-regular fa-user-gear"></i>
                            <span class="text">Usuarios</span>
                            <i class="arrow ph-bold ph-caret-down"></i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="#">
                                    <span class="text">Registros Usuario</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="text">Historial</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- <div class="menu">
            <p class="title">Settings</p>
            <ul>
                <li class="">
                    <a href="#">
                        <i class="icon ph-bold ph-house house-simple"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
            </ul>
        </div> -->
        </div>
        <!-- Parte inferiror del sidebar -->
        <div class="menu menu_inferior">
            <p class="title">Configuraciones</p>
            <ul>
                <li class="">
                    <a href="#">
                        <i class="icon ph-bold ph-house house-simple"></i>
                        <span class="text">Cerrar sesion</span>
                    </a>
                </li>
            </ul>

            <div class="head">
                <div class="user-img img-user">
                    <img src="./src/global/photos/<?php echo $_SESSION['cedula']; ?>.png" alt="">
                </div>

                <div class="user-details">
                    <p class="title title_user mb-0 fs-6 "><?php echo $_SESSION['usuario']; ?></p>
                    <p class="name name_rol atlas fs-6 fw-semibold"><?php echo $_SESSION['rol']; ?></p>
                </div>
            </div>
        </div>
    </div>


    </div>
    <!-- </div> -->
    <!-- </nav> -->