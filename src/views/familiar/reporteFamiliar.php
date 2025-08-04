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
                <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteSexo" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteSexo"></label>
                        <span class="ms-2">Reporte por sexo</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteEdad" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteEdad"></label>
                        <span class="ms-2">Reporte por edad</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteParentesco" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteParentesco"></label>
                        <span class="ms-2">Reporte de parentesco</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteDiscapacidad" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteDiscapacidad"></label>
                        <span class="ms-2">Reporte de discapacidad</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteFecha" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteFecha"></label>
                        <span class="ms-2">Reporte por fecha</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reportePersonalizado" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reportePersonalizado"></label>
                        <span class="ms-2">Reporte personalizado</span>
                    </div>
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
                <div class="form-check form-check-inline checkbox-wrapper-7">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelSexo" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelSexo"></label>
                        <span class="ms-2">Reporte por sexualidad</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelEdad" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelEdad"></label>
                        <span class="ms-2">Reporte por Edad</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelDiscapacidad" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelDiscapacidad"></label>
                        <span class="ms-2">Reporte por discapacidad</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelParentesco" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelParentesco"></label>
                        <span class="ms-2">Reporte por parentesco</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelFecha" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelFecha"></label>
                        <span class="ms-2">Reporte por fecha</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reportePersonalizado" type="checkbox" value="" />
                        <label class="tgl-btn" for="reportePersonalizado"></label>
                        <span class="ms-2">Reporte personalizado</span>
                    </div>
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