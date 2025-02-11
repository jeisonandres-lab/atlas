<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATLAS | HOME</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "home.css"; ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0 pb-2">
            <div class="container-fluid text-center  p-5 pb-4">
                <div class="row">
                    <div class="col d-flex justify-content-start flex-column">
                        <div class="panelHome mb-3">
                            <span class="d-flex align-items-center">
                                <a class="icon-link  align-items-center me-3" href="users">
                                    <i class="bi bi-box2"></i>
                                    <p class="mb-0 ">Panel De Usuarios</p>
                                </a>
                                <i class="fa-regular fa-arrow-right me-3 sm"></i>
                                <p class="mb-0 fw-medium">Registros</p>
                            </span>
                        </div>

                        <div class="text-start">
                            <h3 class="fw-medium">Panel Principal</h3>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-end ">
                        <div class="d-flex align-items-center">
                            <div class="form-group me-3">
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius: 0px; background-color: white;"><i class="fa-light fa-calendar"></i></span>
                                    <span type="text" class="form-control" id="fecha" style="border-radius: 0px;"> </span>
                                </div>
                            </div>
                            <div class="buttonHome">
                                <button class="btn btn-primary btn-sm fw-semibold pe-3 ps-3" style="border-radius: 0px; "><i class="fa-light fa-arrows-turn-right me-3"></i>Recorte</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- subMenu de la vista -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <!-- PERSONAL REGISTRADO -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted fs-13 d-block mb-1">
                                                    Total de personal
                                                </span>
                                                <h4 class="fw-medium mb-0" id="totalPersonal">
                                                    854
                                                </h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded color-primary">
                                                    <i class="fa-regular fa-user-tie fs-5 icon-menu"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-13">
                                            Aumentó un
                                            <span class="text-success">
                                                2,56% <i class="fa-regular fa-arrow-up"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TOTAL DE ARCHIVOS SUBIDOS EN EL MES ACTUAL-->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted fs-13 d-block mb-1">
                                                    Total de achivos
                                                </span>
                                                <h4 class="fw-medium mb-0" id="totalArchivos">
                                                    860
                                                </h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded color-primary-tint2">
                                                    <i class="fa-regular fa-book fs-5 icon-menu"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-13">
                                            Aumentó un
                                            <span class="text-success">
                                                <span id="porcentajeArchivos">2,56% </span><i class="fa-regular fa-arrow-up ms-1"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ATENCION MEDICA -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted fs-13 d-block mb-1">
                                                    Atención médica
                                                </span>
                                                <h4 class="fw-medium mb-0" id="atencionMedica">
                                                    870
                                                </h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded color-primary-tint1">
                                                    <i class="fa-regular fa-user-doctor-hair fs-5 icon-menu"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-13">
                                            Aumentó un
                                            <span class="text-success">
                                                <span id="porcentajeAtencionMedica">2,56% </span> <i class="fa-regular fa-arrow-up"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MEDICAMENTOS -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted fs-13 d-block mb-1">
                                                    Total de medicamentos
                                                </span>
                                                <h4 class="fw-medium mb-0" id="totalMedicamentos">
                                                    8980
                                                </h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded color-primary-tint3">
                                                    <i class="fa-solid fa-capsules fs-5 icon-menu"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-13">
                                            Aumentó un
                                            <span class="text-success">
                                                2,56% <i class="fa-regular fa-arrow-up"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PERSONAL DE VACACIONES -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted fs-13 d-block mb-1">
                                                    Personal de vacaciones
                                                </span>
                                                <h4 class="fw-medium mb-0" id="personalVacaciones">
                                                    12
                                                </h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded color-primary">
                                                    <i class="fa-light fa-island-tropical fs-5 icon-menu"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-13">
                                            Aumentó un
                                            <span class="text-success">
                                                2,56% <i class="fa-regular fa-arrow-up"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PERSONAL EN AUSENCIA -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted fs-13 d-block mb-1">
                                                    Personal en ausencia
                                                </span>
                                                <h4 class="fw-medium mb-0" id="personalAusencia">
                                                    82
                                                </h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded color-primary">
                                                    <i class="fa-regular fa-users-gear fs-5 icon-menu"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-13">
                                            Aumentó un
                                            <span class="text-success">
                                                2,56% <i class="fa-regular fa-arrow-up"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- USUARIOS Y ESTADISTICAS DEL DATOS -->
            <div class="container-fluid mb-2">
                <div class="row">
                    <div class="col">
                        <div class="bg-white p-3">
                            <table id="tableUsers" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center bg-primary">#</th>
                                        <th scope="col" class="text-center bg-primary">Usuario</th>
                                        <th scope="col" class="text-center bg-primary">Rol</th>
                                        <th scope="col" class="text-center bg-primary">Activo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white p-3" style="height: 100%;">
                            <canvas id="scoreChart2" >
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ARCHIVOS SUBIDOS -->
            <div class="container-fluid px-2">
                <!-- ESTADISTICAS -->
                <div class="bg-white px-2">
                    <di class="char">
                        <canvas id="scoreChart">
                        </canvas>
                    </di>
                </div>
            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>
    <script type="module" src="<?php echo App::URL_SCRIPS . "home.js" ?>"></script>
</body>

</html>