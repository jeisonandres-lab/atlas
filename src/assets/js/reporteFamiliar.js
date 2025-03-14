import { AlertSW2 } from "./ajax/alerts.js";
import { descargarArchivo, obtenerDatos, obtenerDatosJQuery } from "./ajax/formularioAjax.js";
import {
    incluirSelec2,
    validarSelectoresSelec2,
    validarNumeroNumber,
    validarInputFecha,

} from "./ajax/inputs.js";
$(function () {

    const opciones = ["Hijo", "Hija", "Padre", "Madre", "Hermano"];
    validarSelectoresSelec2("#sexo_filtrar", ".span_sexo_filtrar");
    validarSelectoresSelec2("#tpDiscapacidad2", ".span_tpDiscapacidad2");
    validarSelectoresSelec2("#parentesco2", ".span_parentesco2");
    validarInputFecha("#fecha_filtrar", ".span_fecha_filtrar")
    validarInputFecha("#fecha_fin_filtrar", ".span_fecha_fin_filtrar")
    validarNumeroNumber("#edad_filtrar", ".span_edad_filtrar", 2);

    $("#descargarReporte2").prop("disable", true);
    $(document).on("click", '.reporteTrabajador', async function (event) {
        event.preventDefault();
        const href = $(this).attr('href');

        $.ajax({
            url: './src/views/personal/reporteFamiliar.php',
            type: 'GET',
            dataType: 'html',
            data: { tipo: href }, // O 'excel'
            beforeSend: function () {
                AlertSW2("info", "Cargando datos del reporte...", "top",); // Cambié "error" a "info" para mayor claridad
            },
            success: function (html) {
                Swal.close(); // Cierra la alerta SweetAlert2
                // $("#datosReporte").prop("hidden", false);
                $("#datosReporte").removeAttr("hidden");
                $('#contentBodyCard2').html(html);
                if (href == 'pdf') {
                    $("#cabeza-reporte").html('Generar Reporte PDF');
                    $("#descargarReporte2").addClass('btn-danger btn-hover-rojo');
                    $("#descargarReporte2").removeClass('btn-success btn-verde-rojo');
                    $("#descargarReporte2").html('<i class="fa-regular fa-file-pdf fa-sm me-2"></i>Descargar PDF');

                } else {
                    $("#cabeza-reporte").html('Generar Reporte EXCEL');
                    $("#descargarReporte2").removeClass('btn-danger btn-hover-rojo');
                    $("#descargarReporte2").addClass('btn-success btn-hover-verde');
                    $("#descargarReporte2").html('<i class="fa-regular fa-table fa-sm me-2"></i>Descargar EXCEL');

                }
                $('#datosReporte').slideDown(500, function () {
                    $('#datosReporte').animate({
                        transform: 'scale(1)'
                    }, 350, function () {

                        $('html, body').animate({
                            scrollTop: $('#contentReport')[0].scrollIntoView({ behavior: 'smooth' })
                        }, 800);


                        incluirSelec2("#sexo_filtar");
                    });
                });
            },
            error: function (error) {
                Swal.close(); // Cierra la alerta SweetAlert2
                console.error('Error al cargar el contenido:', error);
                AlertSW2("error", "Error al cargar el reporte", "top", 5000); // Muestra un mensaje de error
            }
        });



    })

    // cerrar el card de reporte
    $(document).on('click', '#cerrarReport', async function () {
        $('#datosReporte').slideUp(800, function () {

            // Animación de desplazamiento al narvarPrincipal después del cierre
            $('html, body').animate({
                scrollTop: $('#narvarPrincipal')[0].scrollIntoView({ behavior: 'smooth' })
            }, 3000);
            $("#contentReport").remove();

            // Aquí puedes agregar cualquier otra lógica que necesites después del cierre
        });
    });

    //EVENTO PARA VALDIAR LAS FECHAS INICIO Y FIN
    $(document).on("change", "#fecha_fin_filtrar, #fecha_filtrar", async function () {
        let fechaInic = $("#fecha_filtrar").val();
        let fechaFin = $("#fecha_fin_filtrar").val();

        console.log(fechaInic)
        console.log(fechaFin)

        if (fechaInic >= fechaFin) {

            $("#descargarReporte2").prop("disabled", true);
        } else {
            $("#descargarReporte2").prop("disabled", false);
        }

    });

    //formulario para descargar los reportes
    $(document).on("submit", "#formulario-descargarpdf", async function (event) {
        event.preventDefault();
        const data = new FormData(this);
        const nombreReporte = $(this).data('nombre');
        console.log(nombreReporte);
        // Obtener el atributo 'action' del formulario
        const formAction = $(this).attr("action");
        if (formAction == "#") {
            await AlertSW2("error", "Seleccione una opcion", "top", 3000)
        } else {
            // Usar el atributo 'action' en la función descargarArchivo
            await descargarArchivo(formAction, nombreReporte, data);
        }

    });

    //GENERAR LOS INPUTS DEL REPORTE
    $(document).on("change", "#contentReport .report-checkbox", function () {
        if ($(this).is(":checked")) {
            var checkboxId = $(this).attr("id"); // Obtiene el ID del checkbox
            console.log("Checkbox seleccionado: " + checkboxId); // Muestra el ID en la consola
            // Verifica si el checkbox 'reportePersonalizado' NO está marcado
            if ($(this).is(":checked")) {
                if (!$("#reportePersonalizado").is(":checked")) {
                    // Si 'reportePersonalizado' no está marcado, desmarca los otros checkboxes
                    $("#contentReport .report-checkbox").not(this).prop("checked", false);
                    $("#contentReporHTML").empty();
                }
                if (checkboxId == 'reporteSexo') {
                    $("#contentReporHTML").append(
                        `
                          <div class="col-sm-12 col-md-6 col-xl-6" id="contentSexo">
                            <div class="form-group">
                              <label for="sexo_filtrar">Tipo de sexo</label>
                              <div class="input-group">
                                <span class="input-group-text span_sexo_filtrar"><i class="icons fa-regular fa-user-group-simple"></i></span>
                                <select class="form-select form-select-md" id="sexo_filtrar" name="sexo_filtrar">
                                  <option value="">Selecione el sexo</option>
                                  <option value="Masculino">Masculino</option>
                                  <option value="Femenino">Femenino</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        `
                    );
                    incluirSelec2("#sexo_filtrar");
                    $('#formulario-descargarpdf').data('nombre', 'familiar_sexualidad');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarSexo");
                } else if (checkboxId == "reporteEdad") {
    
                    $("#contentReporHTML").append(`
                        <div class="col-sm-12 col-md-6 col-xl-6" id="contentEdad">
                            <div class="form-group">
                                <label for="edad_filtrar">Edad</label>
                                <div class="input-group">
                                    <span class="input-group-text span_edad_filtrar"><i class="icons fa-regular fa-users-line"></i></span>
                                    <input type="number" class="form-control" id="edad_filtrar" name="edad_filtrar" placeholder="Edad del personal" required>
                                </div>
                            </div>
                        </div>
                    `);
                    $('#formulario-descargarpdf').data('nombre', 'familiar-edad');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarEdad");
                } else if (checkboxId == "reporteDiscapacidad") {
    
                    $("#contentReporHTML").append(
                        `
                          <div class="col-sm-12 col-md-6 col-xl-6" id="contentDiscapacidad">
                            <div class="form-group">
                                <label for="tpDiscapacidad">Tipo De Discapacidad</label>
                                <div class="input-group">
                                    <span class="input-group-text span_tpDiscapacidad2"><i class="icons fa-solid fa-wheelchair-move"></i></span>
                                    <select type="text" class="form-control ignore-validation" id="tpDiscapacidad2" name="tpDiscapacidad" placeholder="Tipo de Discapacidad ">
                                        <option value="">Seleccione una discapacidad</option>
                                        <option value="Visual">Discapacidad visual</option>
                                        <option value="Auditiva">Discapacidad auditiva</option>
                                        <option value="Motriz">Discapacidad motriz</option>
                                        <option value="Intelectual">Discapacidad intelectual</option>
                                        <option value="Psicosocial">Discapacidad psicosocial</option>
                                        <option value="Visceral">Discapacidad visceral</option>
                                        <option value="Multiples">Discapacidades múltiples</option>
                                        <option value="Otra">Otra discapacidad</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                        `,
    
                    );
    
                    incluirSelec2("#tpDiscapacidad2");
    
                    $('#formulario-descargarpdf').data('nombre', 'Familiar-discapacidad');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarDiscapacidad");
    
                } else if (checkboxId == "reporteParentesco") {
                    $("#contentReporHTML").append(
                        `
                          <div class="col-sm-12 col-md-6 mb-2" id="contentParentesco">
                                <div class="form-group">
                                    <label for="parentesco">Parentesco</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_parentesco2"><i class="icons fa-regular fa-person-half-dress"></i></span>
                                        <select class="form-select form-select-md estado-parentesco" id="parentesco2" name="parentesco" aria-label="Small select example" aria-placeholder="dasdas" required>
                                            <option value="">Selecione un parentesco</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        `,
    
                    );
    
                    $("#parentesco2").empty();
                    $("#parentesco2").append($("<option>", {
                        value: "",
                        text: "Seleccione un parentesco"
                    }));
                    opciones.forEach(function (value) {
                        $("#parentesco2").append($("<option>", {
                            value: value,
                            text: value
                        }));
                    });
    
                    incluirSelec2("#parentesco2");
    
                    $('#formulario-descargarpdf').data('nombre', 'familiar-parentesco');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarParentesco");
    
                } else if (checkboxId == "reporteFecha") {
    
                    $("#contentReporHTML").append(
                        `
                        <div class="d-flex" id="contentFechaRango1">
                            <div class="col-sm-6 col-md-6 mb-2 me-2" >
                                <div class="form-group">
                                    <label for="fecha_filtrar">Desde</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_fecha_filtrar"><i class="icons fa-regular fa-calendars"></i></span>
                                        <input type="text" class="form-control fecha_filtrar" id="fecha_filtrar" name="fecha_ini_filtrar2" placeholder="Fecha de Ingreso" required>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-sm-6 col-md-6 mb-2" id="contentFechaRango2">
                                <div class="form-group">
                                    <label for="fecha_fin_filtrar">Hasta</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_fecha_fin_filtrar"><i class="icons fa-regular fa-calendars"></i></span>
                                        <input type="text" class="form-control fecha_fin_filtrar" id="fecha_fin_filtrar" name="fecha_fin_filtrar2" placeholder="Fecha de Ingreso" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        `,
                    );
                    $('#formulario-descargarpdf').data('nombre', 'familiar-rangoFecha');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarRangoFecha");
                    $("#fecha_filtrar").datepicker({
                        dateFormat: "dd-mm-yy", // Cambia el formato de la fecha
                        showWeek: true, // Muestra el número de la semana
                        firstDay: 1, // Establece el primer día de la semana (1 = lunes)
                        changeMonth: true, // Permite cambiar el mes
                        changeYear: true, // Permite cambiar el año
                        yearRange: "1900:2025",
                        regional: "es" // Establece el rango de años
                    });
                    $("#fecha_fin_filtrar").datepicker({
                        dateFormat: "dd-mm-yy", // Cambia el formato de la fecha
                        showWeek: true, // Muestra el número de la semana
                        firstDay: 1, // Establece el primer día de la semana (1 = lunes)
                        changeMonth: true, // Permite cambiar el mes
                        changeYear: true, // Permite cambiar el año
                        yearRange: "1900:2025",
                        regional: "es" // Establece el rango de años
                    });
                } else if (checkboxId == "reportePersonalizado") {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-personalizado');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarPersonalizado");
                  
                } else if (checkboxId == "reporteExcelSexo") {
                    $("#contentReporHTML").append(
                        `
                          <div class="col-sm-12 col-md-6 col-xl-6">
                            <div class="form-group">
                              <label for="sexo_filtrar">Tipo de sexo</label>
                              <div class="input-group">
                                <span class="input-group-text span_sexo_filtrar"><i class="icons fa-regular fa-user-group-simple"></i></span>
                                <select class="form-select form-select-md" id="sexo_filtrar" name="sexo_filtrar">
                                  <option value="">Selecione el sexo</option>
                                  <option value="Masculino">Masculino</option>
                                  <option value="Femenino">Femenino</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        `
                    );
                    incluirSelec2("#sexo_filtrar");
                    $('#formulario-descargarpdf').data('nombre', 'familiar-sexualidadExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarSexoExcel");
                } else if (checkboxId == 'reporteExcelDiscapacidad') {
    
                    $("#contentReporHTML").append(
                        `
                          <div class="col-sm-12 col-md-6 col-xl-6">
                            <div class="form-group">
                                <label for="tpDiscapacidad">Tipo De Discapacidad</label>
                                <div class="input-group">
                                    <span class="input-group-text span_tpDiscapacidad2"><i class="icons fa-solid fa-wheelchair-move"></i></span>
                                    <select type="text" class="form-control ignore-validation" id="tpDiscapacidad2" name="tpDiscapacidad" placeholder="Tipo de Discapacidad ">
                                        <option value="">Seleccione una discapacidad</option>
                                        <option value="Visual">Discapacidad visual</option>
                                        <option value="Auditiva">Discapacidad auditiva</option>
                                        <option value="Motriz">Discapacidad motriz</option>
                                        <option value="Intelectual">Discapacidad intelectual</option>
                                        <option value="Psicosocial">Discapacidad psicosocial</option>
                                        <option value="Visceral">Discapacidad visceral</option>
                                        <option value="Multiples">Discapacidades múltiples</option>
                                        <option value="Otra">Otra discapacidad</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                        `,
    
                    );
    
                    incluirSelec2("#tpDiscapacidad2");

                    $('#formulario-descargarpdf').data('nombre', 'familiar-discapacidadExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarDiscapacidadExcel");
    
                } else if (checkboxId == "reporteExcelEdad") {
    
                    $("#contentReporHTML").append(
                        `
                          <div class="col-sm-12 col-md-6 col-xl-6">
                            <div class="form-group">
                              <label for="edad_filtrar">Edad</label>
                              <div class="input-group">
                                <span class="input-group-text span_edad_filtrar"><i class="icons fa-regular fa-users-line"></i></span>
                                 <input type="number" class="form-control" id="edad_filtrar" name="edad_filtrar" placeholder="Edad del personal" required>
                              </div>
                            </div>
                          </div>
                        `,
    
                    );

                    $('#formulario-descargarpdf').data('nombre', 'familiar-edadExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarEdadExcel");
                } else if (checkboxId == "reporteExcelParentesco") {
    
                    $("#contentReporHTML").append(
                        `
                          <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="parentesco">Parentesco</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_parentesco"><i class="icons fa-regular fa-person-half-dress"></i></span>
                                        <select class="form-select form-select-md estado-parentesco" id="parentesco2" name="parentesco" aria-label="Small select example" aria-placeholder="dasdas" required>
                                            <option value="">Selecione un parentesco</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        `,
    
                    );
    
                    $("#parentesco2").empty();
                    $("#parentesco2").append($("<option>", {
                        value: "",
                        text: "Seleccione un parentesco"
                    }));
                    opciones.forEach(function (value) {
                        $("#parentesco2").append($("<option>", {
                            value: value,
                            text: value
                        }));
                    });
    
                    incluirSelec2("#parentesco2");
                    
                    $('#formulario-descargarpdf').data('nombre', 'familiar-parentescoExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarParentescoExcel");
                    incluirSelec2("#estatus_filtrar");
    
                } else if (checkboxId == "reporteExcelFecha") {
    
                    $("#contentReporHTML").append(
                        `
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="fecha_filtrar">Desde</label>
                                <div class="input-group">
                                    <span class="input-group-text span_fecha_filtrar"><i class="icons fa-regular fa-calendars"></i></span>
                                    <input type="text" class="form-control fecha_filtrar" id="fecha_filtrar" name="fecha_ini_filtrar2" placeholder="Fecha de Ingreso" required>
                                </div>
                            </div>
                        </div>
    
                         <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="fecha_fin_filtrar">Hasta</label>
                                <div class="input-group">
                                    <span class="input-group-text span_fecha_fin_filtrar"><i class="icons fa-regular fa-calendars"></i></span>
                                    <input type="text" class="form-control fecha_fin_filtrar" id="fecha_fin_filtrar" name="fecha_fin_filtrar2" placeholder="Fecha de Ingreso" required>
                                </div>
                            </div>
                        </div>
                        `,
                    );
                    $('#formulario-descargarpdf').data('nombre', 'familiar-rangoFechaExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarRangoFechaExcel");
                    $("#fecha_filtrar").datepicker({
                        dateFormat: "dd-mm-yy", // Cambia el formato de la fecha
                        showWeek: true, // Muestra el número de la semana
                        firstDay: 1, // Establece el primer día de la semana (1 = lunes)
                        changeMonth: true, // Permite cambiar el mes
                        changeYear: true, // Permite cambiar el año
                        yearRange: "1900:2025",
                        regional: "es" // Establece el rango de años
                    });
                    $("#fecha_fin_filtrar").datepicker({
                        dateFormat: "dd-mm-yy", // Cambia el formato de la fecha
                        showWeek: true, // Muestra el número de la semana
                        firstDay: 1, // Establece el primer día de la semana (1 = lunes)
                        changeMonth: true, // Permite cambiar el mes
                        changeYear: true, // Permite cambiar el año
                        yearRange: "1900:2025",
                        regional: "es" // Establece el rango de años
                    });
                }
            } else {
                // Si el checkbox se desmarca, borra el contenido de contentReporHTML
                $("#contentReporHTML").empty();
            }
            
        }
    });

    // Evento change específico para reportePersonalizado
    $(document).on("change", "#reportePersonalizado", function () {
        if (!$(this).is(":checked")) {
            // Si reportePersonalizado se desmarca, desmarca todos los demás checkboxes
            $("#contentReport .report-checkbox").not("#reportePersonalizado").prop("checked", false);
            $("#contentReporHTML").empty(); // Limpia el contenido HTML
        }
    });

   
    async function  valdiarReportes(input, content) {
        $(document).on("change", input, function () {
            if (!$(this).is(":checked")) {
                // Si reportePersonalizado se desmarca, desmarca todos los demás checkboxes
                $("#contentReport .report-checkbox").not("#reportePersonalizado").prop("checked", false);
                $(content).remove(); // Limpia el contenido HTML
            }
        });
    }
   
    valdiarReportes("#reporteSexo","#contentSexo")
    valdiarReportes("#reporteEdad","#contentEdad")
    valdiarReportes("#reporteParentesco","#contentParentesco")
    valdiarReportes("#reporteDiscapacidad","#contentDiscapacidad")
    valdiarReportes("#reporteFecha","#contentFechaRango1")



});