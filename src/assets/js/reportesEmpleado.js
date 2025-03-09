import { alertaNormalmix, AlertSW2, aletaCheck } from "./ajax/alerts.js";
import { descargarArchivo, enviarFormulario, obtenerDatos, obtenerDatosJQuery, obtenerDatosPromise } from "./ajax/formularioAjax.js";
import {
    colocarMeses,
    colocarYear,
    valdiarCorreos,
    validarNombre,
    validarNumeros,
    validarSelectores,
    validarTelefono,
    file,
    limpiarInput,
    colocarNivelesEducativos,
    clasesInputs,
    incluirSelec2,
    validarSelectoresSelec2,
    validarNumerosMenores,
    validarNombreConEspacios,
    validarNumeroNumber,
    validarDosDatos,
    validarInputFecha,
    mesesDias,
    configurarInactividad,
} from "./ajax/inputs.js";

$(function () {
    $("#datosReporte").removeAttr("hidden");
    $("#datosReporte").hide();

    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '< Ant',
        nextText: 'Sig >',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['es']);

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

    async function traerCargo() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerCargo", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    async function traerEstatus() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    async function traerEstados() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerEstados", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    async function traerDependencia() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    async function traerDepartamento() {
        const resultado = await obtenerDatos("src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento", "POST");
        return resultado.response; // Devuelve solo la respuesta (el objeto data)
    }

    $(document).on("change", "#contentReport .report-checkbox", function () {
        if ($(this).is(":checked")) {
            var checkboxId = $(this).attr("id"); // Obtiene el ID del checkbox
            console.log("Checkbox seleccionado: " + checkboxId); // Muestra el ID en la consola
            $("#contentReport .report-checkbox").not(this).prop("checked", false);

            if (checkboxId == 'reporteSexo') {
                $("#contentReporHTML").html(
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
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_sexualidad');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosSexo");
            } else if (checkboxId == 'reporteCargo') {

                $("#contentReporHTML").html(
                    `
                      <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="form-group">
                          <label for="cargo_filtrar">cargo</label>
                          <div class="input-group">
                            <span class="input-group-text span_cargo_filtrar"><i class="icons fa-duotone fa-regular fa-arrows-down-to-people"></i></span>
                            <select class="form-select form-select-md" id="cargo_filtrar" name="cargo_filtrar">
                              <option value="">Selecione un cargo</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    `,

                );
                traerCargo()
                    .then(cargo => {
                        llenarSelect(cargo.data, "cargo_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el cargo:", error);
                    });
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_cargo');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosCargo");
                incluirSelec2("#cargo_filtrar");
            } else if (checkboxId == "reporteEdad") {

                $("#contentReporHTML").html(
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
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_edad');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosEdad");
            } else if (checkboxId == "reporteEstatus") {

                $("#contentReporHTML").html(
                    `
                      <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="estatus_filtrar">Estatus</label>
                                <div class="input-group">
                                    <span class="input-group-text span_estatus_filtrar"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-estatus_filtrar" id="estatus_filtrar" name="estatus_filtrar" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione un estatus</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    `,

                );
                traerEstatus()
                    .then(estatus => {
                        llenarSelect(estatus.data, "estatus_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_estatus');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosEstatus");
                incluirSelec2("#estatus_filtrar");

            } else if (checkboxId == "reporteEstadoCivil") {

                $("#contentReporHTML").html(
                    `
                      <div class="col-sm-6 col-md-6 mb-2">
                        <div class="form-group">
                            <label for="civil_filtrar">Estado civil</label>
                            <div class="input-group">
                                <span class="input-group-text span_civil_filtrar"><i class="icons fa-regular fa-clipboard"></i></span>
                                <select class="form-select form-select-md estado-civil_filtrar" id="civil_filtrar" name="civil_filtrar" aria-label="Small select example" aria-placeholder="dasdas" required>
                                    <option value="">Estado civil</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Viudo">Viudo</option>
                                    <option value="Divorciado">Divorciado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    `,

                );
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_estadoCivil');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosCivil");
                incluirSelec2("#civil_filtrar");
            } else if (checkboxId == "reporteVivienda") {

                $("#contentReporHTML").html(
                    `
                      <div class="col-sm-6 col-md-6 mb-2">
                        <div class="form-group">
                            <label for="vivienda_filtrar">Vivienda</label>
                            <div class="input-group">
                                <span class="input-group-text span_vivienda_filtrar"><i class="icons fa-regular fa-house-building"></i></span>
                                <select class="form-select form-select-md vivienda_filtrar" id="vivienda_filtrar" name="vivienda_filtrar" aria-label="Small select example" aria-placeholder="dasdas" required>
                                    <option value="">Selecione un vivienda</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Departamento">Departamento</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    `,

                );
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_vivienda');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosVivienda");
                incluirSelec2("#vivienda_filtrar");
            } else if (checkboxId == "reporteNivelAcademico") {

                $("#contentReporHTML").html(
                    `
                      <div class="col-sm-6 col-md-6 mb-2">
                        <div class="form-group">
                            <label for="academico_filtrar">Nivel Academico</label>
                            <div class="input-group">
                                <span class="input-group-text span_academico_filtrar"><i class="icons fa-regular fa-user-graduate"></i></span>
                                <select class="form-select form-select-md" id="academico_filtrar" name="nivelacademico_filtrar">
                                    <option value="">Nivel Academico</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    `,

                );
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_nivelAcademico');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosAcademico");
                colocarNivelesEducativos("#academico_filtrar");
                incluirSelec2("#academico_filtrar");

            } else if (checkboxId == "reporteDireccion") {

                $("#contentReporHTML").html(
                    `
                      <div class="col-sm-6 col-md-3 mb-2">
                        <div class="form-group">
                            <label for="estado_filtrar">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text span_estado_filtrar"><i class="icons fa-regular fa-clipboard"></i></span>
                                <select class="form-select form-select-md estado_filtrar-estado_filtrar" id="estado_filtrar" name="estado_filtrar" aria-label="Small select example" aria-placeholder="dasdas" required>
                                    <option value="">Selecione un estado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 mb-2">
                        <div class="form-group">
                            <label for="municipio_filtrar">Municipio</label>
                            <div class="input-group">
                                <span class="input-group-text span_municipio_filtrar"><i class="icons fa-regular fa-clipboard"></i></span>
                                <select class="form-select form-select-md municipio_filtrar-municipio_filtrar" id="municipio_filtrar" name="municipio_filtrar" aria-label="Small select example" aria-placeholder="dasdas" required>
                                    <option value="">Seleccione un municipio</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 mb-2">
                        <div class="form-group">
                            <label for="parroquia_filtrar">Parroquia</label>
                            <div class="input-group">
                                <span class="input-group-text span_parroquia_filtrar"><i class="icons fa-regular fa-clipboard"></i></span>
                                <select class="form-select form-select-md parroquia_filtrar-parroquia_filtrar" id="parroquia_filtrar" name="parroquia_filtrar" aria-label="Small select example" aria-placeholder="dasdas" required>
                                    <option value="">Selecione un parroquia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    `,

                );
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_direccion');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDireccion");
                traerEstados()
                    .then(EtraerEstados => {
                        llenarSelect(EtraerEstados.data, "estado_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el EtraerEstados:", error);
                    });

                incluirSelec2("#estado_filtrar");
                incluirSelec2("#municipio_filtrar");
                incluirSelec2("#parroquia_filtrar");
            } else if (checkboxId == "reporteFecha") {

                $("#contentReporHTML").html(
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
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_rangoFecha');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosRangoFecha");
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
            } else if (checkboxId == "reporteDependencia") {
                $("#contentReporHTML").html(
                    `
                      <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="dependencia_filtrar">Dependencia 22</label>
                                <div class="input-group">
                                    <span class="input-group-text span_dependencia_filtrar"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-dependencia_filtrar" id="dependencia_filtrar" name="dependencia_filtrar" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione una dependencia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    `,

                );
                traerDependencia()
                    .then(dependencia => {
                        llenarSelect(dependencia.data, "dependencia_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_dependencia');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDependencia");
                incluirSelec2("#dependencia_filtrar");

            } else if (checkboxId == "reporteDepartamento") {

                $("#contentReporHTML").html(
                    `
                      <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="departamento_filtrar">Departamento</label>
                                <div class="input-group">
                                    <span class="input-group-text span_departamento_filtrar"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-departamento_filtrar" id="departamento_filtrar" name="departamento_filtrar" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione un departamento</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    `,

                );
                traerDepartamento()
                    .then(departamento => {
                        llenarSelect(departamento.data, "departamento_filtrar");
                    })
                    .catch(error => {
                        console.error("Error al obtener el estatus:", error);
                    });
                $('#formulario-descargarpdf').data('nombre', 'reporte_empleado_departamento');
                $("#formulario-descargarpdf").attr("action", "./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosDepartamento");
                incluirSelec2("#departamento_filtrar");
            } else if(checkboxId == ''){
                
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

        // Usar el atributo 'action' en la función descargarArchivo
        await descargarArchivo(formAction, nombreReporte, data);
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

})


