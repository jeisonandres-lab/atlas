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
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteEstadoCivil" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteEstadoCivil"></label>
                        <span class="ms-2">Reporte por Estado civil</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteNivelAcademico" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteNivelAcademico"></label>
                        <span class="ms-2">Reporte por Nivel Academico</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteCargo" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteCargo"></label>
                        <span class="ms-2">Reporte por cargo</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteEstatus" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteEstatus"></label>
                        <span class="ms-2">Reporte por estatus</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteVivienda" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteVivienda"></label>
                        <span class="ms-2">Reporte por vivienda</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteDireccion" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteDireccion"></label>
                        <span class="ms-2">Reporte por direccion</span>
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
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteDependencia" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteDependencia"></label>
                        <span class="ms-2">Reporte por Dependencia</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteDepartamento" type="checkbox" value="" />
                        <label class="tgl-btn pdf" for="reporteDepartamento"></label>
                        <span class="ms-2">Reporte por Departamento</span>
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
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelSexo" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelSexo"></label>
                        <span class="ms-2">Reporte por sexo</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelEdad" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelEdad"></label>
                        <span class="ms-2">Reporte por edad</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelEstadoCivil" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelEstadoCivil"></label>
                        <span class="ms-2">Reporte por Estado civil</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelNivelAcademico" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelNivelAcademico"></label>
                        <span class="ms-2">Reporte por Nivel Academico</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelCargo" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelCargo"></label>
                        <span class="ms-2">Reporte por cargo</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelEstatus" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelEstatus"></label>
                        <span class="ms-2">Reporte por estatus</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelVivienda" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelVivienda"></label>
                        <span class="ms-2">Reporte por vivienda</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelDireccion" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelDireccion"></label>
                        <span class="ms-2">Reporte por direccion</span>
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
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelDependencia" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelDependencia"></label>
                        <span class="ms-2">Reporte por Dependencia</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 contenbtn">
                <div class="form-check form-check-inline">
                    <div class="checkbox-wrapper-7 d-flex align-items-center">
                        <input class="form-check-input tgl tgl-ios report-checkbox ignore-validation" id="reporteExcelDepartamento" type="checkbox" value="" />
                        <label class="tgl-btn" for="reporteExcelDepartamento"></label>
                        <span class="ms-2">Reporte por Departamento</span>
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