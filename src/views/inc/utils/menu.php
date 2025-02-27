<!-- navbar -->
<nav class="navbar app-header navbar " style=" box-shadow: none !important;">
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
        <input type="text" id="buscador" placeholder="Search" />

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
<nav class="sidebar app-sidebar ">
    <div class="logo_item sidebar-brand">
        <a href="./inicio" class="brand-link">
            <img src="./src/assets/img/icons/dasdad-transformed-removebg.png" alt="" class="brand-image ">
            <span class="ms-3 fw-bold">ATLAS</span>
        </a>
    </div>
    <div class="conten-subMenu" style="padding: 9px 20px 0px 20px;">
        <div class="menu_content">
            <!--INICIO -->
            <ul class="menu_items">
                <div class="menu_title menu_inicio"></div>
                <!-- start -->
                <li class="item">
                    <a href="inicio" class="nav_link inicio">
                        <span class="navlink_icon">
                            <i class="icons_menu fa-regular fa-house me-2"></i>
                        </span>
                        <span class="navlink">Inicio</span>
                    </a>
                </li>
            </ul>
            <!-- PERSONAL -->
            <ul class="menu_items">
                <!-- <div class="menu_title"></div>  -->
                <li class="item">
                    <div href="#" class="nav_link submenu_item personal familiares">
                        <span class="navlink_icon">
                            <i class="icons_menu fa-regular fa-user-group me-2"></i>
                        </span>
                        <span class="navlink ">Empleado</span>
                        <i class="bx bx-chevron-right arrow-left"></i>
                    </div>
                    <ul class="menu_items submenu">
                        <a href="personal" class="nav_link sublink">Registrar Empleado</a>
                        <a href="registrosFamiliares" class="nav_link sublink  registrosFamiliares">Familiares</a>
                    </ul>
                </li>
            </ul>

            <!-- BIENESTAR SOCIAL -->
            <ul class="menu_items">
                <!-- <div class="menu_title"></div> -->
                <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="icons_menu fa-regular fa-handshake me-2"></i>
                        </span>
                        <span class="navlink">Bienestar Social</span>
                        <i class="bx bx-chevron-right arrow-left"></i>
                    </div>
                    <ul class="menu_items submenu">
                        <a href="ficha" class="nav_link sublink">Ficha Técnica</a>
                        <a href="#" class="nav_link sublink">Renuncia</a>
                    </ul>
                </li>
            </ul>

            <!-- VACACIONES -->
            <ul class="menu_items">
                <!-- <div class="menu_title"></div> -->
                <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="icons_menu fa-regular fa-plane me-2"></i>
                        </span>
                        <span class="navlink">Vacaciones</span>
                        <i class="bx bx-chevron-right arrow-left"></i>
                    </div>
                    <ul class="menu_items submenu">
                        <a href="ausencia" class="nav_link sublink ausencia">Asignar ausento</a>
                        <a href="vacaciones" class="nav_link sublink vacaciones">Vacaciones</a>
                    </ul>
                </li>
            </ul>
            <!-- LEGALIZACIONES
            <ul class="menu_items">
                <div class="menu_title"></div>
                <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="icons_menu fa-regular fa-gavel me-2"></i>
                        </span>
                        <span class="navlink">Asesorias</span>
                        <i class="bx bx-chevron-right arrow-left"></i>
                    </div>
                    <ul class="menu_items submenu">
                        <a href="#" class="nav_link sublink">Jubilados</a>
                        <a href="#" class="nav_link sublink">Renuncia</a>
                        <a href="#" class="nav_link sublink">Reporte Legal</a>
                        <a href="#" class="nav_link sublink">Generar Asesoria</a>
                    </ul>
                </li>
            </ul>-->

            <!-- MEDICINA
            <ul class="menu_items">
                 <div class="menu_title"></div>
                <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="icons_menu fa-regular fa-stethoscope me-2"></i>
                        </span>
                        <span class="navlink">Medicina</span>
                        <i class="bx bx-chevron-right arrow-left"></i>
                    </div>
                    <ul class="menu_items submenu">
                        <a href="#" class="nav_link sublink">Medicamentos</a>
                        <a href="#" class="nav_link sublink">Consulta</a>
                        <a href="#" class="nav_link sublink">Historial Medico</a>
                        <a href="#" class="nav_link sublink">Reporte Legal</a>
                        <a href="#" class="nav_link sublink">Consulta Generar</a>
                        <a href="#" class="nav_link sublink">Consulta Personal</a>
                    </ul>
                </li>
            </ul> -->

            <!-- ADMINISTRADOR -->
            <ul class="menu_items">
                <!-- <div class="menu_title"></div> -->
                <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="icons_menu fa-regular fa-user-gear me-2"></i>
                        </span>
                        <span class="navlink">Administración</span>
                        <i class="bx bx-chevron-right arrow-left"></i>
                    </div>
                    <ul class="menu_items submenu">
                        <a href="usuarios" class="nav_link sublink Usuarios">Usuarios</a>
                        <a href="historial" class="nav_link sublink HistorialUsuario">Historial</a>
                        <!-- <a href="#" class="nav_link sublink InformeUsuario">Informe</a> -->
                    </ul>
                </li>
            </ul>
        </div>

    </div>
    <!-- <div class="content-version-black me-3 ms-3 mt-5 ">
        <div class="card text-center">
            <div class="card-body">
            <i class="fa-light fs-4 fa-code-compare mt-3 text-black"></i>
                <h6 class="mt-4 text-dark fw-bolder text-black" style="font-size: 14px;">Version 1.0 ATLAS</h6>
                <p class="mt-1 text-dark  p-2 text-black" style="font-size: 12px;">Sistema Gestor de Recursos Humanos</p>
            </div>
        </div>
    </div> -->
</nav>