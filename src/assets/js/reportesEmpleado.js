import { AlertSW2 } from "./ajax/alerts.js";

import { 
    descargarArchivo, 
    obtenerDatos, 
    obtenerDatosJQuery 
} from "./ajax/formularioAjax.js";

import {
    incluirSelec2,
    validarSelectoresSelec2,
    validarNumeroNumber,
    validarInputFecha,
    fechasJQueyDataPikerPresente,
} from "./ajax/inputs.js";

import { 
    setCargarDiscapacidad, 
    setCargarEstadoCivil, 
    setCargarNivelesAcademicos, 
    setCargarSexo, 
    setCargarTipoVivienda 
} from "./ajax/variablesArray.js";

import {
    setVariableAcademico,
    setVariableCargo,
    setVariableCivil,
    setVariableDepartamento,
    setVariableDependencia,
    setVariableDiscapacidad,
    setVariableEdad,
    setVariableEstado,
    setVariableEstatus,
    setVariableFechaRango,
    setVariableMunicipio,
    setVariableParroquia,
    setVariableSexo,
    setVariableVivienda
} from "./ajax/variablesContenido.js";
$(function () {
    $("#datosReporte").removeAttr("hidden");
    $("#datosReporte").hide();

    validarSelectoresSelec2("#sexo_filtrar", ".span_sexo_filtrar");
    validarSelectoresSelec2("#cargo_filtrar", ".span_cargo_filtrar");
    validarSelectoresSelec2("#estatus_filtrar", ".span_estatus_filtrar");
    validarSelectoresSelec2("#civil_filtrar", ".span_civil_filtrar");
    validarSelectoresSelec2("#vivienda_filtrar", ".span_vivienda_filtrar");
    validarSelectoresSelec2("#academico_filtrar", ".span_academico_filtrar");
    validarSelectoresSelec2("#estado_filtrar", ".span_estado_filtrar");
    validarSelectoresSelec2("#municipio_filtrar", ".span_municipio_filtrar");
    validarSelectoresSelec2("#parroquia_filtrar", ".span_parroquia_filtrar");
    validarSelectoresSelec2("#dependencia_filtrar", ".span_dependencia_filtrar");
    validarSelectoresSelec2("#departamento_filtrar", ".span_departamento_filtrar");

    validarInputFecha("#fechaing_filtrar", ".span_fechaing_filtrar")
    validarInputFecha("#fecha_filtrar", ".span_fecha_filtrar")
    validarInputFecha("#fecha_fin_filtrar", ".span_fecha_fin_filtrar")

    validarNumeroNumber("#edad_filtrar", ".span_edad_filtrar", 2);
    //solicitud para traer el html de los reporte
    $(document).on("click", '.reporteTrabajador', async function (event) {
        event.preventDefault();
        const href = $(this).attr('href');

        $.ajax({
            url: './src/views/personal/reporte.php',
            type: 'GET',
            dataType: 'html',
            data: { tipo: href }, // O 'excel'
            beforeSend: function () {
                AlertSW2("info", "Cargando datos del reporte...", "top",); // Cambié "error" a "info" para mayor claridad
            },
            success: function (html) {
                Swal.close(); // Cierra la alerta SweetAlert2
                $('#contentBodyCard').html(html);
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

                    });
                });
            },
            error: async function (error) {
                Swal.close(); // Cierra la alerta SweetAlert2
                console.error('Error al cargar el contenido:', error);
                await AlertSW2("error", "Error al cargar el reporte", "top", 5000); // Muestra un mensaje de error
            }
        });



    })

    // cerrar el card de reporte
    $(document).on('click', '#cerrarReport', function () {
        $('#datosReporte').slideUp(800, function () {

            // Animación de desplazamiento al narvarPrincipal después del cierre
            $('html, body').animate({
                scrollTop: $('#narvarPrincipal')[0].scrollIntoView({ behavior: 'smooth' })
            }, 3000);
            $("#contentReport").remove();

            // Aquí puedes agregar cualquier otra lógica que necesites después del cierre
        });


    });

    $(document).on("change", "#fecha_fin_filtrar, #fecha_filtrar", function () {
        let fechaInic = $("#fecha_filtrar").val();
        let fechaFin = $("#fecha_fin_filtrar").val();

        console.log(fechaInic)
        console.log(fechaFin)

        if (fechaInic >= fechaFin) {

            $("#descargarReporte2").prop("disabled", true);
        } else {
            $("#descargarReporte2").prop("disabled", false);
        }

    })

    // llenar selectores
    async function llenarSelect(data, selectId) {
        const select = document.getElementById(selectId);
        // Asegúrate de que el ID del select sea correcto
        if (!select) {
            console.error(`El elemento select con el ID "${selectId}" no se encontró en el DOM.`);
            return;
        }

        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.text = item.value;
            select.appendChild(option);
        });
    }

    // solicitud de buscar cargos
    async function traerCargo() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerCargo", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    // solicitud de buscar estatus
    async function traerEstatus() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    // solicitud de buscar estados
    async function traerEstados() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerEstados", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    // solicitud de buscar dependencia
    async function traerDependencia() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    // solicitud de buscar departamento
    async function traerDepartamento() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    // Evento change específico para los checkboxes de reportes
    $(document).on("change", "#contentReport .report-checkbox", async function () {
        if ($(this).is(":checked")) {
            var checkboxId = $(this).attr("id"); // Obtiene el ID del checkbox
            console.log("Checkbox seleccionado: " + checkboxId); // Muestra el ID en la consola
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
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_sexualidad');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosSexo");
                }
            } else if (checkboxId == 'reporteCargo') {
                $("#contentReporHTML").append(setVariableCargo("cargo_filtrar", "cargo"));
                traerCargo()
                    .then(cargo => {
                        llenarSelect(cargo.data, "cargo_filtrar");
                        incluirSelec2("#cargo_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el cargo:", error);
                    });
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_cargo');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosCargo");
                }
            } else if (checkboxId == "reporteEdad") {
                $("#contentReporHTML").append(setVariableEdad("edad_filtrar", "edad"));
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_edad');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosEdad");
                }
            } else if (checkboxId == "reporteEstatus") {
                $("#contentReporHTML").append(setVariableEstatus("estatus_filtrar", "estatus"));
                traerEstatus()
                    .then(estatus => {
                        llenarSelect(estatus.data, "estatus_filtrar");
                        incluirSelec2("#estatus_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_estatus');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosEstatus")
                }
                ;
            } else if (checkboxId == "reporteEstadoCivil") {
                $("#contentReporHTML").append(setVariableCivil("civil_filtrar", "civil"));
                setCargarEstadoCivil("#civil_filtrar");
                incluirSelec2("#civil_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_estadoCivil');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosCivil");
                }

            } else if (checkboxId == "reporteVivienda") {
                $("#contentReporHTML").append(setVariableVivienda("vivienda_filtrar", "vivienda"));
                setCargarTipoVivienda("#vivienda_filtrar");
                incluirSelec2("#vivienda_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_vivienda');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosVivienda");
                }
            } else if (checkboxId == "reporteNivelAcademico") {
                $("#contentReporHTML").append(setVariableAcademico("academico_filtrar", "academico"));
                setCargarNivelesAcademicos("#academico_filtrar");
                incluirSelec2("#academico_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_nivelAcademico');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosAcademico");
                }
            } else if (checkboxId == "reporteDireccion") {
                $("#contentReporHTML").append(setVariableEstado("estado_filtrar", "estado"), setVariableMunicipio("municipio_filtrar", "municipio"), setVariableParroquia("parroquia_filtrar", "parroquia"));
                traerEstados()
                    .then(EtraerEstados => {
                        llenarSelect(EtraerEstados.data, "estado_filtrar");
                        incluirSelec2("#estado_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el EtraerEstados:", error);
                    });
                incluirSelec2("#municipio_filtrar");
                incluirSelec2("#parroquia_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_direccion');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDireccion");
                }
            } else if (checkboxId == "reporteFecha") {
                $("#contentReporHTML").append(setVariableFechaRango("fecha_filtrar", "fecha_fin_filtrar", "fecha_fin_filtrar", "fecha_fin_filtrar"));
                fechasJQueyDataPikerPresente("#fecha_filtrar"); // Inicializa los datepickers
                fechasJQueyDataPikerPresente("#fecha_fin_filtrar"); // Inicializa los datepickers
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_rangoFecha');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosRangoFecha");
                }
            } else if (checkboxId == "reporteDependencia") {
                $("#contentReporHTML").append(setVariableDependencia("dependencia_filtrar", "dependencia"));
                traerDependencia()
                    .then(dependencia => {
                        llenarSelect(dependencia.data, "dependencia_filtrar");
                        incluirSelec2("#dependencia_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_dependencia');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDependencia")
                }
                ;
            } else if (checkboxId == "reporteDepartamento") {
                $("#contentReporHTML").append(setVariableDepartamento("departamento_filtrar", "departamento"));
                traerDepartamento()
                    .then(departamento => {
                        llenarSelect(departamento.data, "departamento_filtrar");
                        incluirSelec2("#departamento_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_departamento');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDepartamento");
                }

            } else if (checkboxId == "reporteExcelSexo") {
                $("#contentReporHTML").append(setVariableSexo("sexo_filtrar", "sexo"));
                setCargarSexo("#sexo_filtrar");
                incluirSelec2("#sexo_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_sexualidadExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosSexoExcel");
                }

            } else if (checkboxId == "reporteExcelCargo") {
                $("#contentReporHTML").append(setVariableCargo("cargo_filtrar", "cargo"));
                traerCargo()
                    .then(cargo => {
                        llenarSelect(cargo.data, "cargo_filtrar");
                        incluirSelec2("#cargo_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el cargo:", error);
                    });
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_cargoExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosCargoExcel");
                }
            } else if (checkboxId == "reporteExcelEdad") {
                $("#contentReporHTML").append(setVariableEdad("edad_filtrar", "edad"));
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_edadExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosEdadExcel");
                }
            } else if (checkboxId == "reporteExcelEstatus") {
                $("#contentReporHTML").append(setVariableEstatus("estatus_filtrar", "estatus"));
                traerEstatus()
                    .then(estatus => {
                        llenarSelect(estatus.data, "estatus_filtrar");
                        incluirSelec2("#estatus_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_estatusExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosEstatusExcel")
                }
                ;
            } else if (checkboxId == "reporteExcelEstadoCivil") {
                $("#contentReporHTML").append(setVariableCivil("civil_filtrar", "civil"));
                setCargarEstadoCivil("#civil_filtrar");
                incluirSelec2("#civil_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_estadoCivilExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosCivilExcel");
                }

            } else if (checkboxId == "reporteExcelVivienda") {
                $("#contentReporHTML").append(setVariableVivienda("vivienda_filtrar", "vivienda"));
                setCargarTipoVivienda("#vivienda_filtrar");
                incluirSelec2("#vivienda_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_viviendaExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosViviendaExcel");
                }
            } else if (checkboxId == "reporteExcelNivelAcademico") {
                $("#contentReporHTML").append(setVariableAcademico("academico_filtrar", "academico"));
                setCargarNivelesAcademicos("#academico_filtrar");
                incluirSelec2("#academico_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_nivelAcademicoExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosAcademicoExcel");
                }
            } else if (checkboxId == "reporteExcelDireccion") {
                $("#contentReporHTML").append(setVariableEstado("estado_filtrar", "estado"), setVariableMunicipio("municipio_filtrar", "municipio"), setVariableParroquia("parroquia_filtrar", "parroquia"));
                traerEstados()
                    .then(EtraerEstados => {
                        llenarSelect(EtraerEstados.data, "estado_filtrar");
                        incluirSelec2("#estado_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el EtraerEstados:", error);
                    });
                incluirSelec2("#municipio_filtrar");
                incluirSelec2("#parroquia_filtrar");
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_direccionExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDireccionExcel");
                }
            } else if (checkboxId == "reporteExcelFecha") {
                $("#contentReporHTML").append(setVariableFechaRango("fecha_filtrar", "fecha_fin_filtrar", "fecha_fin_filtrar", "fecha_fin_filtrar"));
                fechasJQueyDataPikerPresente("#fecha_filtrar"); // Inicializa los datepickers
                fechasJQueyDataPikerPresente("#fecha_fin_filtrar"); // Inicializa los datepickers
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_rangoFechaExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosRangoFechaExcel");
                }
            } else if (checkboxId == "reporteExcelDependencia") {
                $("#contentReporHTML").append(setVariableDependencia("dependencia_filtrar", "dependencia"));
                traerDependencia()
                    .then(dependencia => {
                        llenarSelect(dependencia.data, "dependencia_filtrar");
                        incluirSelec2("#dependencia_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_dependenciaExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDependenciaExcel")
                }
                ;
            } else if (checkboxId == "reporteExcelDepartamento") {
                $("#contentReporHTML").append(setVariableDepartamento("departamento_filtrar", "departamento"));
                traerDepartamento()
                    .then(departamento => {
                        llenarSelect(departamento.data, "departamento_filtrar");
                        incluirSelec2("#departamento_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                if (!$("#reportePersonalizado").is(":checked")) {
                    $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_departamentoExcel');
                    $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDepartamentoExcel");
                }

            }
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

    //buscar municipios por medio de los estados
    $(document).on("change", "#estado_filtrar", async function () {
        const idEstado = $(this).val();
        try {
            if (idEstado !== undefined) {
                try {
                    let urls = ["src/ajax/registroPersonal.php?modulo_personal=obtenerMunicipio"];
                    let options = { idestado: idEstado };
                    let requests = urls.map((url, index) => {
                        if (index === 0) { // Suponiendo que quieres pasar `options` solo a la primera solicitud
                            return obtenerDatosJQuery(url, options);
                        }
                    });

                    const [municipio] = await Promise.all(requests);

                    if (municipio.exito) {
                        $("#municipio_filtrar").empty()
                        $("#municipio_filtrar").append('<option value="">Seleccione un municipio</option>');
                        llenarSelect(municipio.data, 'municipio_filtrar');
                    } else {
                        console.error('Error al obtener estado o la estructura de la respuesta es incorrecta');
                    }
                } catch (error) {
                    console.error('Error al obtener los datos de la estado:', error);
                }
            } else {
                console.error('El idestado es undefined');
            }
        } catch (error) {
            console.error('Error al manejar el evento de clic:', error);
        }
    });

    //buscar parroquias por medio del municipio
    $(document).on("change", "#municipio_filtrar", async function () {
        const idmunicipio = $(this).val();
        try {
            if (idmunicipio !== undefined) {
                try {
                    let urls = ["src/ajax/registroPersonal.php?modulo_personal=obtenerParroquia",];
                    let options = { idmunicipio: idmunicipio };
                    let requests = urls.map((url, index) => {
                        if (index === 0) { // Suponiendo que quieres pasar `options` solo a la primera solicitud
                            return obtenerDatosJQuery(url, options);
                        }
                    });

                    const [parroquia] = await Promise.all(requests);

                    if (parroquia.exito) {
                        $("#parroquia_filtrar").empty()
                        $("#parroquia_filtrar").append('<option value="">Seleccione una parroquia</option>');
                        llenarSelect(parroquia.data, 'parroquia_filtrar');
                    } else {
                        console.error('Error al obtener parroquias o la estructura de la respuesta es incorrecta');
                    }
                } catch (error) {
                    console.error('Error al obtener los datos de la parroquia:', error);
                }
            } else {
                console.error('El idparroquia es undefined');
            }
        } catch (error) {
            console.error('Error al manejar el evento de clic:', error);
        }
    });

    // Evento change específico para reportePersonalizado
    $(document).on("change", "#reportePersonalizado", async function () {
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
    // validar reportes pdf
    valdiarReportes("#reporteSexo", "#contentSexo");
    valdiarReportes("#reporteCargo", "#contentCargo");
    valdiarReportes("#reporteEstatus", "#contentEstatus");
    valdiarReportes("#reporteEstadoCivil", "#contentEstadoCivil");
    valdiarReportes("#reporteVivienda", "#contentVivienda");
    valdiarReportes("#reporteNivelAcademico", "#contentNivelAcademico");
    valdiarReportes("#reporteDireccion", "#contentEstado");
    valdiarReportes("#reporteDireccion", "#contentMunicipio");
    valdiarReportes("#reporteDireccion", "#contentParroquia");
    valdiarReportes("#reporteDependencia", "#contentDependencia");
    valdiarReportes("#reporteDepartamento", "#contentDepartamento");
    valdiarReportes("#reporteEdad", "#contentEdad");
    valdiarReportes("#reporteDiscapacidad", "#contentDiscapacidad");
    valdiarReportes("#reporteFecha", "#contentFechaRango1");
    // validar reportes excel
    valdiarReportes("#reporteExcelSexo", "#contentSexo");
    valdiarReportes("#reporteExcelCargo", "#contentCargo");
    valdiarReportes("#reporteExcelEstatus", "#contentEstatus");
    valdiarReportes("#reporteExcelEstadoCivil", "#contentEstadoCivil");
    valdiarReportes("#reporteExcelVivienda", "#contentVivienda");
    valdiarReportes("#reporteExcelNivelAcademico", "#contentNivelAcademico");
    valdiarReportes("#reporteExcelDireccion", "#contentEstado");
    valdiarReportes("#reporteExcelDireccion", "#contentMunicipio");
    valdiarReportes("#reporteExcelDireccion", "#contentParroquia");
    valdiarReportes("#reporteExcelDependencia", "#contentDependencia");
    valdiarReportes("#reporteExcelDepartamento", "#contentDepartamento");
    valdiarReportes("#reporteExcelEdad", "#contentEdad");
    valdiarReportes("#reporteExcelDiscapacidad", "#contentDiscapacidad");
    valdiarReportes("#reporteExcelFecha", "#contentFechaRango1");

})
//788