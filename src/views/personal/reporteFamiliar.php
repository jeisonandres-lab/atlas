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
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteParentesco">
                        <label class="form-check-label" for="reporteParentesco">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por parentesco
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteDiscapacidad">
                        <label class="form-check-label" for="reporteDiscapacidad">
                            <i class="text-danger me-2 bi bi-file-pdf-fill"></i>Reporte por discapacidad
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
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelDiscapacidad">
                        <label class="form-check-label" for="reporteExcelDiscapacidad">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por discapacidad
                        </label>
                    </div>
                </div>

                <div class="mt-3 contenbtn">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input report-checkbox" type="checkbox" value="" id="reporteExcelParentesco">
                        <label class="form-check-label" for="reporteExcelParentesco">
                            <i class="text-success fa-regular fa-table me-2"></i>Reporte por parentesco
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