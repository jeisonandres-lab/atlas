<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../../assets/css/menu.css" />
    <!-- ICONOS DEL SISTEMA -->
    <?php require_once "./icons.php";?>
   
</head>

<body>
    <!-- navbar -->
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>

            <img src="../../assets/img/icons/dasdad-transformed-removebg.png" alt=""></i>Atlas
        </div>

        <div class="search_bar">
            <input type="text" placeholder="Search" />
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class='bx bx-sun' id="darkLight"></i>
            <i class='bx bx-bell'></i>
            <!-- foto de perfil -->
            <img src="../../assets/img/icons/avtar_1.png" alt="" class="profile" />
        </div>
    </nav>

    <!-- sidebar -->
    <nav class="sidebar">
        <div class="menu_content">
            <!--INICIO -->
            <ul class="menu_items">
                <div class="menu_title menu_inicio"></div>
                <!-- start -->
                <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="bx bx-home-alt"></i>
                        </span>
                        <span class="navlink">Inicio</span>
                    </div>
                </li>
                <!-- end -->

                <!-- start -->
                <!-- <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-chat'></i>
                        </span>
                        <span class="navlink">Mensajes</span>

                    </div>
                </li> -->

                <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-paper-plane'></i>
                        </span>
                        <span class="navlink">Solicitudes</span>

                    </div>
                </li>

                <!-- end -->
            </ul>
            <!-- VACACIONES -->
            <ul class="menu_items">
                <div class="menu_title menu_vacaciones"></div>
                <!-- Start -->
                <li class="item">
                    <a href="#" class="nav_link">
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

            <!-- Sidebar Open / Close -->
            <div class="bottom_content">
                <div class="bottom expand_sidebar">
                    <span> Expandir</span>
                    <ion-icon name="heart"></ion-icon>
                    <i class='bx bx-log-in'></i>
                </div>
                <div class="bottom collapse_sidebar">
                    <span>Encoger</span>
                    <i class='bx bx-log-out'></i>
                </div>
            </div>
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
    <script src="../../assets/js/menu.js"></script>
    <script type="module" src="/src/libs/ionicons/ionicons.esm.js"></script>
    <script nomodule src="../../libs/ionicons/ionicons.js"></script>
</body>

</html>