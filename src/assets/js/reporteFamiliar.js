import { AlertSW2 } from "./ajax/alerts.js";
import { descargarArchivo } from "./ajax/formularioAjax.js";
import {
    incluirSelec2,
    validarSelectoresSelec2,
    validarNumeroNumber,
    validarInputFecha,
    fechasJQueyDataPikerPresente,
} from "./ajax/inputs.js";

import { 
    setCargarDiscapacidad, 
    setCargarParentesco, 
    setCargarSexo 
} from "./ajax/variablesArray.js";

import {
    setVariableDiscapacidad,
    setVariableEdad,
    setVariableFechaRango,
    setVariableParentesco,
    setVariableSexo
} from "./ajax/variablesContenido.js";

$(function () {
    //CARGAR LOS SELECTORES
    validarSelectoresSelec2("#sexo_filtrar", ".span_sexo_filtrar");
    validarSelectoresSelec2("#tpDiscapacidad2", ".span_tpDiscapacidad2");
    validarSelectoresSelec2("#parentesco2", ".span_parentesco2");
    validarInputFecha("#fecha_filtrar", ".span_fecha_filtrar")
    validarInputFecha("#fecha_fin_filtrar", ".span_fecha_fin_filtrar")
    validarNumeroNumber("#edad_filtrar", ".span_edad_filtrar", 2);

    $("#descargarReporte2").prop("disable", true);

    //SOLICITUD DE REPORTE DE FAMILIAR
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
            // Verifica si el checkbox 'reportePersonalizado' NO está marcado

            if (!$("#reportePersonalizado").is(":checked")) {
                // Si 'reportePersonalizado' no está marcado, desmarca los otros checkboxes
                $("#contentReport .report-checkbox").not(this).prop("checked", false);
                $("#contentReporHTML").empty();
            }
            if (checkboxId == 'reporteSexo') {
                $("#contentReporHTML").append(setVariableSexo("sexo_filtrar", "sexo"));
                setCargarSexo("#sexo_filtrar");
                incluirSelec2("#sexo_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar_sexualidad');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarSexo");
                }
            } else if (checkboxId == "reporteEdad") {
                $("#contentReporHTML").append(setVariableEdad("edad_filtrar", "edad"));
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-edad');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarEdad");
                }
            } else if (checkboxId == "reporteDiscapacidad") {
                $("#contentReporHTML").append(setVariableDiscapacidad("tpDiscapacidad2", "tpDiscapacidad"));
                setCargarDiscapacidad("#tpDiscapacidad2");
                incluirSelec2("#tpDiscapacidad2");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'Familiar-discapacidad');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarDiscapacidad");
                }
            } else if (checkboxId == "reporteParentesco") {
                $("#contentReporHTML").append(setVariableParentesco("parentesco2", "parentesco"));
                setCargarParentesco("#parentesco2");
                incluirSelec2("#parentesco2");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-parentesco');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarParentesco");
                }
            } else if (checkboxId == "reporteFecha") {
                $("#contentReporHTML").append(setVariableFechaRango("fecha_filtrar", "fecha_fin_filtrar", "fecha_fin_filtrar", "fecha_fin_filtrar"));
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-rangoFecha');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarRangoFecha");
                }
                fechasJQueyDataPikerPresente("#fecha_filtrar"); // Inicializa los datepickers
                fechasJQueyDataPikerPresente("#fecha_fin_filtrar"); // Inicializa los datepickers
            } else if (checkboxId == "reportePersonalizado") {
                $('#formulario-descargarpdf').data('nombre', 'familiar-personalizado');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarPersonalizado");
            } else if (checkboxId == "reporteExcelSexo") {
                $("#contentReporHTML").append(setVariableSexo("sexo_filtrar", "sexo"));
                setCargarSexo("#sexo_filtrar");
                incluirSelec2("#sexo_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-sexualidadExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarSexoExcel");
                }
            } else if (checkboxId == 'reporteExcelDiscapacidad') {
                $("#contentReporHTML").append(setVariableDiscapacidad("tpDiscapacidad2", "tpDiscapacidad"));
                setCargarDiscapacidad("#tpDiscapacidad2");
                incluirSelec2("#tpDiscapacidad2");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-discapacidadExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarDiscapacidadExcel");
                }
            } else if (checkboxId == "reporteExcelEdad") {
                $("#contentReporHTML").append(setVariableEdad("edad_filtrar", "edad"));
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-edadExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarEdadExcel");
                }
            } else if (checkboxId == "reporteExcelParentesco") {
                $("#contentReporHTML").append(setVariableParentesco("parentesco2", "parentesco"));
                setCargarParentesco("#parentesco2");
                incluirSelec2("#parentesco2");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-parentescoExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarParentescoExcel");
                }
            } else if (checkboxId == "reporteExcelFecha") {
                $("#contentReporHTML").append(setVariableFechaRango("fecha_filtrar", "fecha_fin_filtrar", "fecha_fin_filtrar", "fecha_fin_filtrar"));
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'familiar-rangoFechaExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirFamiliarRangoFechaExcel");
                }
                fechasJQueyDataPikerPresente("#fecha_filtrar"); // Inicializa los datepickers
                fechasJQueyDataPikerPresente("#fecha_fin_filtrar"); // Inicializa los datepickers
            }
        }
    });

    // Evento change específico para reportePersonalizado
    $(document).on("change", "#reportePersonalizado", function () {
        if (!$(this).is(":checked")) {
            console.log("reporte personalizado activo")
            // Si reportePersonalizado se desmarca, desmarca todos los demás checkboxes
            $("#contentReport .report-checkbox").not("#reportePersonalizado").prop("checked", false);
            $("#formulario-descargarpdf").attr("action", "#");
            $('#formulario-descargarpdf').data('nombre', '');
            $("#contentReporHTML").empty(); // Limpia el contenido HTML
        }
    });

    //validar para borrar el contenido
    async function valdiarReportes(input, content) {
        $(document).on("change", input, function () {
            if (!$(this).is(":checked")) {
                // Si reportePersonalizado no está marcado, desmarca todos los demás checkboxes
                if (!$("#reportePersonalizado").is(":checked")) {
                    $("#contentReport .report-checkbox").not("#reportePersonalizado").prop("checked", false);
                }
                $(content).remove(); // Limpia el contenido HTML específico
            }
        });
    }

    //validar reprotes pdf
    valdiarReportes("#reporteSexo", "#contentSexo");
    valdiarReportes("#reporteEdad", "#contentEdad");
    valdiarReportes("#reporteParentesco", "#contentParentesco");
    valdiarReportes("#reporteDiscapacidad", "#contentDiscapacidad");
    valdiarReportes("#reporteFecha", "#contentFechaRango1");

    // validar reportes excel
    valdiarReportes("#reporteExcelSexo", "#contentSexo");
    valdiarReportes("#reporteExcelEdad", "#contentEdad");
    valdiarReportes("#reporteExcelParentesco", "#contentParentesco");
    valdiarReportes("#reporteExcelDiscapacidad", "#contentDiscapacidad");
    valdiarReportes("#reporteExcelFecha", "#contentFechaRango1");

});