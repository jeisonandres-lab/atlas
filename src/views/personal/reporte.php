<?php
sleep(1);
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'pdf';
if ($tipo === 'pdf') {
        // Generar botones para PDF
    ?>
        <div class="container-fluid contenbotonesreport" id="contentReport">
            <p class="mb-0 mt-2">Seleccione el tipo de reporte</p>
            <hr class="mt-1 mb-2">
            <div class="report">

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteSexo">
                        <label class="form-check-label" for="reporteSexo">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por sexualidad
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteEdad">
                        <label class="form-check-label" for="reporteEdad">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Edad
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteEstadoCivil">
                        <label class="form-check-label" for="reporteEstadoCivil">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Estado civil
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteNivelAcademico">
                        <label class="form-check-label" for="reporteNivelAcademico">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Nivel Academico
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteCargo">
                        <label class="form-check-label" for="reporteCargo">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Cargo
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteEstatus">
                        <label class="form-check-label" for="reporteEstatus">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por estatus
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteVivienda">
                        <label class="form-check-label" for="reporteVivienda">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Vivienda
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteDireccion">
                        <label class="form-check-label" for="reporteDireccion">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Dirección
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteFecha">
                        <label class="form-check-label" for="reporteFechaIngreso">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Fecha Ingreso
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteDependencia">
                        <label class="form-check-label" for="reporteDependencia">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Dependencia
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteDepartamento">
                        <label class="form-check-label" for="reporteDepartamento">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por Departamento
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="container-fluid">
                <div class="row" id="contentReporHTML">

                </div>
            </div>
        </div>
    <?php
} elseif ($tipo === 'excel') {
    // Generar botones para Excel
    ?>
        <div class="container-fluid contenbotonesreport" id="contentReport">
            <p class="mb-0 mt-2">Seleccione el tipo de reporte</p>
            <hr class="mt-1 mb-2">
            <div class="report">

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelSexo">
                        <label class="form-check-label" for="reporteExcelSexo">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por sexualidad
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelEdad">
                        <label class="form-check-label" for="reporteExcelEdad">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Edad
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelEstadoCivil">
                        <label class="form-check-label" for="reporteExcelEstadoCivil">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Estado civil
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelNivelAcademico">
                        <label class="form-check-label" for="reporteExcelNivelAcademico">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Nivel Academico
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelCargo">
                        <label class="form-check-label" for="reporteExcelCargo">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Cargo
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelEstatus">
                        <label class="form-check-label" for="reporteExcelEstatus">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por estatus
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelVivienda">
                        <label class="form-check-label" for="reporteExcelVivienda">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Vivienda
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelDireccion">
                        <label class="form-check-label" for="reporteExcelDireccion">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Dirección
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelFecha">
                        <label class="form-check-label" for="reporteExcelFechaIngreso">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Fecha Ingreso
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelDependencia">
                        <label class="form-check-label" for="reporteExcelDependencia">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Dependencia
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelDepartamento">
                        <label class="form-check-label" for="reporteExcelDepartamento">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por Departamento
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="container-fluid">
                <div class="row" id="contentReporHTML">

                </div>
            </div>
        </div>
    <?php
} else {
    echo 'Tipo de reporte no válido.';
}

?>