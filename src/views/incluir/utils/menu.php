<!-- navbar -->
<nav class="navbar app-header navbar " style=" box-shadow: none !important;" id="narvarPrincipal">
    <div class="navbar_content me-3 ms-2">
        <li class="nav-item d-flex align-items-center ps-5 activo-user" id="userActivo">
            <div class="d-flex align-items-center py-1 px-2 rounded status-active badge bg-success-subtle text-success">
                <i class='bx bx-user-check me-2'></i>
                <span><?php echo $_SESSION['act'] ?> </span>
            </div>
        </li>
    </div>
    <div id="contenedor-buscar" class="search_bar">
        <input type="text" id="buscador" placeholder="Buscar" />
        <div id="resultadosBusqueda"></div>
    </div>
    <div class="navbar_content list-icons me-3">
        <li class="nav-item">
            <a href="#" data-lte-toggle="fullscreen" class="conten-icons">
                <i class='bx bx-fullscreen' data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <!-- <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen" style="display: block;"></i> -->
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
            </a>
        </li>
        <!-- <i class='bx bx-sun' id="darkLight"></i> -->

        <!-- NOTIFICACIONES -->
        <li class="nav-item dropdown dropdown-sin-triangulo " id="contenNoti">
            <a class="dropdown-toggle conten-icons" href="#" data-bs-toggle="dropdown" aria-expanded="false">
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
        <li class="nav-item user-img dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img loading="lazy" src="./src/assets/img/icons/avtar_1.webp" alt="" class="profile nav-item dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" />
                <!-- <span class="ms-2 d-none d-md-inline"><?php echo $_SESSION['usuario'] ?></span> -->
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" id="cerrarSession">Cerrar Sesion</a></li>
            </ul>
        </li>
    </div>
</nav>


<!-- Botón del menú hamburguesa-->
<div class="menu-btn sidebar-btn" id="sidebar-btn">
    <i class='bx bx-menu'></i>
    <i class='bx bx-x'></i>

</div>

<div class="dark-mode-btn" id="dark-mode-btn">
    <i class='bx bx-moon'></i>
    <i class='bx bx-sun'></i>
</div>
<!-- Sidebar del menú -->
<div class="custom-sidebar app-sidebar minimize" id="sidebar">
    <!-- Header del menú -->
    <div class="header">
        <!-- Botón del menú -->
        <div class="menu-btn" id="menu-btn">
            <i class='bx bx-chevron-left'></i>
        </div>
        <!-- Logo de la marca -->
        <div class="brand">
            <img class="brand-light" src="./src/assets/img/icons/favicon.webp" alt="logo">
            <img class="brand-dark" src="./src/assets/img/icons/favicon.webp" alt="logo">
            <!-- Nombre de la marca -->
            <span class="name-logo">ATLAS</span>
        </div>
    </div>

    <div class="menu-container">
        <!-- Barra de búsqueda -->
        <div class="search">
            <i class='bx bx-search'></i>
            <input type="search">
        </div>
        <!-- Menú del navegador -->
        <ul class="menu">
            <!-- Inicio -->
            <li class="menu-item menu-item-static active">
                <a href="inicio" class="menu-link">
                    <i class='menu-link-icon bx bx-home-alt-2'></i>
                    <!-- Nombre del menú -->
                    <span>Inicio</span>
                </a>
            </li>
            <!-- Empleados -->
            <li class="menu-item menu-item-dropdown">
                <a href="#" class="menu-link">
                    <i class="menu-link-icon fa-regular fa-user-tie"></i>
                    <!-- Nombre del menú -->
                    <span>Empleado</span>
                    <i class='bx bx-chevron-down'></i>
                </a>
                <!-- Sub menu -->
                <ul class="sub-menu">
                    <li><a href="RegistrarEmpleado" class="sub-menu-link">Registrar Empleado</a></li>
                    <li><a href="Empleados" class="sub-menu-link">Empleados</a></li>
                </ul>
            </li>
            <!-- Familiares -->
            <li class="menu-item menu-item-dropdown">
                <a href="#" class="menu-link">
                    <i class="menu-link-icon fa-regular fa-family"></i>
                    <!-- Nombre del menú -->
                    <span>Familiares</span>
                    <i class='bx bx-chevron-down'></i>
                </a>
                <!-- Sub menu -->
                <ul class="sub-menu">
                    <li><a href="RegistrarFamiliares" class="sub-menu-link">Registrar Familiar</a></li>
                    <li><a href="Familiares" class="sub-menu-link">Familiares</a></li>
                </ul>
            </li>

            <li class="menu-item menu-item-dropdown">
                <a href="#" class="menu-link">
                    <i class="menu-link-icon fa-regular fa-handshake-angle"></i>
                    <!-- Nombre del menú -->
                    <span>Bienestar Social</span>
                    <i class='bx bx-chevron-down'></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="ficha" class="sub-menu-link">Ficha Técnica</a></li>
                    <li><a href="datosPersonal" class="sub-menu-link">Renuncia</a></li>
                </ul>
            </li>

            <li class="menu-item menu-item-dropdown">
                <a href="#" class="menu-link">
                    <i class="menu-link-icon fa-regular fa-umbrella-simple"></i>
                    <!-- Nombre del menú -->
                    <span>Vacaciones</span>
                    <i class='bx bx-chevron-down'></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="ausencia" class="sub-menu-link">Asignar Ausento</a></li>
                    <li><a href="vacaciones" class="sub-menu-link">Asignar Vacaciones</a></li>
                </ul>
            </li>
            <!-- Administrador -->
            <li class="menu-item menu-item-dropdown">
                <a href="#" class="menu-link">
                    <i class="menu-link-icon  fa-regular fa-cube"></i>
                    <!-- Nombre del menú -->
                    <span>Administrador</span>
                    <i class='bx bx-chevron-down'></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="HistorialUsuarios" class="sub-menu-link">Historial De Usuario</a></li>
                    <li><a href="RegistrosUsuarios" class="sub-menu-link">Usuarios</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Footer del menú -->
    <div class="footer">
        <ul class="menu">
            <!-- Notificaciones -->
            <li class="menu-item menu-item-static">
                <a href="#" class="menu-link">
                    <i class='bx bx-bell'></i>
                    <!-- Nombre del menú -->
                    <span>Notificaciones</span>
                </a>
            </li>

            <li class="menu-item menu-item-static">
                <a href="#" class="menu-link">
                    <i class='bx bx-cog'></i>
                    <!-- Nombre del menú -->
                    <span>Configuraciones</span>
                </a>
            </li>
        </ul>

        <div class="user-menu d-flex mt-3">
            <div class="user-img">
                <img src="./src/assets/img/icons/avtar_1.webp" alt="user">
            </div>
            <div class="user-data">
                <!-- <?php $_SESSION['usuario'] ?> -->
                <span class="user-name"><?php echo $_SESSION['usuario'] ?></span>
                <span class="user-role"><?php echo $_SESSION['rol'] ?></span>
            </div>

            <div class="user-icon">
                <i class='bx bx-exit'></i>
            </div>

        </div>
    </div>
</div>