<?php

use App\Atlas\config\App;


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATLAS | Panel Principal</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "home.css"; ?>">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu_lateral.php"; ?>


        <main class="app-main" style="padding: 0 !important;">


            <div class="container-fluid z-2 pt-3 contenedor-principal">
                <!-- Encabezado del panel -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="dashboard-header d-flex flex-wrap justify-content-between align-items-center bg-white rounded-3 px-3  border-0 content">
                            <div class="d-flex align-items-center gap-3">
                                <img src="./src/assets/img/images/logoince2-removebg-preview.png" alt="Logo" class="dashboard-header-logo" />
                                <div>
                                    <h5 class="mb-0 stat-card-label fs-4">Panel Principal</h5>
                                    <small class="text-muted">Plataforma de <span class="badge text-bg-success">Análisis y Optimización de Talento Humano</span></small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="container-fluid d-flex justify-content-center align-items-center gap-3">
                                    <div class=" dashboard-date w-auto input-group input-group-sm border rounded-2">
                                        <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                                        <span class="form-control bg-white border-0 py-2" id="fecha"></span>
                                    </div>
                                    <div class="">
                                        <button class="btn btn-primary btn-md border-0 rounded-2 px-3">
                                        <i class="fa-regular fa-database me-2"></i>
                                        Descargar BD</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjetas de métricas: centradas, con color e información -->
                <div class="p-0 mb-3 ">

                    <div class="row boxsd bg-white p-0 m-0 rounded-2 transform">
                        <!-- Personal -->
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 xl-2 pe-0">
                            <div class="bg-white dashboard-stat-card stat-card-primary h-100 border-0 rounded-start">
                                <div class="p-3 ">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="stat-card-label">Empleados</span>
                                        <div class="stat-icon stat-icon-primary flex-shrink-0">
                                            <i class="fa-regular fa-users"></i>
                                        </div>
                                    </div>

                                    <div class=" align-items-center justify-content-start">
                                        <h5 class="fw-bold mb-0 stat-card-value me-2 fs-4"><span id="totalPersonalSmall">0</span></h5>
                                        <small class="text-muted stat-card-sub">Empleados registrados</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total de archivos -->
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 xl-2 px-0">
                            <div class="bg-white dashboard-stat-card stat-card-success h-100  border-0">
                                <div class=" p-3 rounded-0">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="stat-card-label">Archivos</span>
                                        <div class="stat-icon stat-icon-success flex-shrink-0">
                                            <i class="fa-regular fa-folder-arrow-up"></i>
                                        </div>
                                    </div>

                                    <div class=" align-items-center justify-content-start">
                                        <h5 class="fw-bold mb-0 stat-card-value me-2 fs-4"><span id="totalArchivosSmall">0</span></h5>
                                        <small class="text-muted stat-card-sub">Archivos subidos</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Familiares -->
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 xl-2 px-0">
                            <div class="bg-white dashboard-stat-card stat-card-familiares h-100  border-0">
                                <div class=" p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="stat-card-label">Familiares </span>
                                        <div class="stat-icon stat-icon-warning flex-shrink-0">
                                            <i class="fa-regular fa-family"></i>
                                        </div>
                                    </div>
                                    <div class=" align-items-center justify-content-start">
                                        <h5 class="fw-bold mb-0 stat-card-value me-2 fs-4"><span id="totalFamiliaresSmall">0</span></h5>
                                        <small class="text-muted stat-card-sub">Familiares registrados</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vacaciones -->
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 xl-2 ps-0 rounded-end">
                            <div class="bg-white dashboard-stat-card stat-card-warning h-100 border-0">
                                <div class="p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="stat-card-label">Vacaciones</span>
                                        <div class="stat-icon stat-icon-danger flex-shrink-0">
                                            <i class="fa-regular fa-umbrella-beach"></i>
                                        </div>
                                    </div>
                                    <div class=" align-items-center justify-content-start">
                                        <h5 class="fw-bold mb-0 stat-card-value me-2 fs-4"><span id="personalVacacionesSmall">0</span></h5>
                                        <small class="text-muted stat-card-sub">Vacaciones registradas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                   //ausencia
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 xl-2">
                        <div class="card dashboard-stat-card stat-card-danger h-100 content border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="stat-card-label">Ausencia</span>
                                    <div class="stat-icon stat-icon-danger flex-shrink-0">
                                        <i class="fa-regular fa-user-clock"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <h5 class="fw-bold mb-0 stat-card-value me-2"><span id="personalAusenciaSmall">0</span></h5>
                                    <small class="text-muted stat-card-sub">Permisos registrados</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    //permisos
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 xl-2">
                        <div class="card dashboard-stat-card stat-card-info h-100 content border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="stat-card-label">Permisos</span>
                                    <div class="stat-icon stat-icon-info flex-shrink-0">
                                        <i class="fa-sharp fa-regular fa-calendar-clock"></i>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-start">
                                    <h5 class="fw-bold mb-0 stat-card-value me-2"><span id="permisosPendientesSmall">0</span></h5>
                                    <small class="text-muted stat-card-sub">Permisos pendientes</small>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    </div>


                </div>

                <!-- Fila principal: Total archivos + Crecimiento -->
                <div class="row g-3 mb-4">
                    <div class="col-5 col-sm-12 col-md-12 col-lg-12 xl-5">
                        <div class="card dashboard-chart-card h-100 border-0 shadow-sm position-relative">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 fw-semibold">Total de archivos por mes</h5>
                                    <div id="contentbutton" class="d-flex gap-1"></div>
                                </div>
                                <div class="chart-container">
                                    <div id="scoreChart2" class="chart-fixed-height" aria-label="Gráfica por meses"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-7 col-sm-12 col-md-12 col-lg-12 xl-7">
                        <div class="card dashboard-chart-card h-100 dashboard-chart-resumen border-0 content">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3 fw-semibold">Resumen</h5>
                                <div class="chart-container">
                                    <div id="scoreChart" class="chart-fixed-height"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usuarios y permisos (tabla elegante) -->
                <div class="row">
                    <div class="col-12">
                        <div class="home-users-table-card content border-0">
                            <div class="home-users-table-card-body">
                                <h5 class="home-users-table-title mb-3 fw-semibold">Usuarios y permisos</h5>
                                <div class="home-users-table-toolbar d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <div id="home-users-length-wrap"></div>
                                        <button type="button" class="btn btn-home-users-primary" onclick="window.location.href='./usuarios'">
                                            <i class="fa-solid fa-users me-1"></i> Ver movimientos
                                        </button>
                                    </div>
                                    <div class="home-users-table-search-wrap">
                                        <div class="input-group input-group-sm home-users-table-search">
                                            <span class="input-group-text bg-white border-end-0"><i class="fa-regular fa-magnifying-glass text-muted"></i></span>
                                            <input type="text" id="homeUsersSearch" class="form-control border-start-0" placeholder="Buscar usuario..." aria-label="Buscar usuario" />
                                        </div>
                                    </div>
                                </div>
                                <div class="home-users-table-wrap">
                                    <table id="tableUsers" class="table home-users-table table-hover mb-0" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Conexión</th>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">Rol</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="home-users-table-footer d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3 pt-3 border-top">
                                    <div class="home-users-table-info text-muted small" id="tableUsers_info"></div>
                                    <div class="home-users-table-paginate" id="tableUsers_paginate"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="imagen-fondo">
                <img src="./src/assets/img/images/Adobe Express - file.png" alt="">
            </div>
        </main>

        <!-- Modal tipos de archivos por mes -->
        <div class="modal fade" id="fileTypeModal" tabindex="-1" aria-labelledby="fileTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold" id="fileTypeModalLabel">Tipos de archivos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body pt-2">
                        <p id="fileTypeMonth" class="mb-2 fw-semibold"></p>
                        <ul id="fileTypeList" class="list-group list-group-flush"></ul>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

    <?php require_once App::URL_INC . "/scripts.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>
    <script type="module" src="<?php echo App::URL_SCRIPTS . "home.js" ?>" defer></script>
</body>

</html>