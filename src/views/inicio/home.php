<?php
use App\Atlas\config\App;
$fechaInicio = new DateTime('2025-01-01');
$fechaFin = new DateTime('2025-01-31');

$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];
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
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper conten-main" id="conten-main">
        <!-- Menu lateral y superior -->
        <?php require_once App::URL_INC . "utils/menu.php"; ?>

        <!-- CUERPO DEL SISTEMA -->
        <main class="app-main p-0 pb-2 px-3">
            <!-- Header del menu -->
            <div class="container-fluid mt-4 ">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between mb-4 datos-header">
                            <div>
                                <h4 class="text-header mb-1 fw-semibold">¡Buenos días, <span class="rol-usuario-header">Administrador!</span></h4>
                                <p class="parrafo-header text-muted mb-0">Aquí está lo que está sucediendo con tu sistema hoy.</p>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <div class="calendar-header">
                                    <div class="calendar-display">
                                        <span class="calendar-text">
                                            <?php echo $fechaInicio->format('d') . ' ' . $meses[(int)$fechaInicio->format('n')] . ' ' . $fechaInicio->format('Y') ;?>
                                        </span>
                                        <div class="calendar-icon">
                                            <i class="fa-regular fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success">
                                    <i class="fa-regular fa-plus me-2"></i>
                                    Agregar Personal
                                </button>
                                <button class="btn btn-outline-primary btn-square">
                                    <i class="fa-regular fa-chart-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadisticas cards -->
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Card 1: Total Personal -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card custom-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <span class="text-muted fw-medium d-block mb-1 card-title-fixed">TOTAL DE PERSONAL</span>
                                        <h4 class="fw-semibold mb-0 text-dark" id="totalPersonal">854</h4>
                                        <div class="text-muted data-estatic mt-1">
                                            <span class="text-success fw-medium">
                                                <i class="fa-regular fa-arrow-up me-1"></i>+16.24%
                                            </span>
                                            desde el mes pasado
                                        </div>
                                    </div>
                                    <div class="lh-1">
                                        <div class="stat-icon bg-success">
                                            <i class="fa-regular fa-user-tie text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <a href="#" class="text-decoration-underline text-primary fw-medium">Ver personal total</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Archivos -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card custom-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <span class="text-muted fw-medium d-block mb-1 card-title-fixed">TOTAL DE ARCHIVOS</span>
                                        <h4 class="fw-semibold mb-0 text-dark" id="totalArchivos">860</h4>
                                        <div class="text-muted data-estatic mt-1">
                                            <span class="text-danger fw-medium">
                                                <i class="fa-regular fa-arrow-down me-1"></i>-3.57%
                                            </span>
                                            desde el mes pasado
                                        </div>
                                    </div>
                                    <div class="lh-1">
                                        <div class="stat-icon bg-primary">
                                            <i class="fa-regular fa-book text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <a href="#" class="text-decoration-underline text-primary fw-medium">Ver todos los archivos</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Vacaciones -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card custom-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <span class="text-muted fw-medium d-block mb-1 card-title-fixed">PERSONAL EN VACACIONES</span>
                                        <h4 class="fw-semibold mb-0 text-dark" id="personalVacaciones">12</h4>
                                        <div class="text-muted data-estatic mt-1">
                                            <span class="text-success fw-medium">
                                                <i class="fa-regular fa-arrow-up me-1"></i>+29.08%
                                            </span>
                                            desde el mes pasado
                                        </div>
                                    </div>
                                    <div class="lh-1">
                                        <div class="stat-icon bg-warning">
                                            <i class="fa-light fa-island-tropical text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <a href="#" class="text-decoration-underline text-primary fw-medium">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Ausencias -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card custom-card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <span class="text-muted fw-medium d-block mb-1 card-title-fixed">PERSONAL EN AUSENCIAS</span>
                                        <h4 class="fw-semibold mb-0 text-dark" id="personalAusencia">82</h4>
                                        <div class="text-muted data-estatic mt-1">
                                            <span class="text-muted fw-medium">
                                                <i class="fa-regular fa-minus me-1"></i>+0.00%
                                            </span>
                                            desde el mes pasado
                                        </div>
                                    </div>
                                    <div class="lh-1">
                                        <div class="stat-icon bg-info">
                                            <i class="fa-regular fa-users-gear text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <a href="#" class="text-decoration-underline text-primary fw-medium">Ver ausencias</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="container-fluid mb-4">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card custom-card">
                            <div class="card-header card-header-archivos-mes d-flex align-items-center justify-content-between">
                                <h4 class="card-title mb-0">Estadísticas de archivos</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <div id="contentbutton" class="position-absolute"></div>
                                    <canvas id="scoreChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Actividades recientes -->
                    <div class="col-xl-4">
                        <div class="card custom-card">
                            <div class="card-header">
                                <h4 class="card-title fw-semibold mb-0">Actividad Reciente</h4>
                            </div>
                            <div class="card-body">
                                <div class="activities-container">
                                    <div class="activity-item">
                                        <div class="activity-icon bg-primary-subtle">
                                            <i class="fa-regular fa-user-plus text-primary"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-title">Nuevo personal registrado</div>
                                            <div class="activity-description">Juan Pérez se registró en el sistema</div>
                                            <div class="activity-time">Hace 2 horas</div>
                                        </div>
                                    </div>
                                    <div class="activity-item">
                                        <div class="activity-icon bg-success-subtle">
                                            <i class="fa-regular fa-file-arrow-up text-success"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-title">Archivo subido</div>
                                            <div class="activity-description">Contrato de María García</div>
                                            <div class="activity-time">Hace 4 horas</div>
                                        </div>
                                    </div>
                                    <div class="activity-item">
                                        <div class="activity-icon bg-warning-subtle">
                                            <i class="fa-regular fa-calendar-check text-warning"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-title">Solicitud de vacaciones</div>
                                            <div class="activity-description">Carlos López solicitó vacaciones</div>
                                            <div class="activity-time">Hace 6 horas</div>
                                        </div>
                                    </div>
                                    <div class="activity-item">
                                        <div class="activity-icon bg-primary-subtle">
                                            <i class="fa-regular fa-user-plus text-primary"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-title">Nuevo personal registrado</div>
                                            <div class="activity-description">Jeison Balduz se registró en el sistema</div>
                                            <div class="activity-time">Hace 1 horas</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de usuarios -->
            <div class="container-fluid mb-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card ">
                            <div class="card-body p-0">
                                <div class="">
                                    <table id="tableUsers" class="tablet-user table table-hover ">
                                        <thead>
                                            <tr class="tablet-subHeader">
                                                <th scope="col" class="tablet-header text-white">#</th>
                                                <th scope="col" class="tablet-header text-white" >Estatus</th>
                                                <th scope="col" class="tablet-header text-white" >Empleado</th>
                                                <th scope="col" class="tablet-header text-white" >Usuario</th>
                                                <th scope="col" class="tablet-header text-white" style="border-top-right-radius: 5px;">Rol</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody-tabletUser">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archivos Chart -->
            <div class="container-fluid mb-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Archivos Subidos por Mes</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="scoreChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script type="module" src="<?php echo App::URL_SCRIPS . "home.js" ?>" ></script>

</body>

</html>