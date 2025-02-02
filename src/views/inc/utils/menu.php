<!-- navbar -->
<nav class="navbar app-header navbar ">
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
    <div class="search_bar">
        <input type="text" placeholder="Search" />
    </div>
    <div class="navbar_content me-3">
        <li class="nav-item">
            <a href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen" style="display: block;"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
            </a>
        </li>
        <i class='bx bx-sun' id="darkLight"></i>
        <i class='bx bx-bell'></i>
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

    <div class="menu_content">
        <!--INICIO -->
        <ul class="menu_items">
            <div class="menu_title menu_inicio"></div>
            <!-- start -->
            <li class="item">
                <a href="inicio" class="nav_link inicio">
                    <span class="navlink_icon">
                        <i class="bx bx-home-alt"></i>
                    </span>
                    <span class="navlink">Inicio</span>
                </a>
            </li>
        </ul>
        <!-- PERSONAL -->
        <ul class="menu_items">
            <div class="menu_title menu_personal"></div>
            <!-- Start -->
            <li class="item">
                <a href="personal" class="nav_link personal familiares">
                    <span class="navlink_icon">
                        <i class='bx bx-notepad'></i>
                    </span>
                    <span class="navlink">Registros</span>
                </a>
            </li>
            <!-- End -->

            <li class="item">
                <a href="registrosFamiliares" class="nav_link registrosFamiliares">
                    <span class="navlink_icon">
                        <i class='bx bx-id-card'></i>
                    </span>
                    <span class="navlink">Datos Personal</span>
                </a>
            </li>
        </ul>
        <!-- VACACIONES -->
        <ul class="menu_items">
            <div class="menu_title menu_vacaciones"></div>
            <!-- Start -->
            <li class="item">
                <a href="ausencia" class="nav_link ausencia">
                    <span class="navlink_icon">
                        <i class='bx bx-notepad'></i>
                    </span>
                    <span class="navlink">Asignar ausento</span>
                </a>
            </li>
            <!-- End -->

            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bx-hotel'></i>
                    </span>
                    <span class="navlink">Reposos</span>
                </a>
            </li>
        </ul>
        <!-- LEGALIZACIONES -->
        <ul class="menu_items">
            <div class="menu_title menu_legalizaciones"></div>
            <li class="item">
                <div href="#" class="nav_link submenu_item">
                    <span class="navlink_icon">
                        <i class='bx bx-book-content'></i>
                    </span>
                    <span class="navlink">Asesorias</span>
                    <i class="bx bx-chevron-right arrow-left"></i>
                </div>
                <ul class="menu_items submenu">
                    <a href="#" class="nav_link sublink">Personal</a>
                    <a href="#" class="nav_link sublink">Jubilados</a>
                    <a href="#" class="nav_link sublink">Renuncia</a>
                </ul>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bx-clipboard'></i>
                    </span>
                    <span class="navlink">Reporte Legal</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-layer"></i>
                    </span>
                    <span class="navlink">Generar Asesoria</span>
                </a>
            </li>
        </ul>

        <!-- Medicina -->
        <ul class="menu_items">
            <div class="menu_title menu_medicina"></div>
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bx-briefcase-alt-2'></i>
                    </span>
                    <span class="navlink">Medicamentos</span>
                </a>
            </li>
            <li class="item">
                <div href="#" class="nav_link submenu_item">
                    <span class="navlink_icon">
                        <i class="bx bx-home-alt"></i>
                    </span>
                    <span class="navlink">Consulta</span>
                    <i class="bx bx-chevron-right arrow-left"></i>
                </div>
                <ul class="menu_items submenu">
                    <a href="#" class="nav_link sublink">Generar</a>
                    <a href="#" class="nav_link sublink">Personal</a>
                </ul>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bx-cabinet'></i>
                    </span>
                    <span class="navlink">Historial</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bx-file'></i>
                    </span>
                    <span class="navlink">Informe Medico</span>
                </a>
            </li>
        </ul>

        <!-- Administracion -->
        <ul class="menu_items">
            <div class="menu_title menu_administrador"></div>

            <li class="item">
                <a href="users" class="nav_link usuarios">
                    <span class="navlink_icon">
                        <i class="fa-regular fa-user-tie"></i>
                    </span>
                    <span class="navlink">Usuarios</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bx-cabinet'></i>
                    </span>
                    <span class="navlink">Historial</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bx-file'></i>
                    </span>
                    <span class="navlink">Informe</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- crear sub menus y icono para abrir el sub menu-->
<!--
      <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="bx bx-home-alt"></i>
                        </span>
                        <span class="navlink">Home</span>
                        <i class="bx bx-chevron-right arrow-left"></i>
                    </div>

                    <ul class="menu_items submenu">
                        <a href="#" class="nav_link sublink">Nav Sub Link</a>
                        <a href="#" class="nav_link sublink">Nav Sub Link</a>
                        <a href="#" class="nav_link sublink">Nav Sub Link</a>
                        <a href="#" class="nav_link sublink">Nav Sub Link</a>
                    </ul>
                </li>
    -->
<!-- JavaScript -->