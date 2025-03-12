import { enviarFormulario, obtenerDatosJQuery } from './ajax/formularioAjax.js';
import { validarNombre, incluirSelec2, validarSelectoresSelec2, soloNumeros, validarNombreConEspacios } from './ajax/inputs.js';
import { alertaNormalmix, AlertSW2, aletaCheck } from './ajax/alerts.js';

$(function () {
    const btnDependencia = document.querySelector('#btnAgregarDependencia');
    const btnCargo = document.querySelector('#btnAgregarCargo');
    const btnEstatus = document.querySelector('#btnAgregarEstatus');
    const btnDepartamento = document.querySelector('#btnAgregarDepartamento');
    const btnSinCodigo = document.querySelector('#sinCodigo');
    // VARIBLES DE MODAL
    const bodyModal = document.querySelector('.section-body');
    const titleModal = document.querySelector('.modal-title');
    const contenButton = document.querySelector('.modal-footer');

    var boton = $('#aceptar');

    $('#btnAgregarDependencia').hide();
    $('#btnAgregarCargo').hide();
    $('#btnAgregarEstatus').hide();
    $('#btnAgregarDepartamento').hide();

    validarNombreConEspacios("#dependencia", ".span_dependencia");
    incluirSelec2("#estado", ".span_estado");
    validarSelectoresSelec2("#estado", ".span_estado");
    soloNumeros("#codigo", ".span_codigo");

    validarNombreConEspacios("#cargo", ".span_cargo");
    validarNombreConEspacios("#estatus", ".span_estatus");
    validarNombreConEspacios("#departamento", ".span_departamento");

    // Configuración base para DataTables
    const baseConfig = {
        responsive: true,
        processing: false,
        serverSide: false, // Asegúrate de que esto esté configurado si estás usando procesamiento del lado del servidor
        info: false,
        paging: true,
        lengthMenu: [2, 10, 25],
        pageLength: 10,
        language: {
            url: "./IdiomaEspañol.json"
        }
    };

    let tableInic = $('#tableInic').DataTable(baseConfig);

    // Función para cambiar la URL del AJAX y recargar la tabla con nuevas columnas
    function recargarTabla(newConfig, nuevosTextos) {
        tableInic.clear().destroy(); // Limpiar y destruir la tabla existente
        const $thead = $('#tableInic thead');
        $thead.empty(); // Limpiar el contenido existente del thead

        // Crear una nueva fila para los encabezados
        const $fila = $('<tr>').addClass('tr-identity');

        // Crear y agregar las nuevas celdas a la fila
        nuevosTextos.forEach(texto => {
            const $celda = $('<th style="font-size: 14px;">').text(texto).addClass('bg-primary text-white ');
            // console.log(`Añadiendo celda con texto: ${texto}`); // Depuración
            $fila.append($celda);
        });

        // Agregar la fila al thead
        $thead.append($fila);

        tableInic = $('#tableInic').DataTable(newConfig); // Inicializar una nueva instancia con la nueva configuración
    }

    //CAMBIAR LOS TEXTOS DE LA CELDAS DINAMICAMENTE
    function cambiarTextoCeldas(nuevosTextos) {
        const $thead = $('#tableInic thead');
        let $fila = $thead.find('.tr-identity');

        if ($fila.length === 0) {
            // Crear el elemento tr-identity si no existe
            $fila = $('<tr>').addClass('tr-identity');
            $thead.append($fila);
        }

        // Limpiamos todas las celdas existentes en la fila
        $fila.empty();

        // Creamos las nuevas celdas y las agregamos a la fila
        nuevosTextos.forEach(texto => {
            const $celda = $('<th>').text(texto).addClass('bg-primary text-white');
            // console.log(`Añadiendo celda con texto: ${texto}`); // Depuración
            $fila.append($celda);
        });

        // console.log($fila.html());  Depuración: Verificar el contenido de la fila
        // console.log($thead.html());  Depuración: Verificar el contenido del thead
        return true;
    }

    // Función para alternar la visibilidad de los botones
    function toggleButtons(showButton, hideButtons) {
        return new Promise((resolve) => {
            $(showButton).slideDown(() => {
                hideButtons.forEach(button => {
                    $(button).slideUp();
                });
                resolve();
            });
        });
    }

    // Ejemplo de uso de las funciones
    $('#switchDepe').on('click', async () => {
        await toggleButtons('#btnAgregarDependencia', ['#btnAgregarCargo', '#btnAgregarEstatus', '#btnAgregarDepartamento']);
        const columnasDepe = [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            // Agrega más columnas según sea necesario
        ];
        const nuevosTextos = ['Dependencia', 'Activo', 'Estado', 'Codigo', 'Acciones'];
        if (cambiarTextoCeldas(nuevosTextos)) {
            const newConfig = $.extend(true, {}, baseConfig, {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "src/ajax/datosDecd.php?modulo_datos=obtenerDatosDepe",
                    type: "POST",
                    dataSrc: function (json) {
                        // Verificar la estructura de los datos devueltos
                        if (json.data) {
                            // console.log(json.data);
                            return json.data; // Acceder al array de datos dentro de 'data'
                        } else {
                            console.error('Estructura de datos incorrecta:', json);
                            return [];
                        }
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        width: "25%",
                    },
                    {
                        targets: 1,
                        width: "10%",
                        render: function (data, type, row) {
                            let dataTexto = data;
                            const dataTextoMap = {
                                1: "Activo",
                                0: "Inactivo",
                            };

                            if (dataTextoMap[dataTexto] == 'Activo') {
                                dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                            } else {
                                dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                            }
                            return dataTexto
                        }
                    },
                    {
                        targets: 2,
                        width: "20%",
                    },
                    {
                        targets: 3,
                        width: "20%",
                    },
                    {
                        targets: 4,
                        width: "25%",
                    }
                ],
                columns: columnasDepe
            });
            recargarTabla(newConfig, nuevosTextos);
        }
    });

    $('#switchCargo').on('click', async () => {
        await toggleButtons('#btnAgregarCargo', ['#btnAgregarDependencia', '#btnAgregarEstatus', '#btnAgregarDepartamento']);
        const columnasCargo = [
            { data: 0 },
            { data: 1 },
            // Agrega más columnas según sea necesario
        ];
        const nuevosTextos = ['Cargos', 'activo', 'Acciones'];
        if (cambiarTextoCeldas(nuevosTextos)) {
            const newConfig = $.extend(true, {}, baseConfig, {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "src/ajax/datosDecd.php?modulo_datos=obtenerDatosCargo",
                    type: "POST",
                    dataSrc: function (json) {
                        // Verificar la estructura de los datos devueltos
                        if (json.data) {
                            // console.log(json.data);
                            return json.data; // Acceder al array de datos dentro de 'data'
                        } else {
                            console.error('Estructura de datos incorrecta:', json);
                            return [];
                        }
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        width: "50%",
                    },
                    {
                        targets: 1,
                        width: "20%",
                        render: function (data, type, row) {
                            let dataTexto = data;
                            const dataTextoMap = {
                                1: "Activo",
                                0: "Inactivo",
                            };

                            if (dataTextoMap[dataTexto] == 'Activo') {
                                dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                            } else {
                                dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                            }
                            return dataTexto
                        }
                    },
                    {
                        targets: 2,
                        width: "30%",
                    }
                ],
                columns: columnasCargo
            });
            recargarTabla(newConfig, nuevosTextos);
        }
    });

    $('#switchEstatus').on('click', async () => {
        await toggleButtons('#btnAgregarEstatus', ['#btnAgregarCargo', '#btnAgregarDependencia', '#btnAgregarDepartamento']);
        const columnasEstatus = [
            { data: 0 },
            { data: 1 },
            // Agrega más columnas según sea necesario
        ];
        const nuevosTextos = ['Estatus', 'Activo', 'Acciones'];
        if (cambiarTextoCeldas(nuevosTextos)) {
            const newConfig = $.extend(true, {}, baseConfig, {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "src/ajax/datosDecd.php?modulo_datos=obtenerDatosEstatus",
                    type: "POST",
                    dataSrc: function (json) {
                        // Verificar la estructura de los datos devueltos
                        if (json.data) {
                            // console.log(json.data);
                            return json.data; // Acceder al array de datos dentro de 'data'
                        } else {
                            console.error('Estructura de datos incorrecta:', json);
                            return [];
                        }
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        width: "50%",
                    },
                    {
                        targets: 1,
                        width: "30%",
                        render: function (data, type, row) {
                            let dataTexto = data;
                            const dataTextoMap = {
                                1: "Activo",
                                0: "Inactivo",
                            };

                            if (dataTextoMap[dataTexto] == 'Activo') {
                                dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                            } else {
                                dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                            }
                            return dataTexto
                        }
                    },
                    {
                        targets: 2,
                        width: "20%",
                    }
                ],
                columns: columnasEstatus
            });
            recargarTabla(newConfig, nuevosTextos);
        }
    });

    $('#switchDepa').on('click', async () => {
        await toggleButtons('#btnAgregarDepartamento', ['#btnAgregarDependencia', '#btnAgregarCargo', '#btnAgregarEstatus']);
        const columnasDepar = [
            { data: 0 },
            { data: 1 },
            // Agrega más columnas según sea necesario
        ];
        const nuevosTextos = ['Departamento', 'activo', 'Acciones'];
        if (cambiarTextoCeldas(nuevosTextos)) {
            const newConfig = $.extend(true, {}, baseConfig, {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "src/ajax/datosDecd.php?modulo_datos=obtenerDatosDepartamento",
                    type: "POST",
                    dataSrc: function (json) {
                        // Verificar la estructura de los datos devueltos
                        if (json.data) {
                            // console.log(json.data);
                            return json.data; // Acceder al array de datos dentro de 'data'
                        } else {
                            console.error('Estructura de datos incorrecta:', json);
                            return [];
                        }
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        width: "50%",
                    },
                    {
                        targets: 1,
                        width: "20%",
                        render: function (data, type, row) {
                            let dataTexto = data;
                            const dataTextoMap = {
                                1: "Activo",
                                0: "Inactivo",
                            };

                            if (dataTextoMap[dataTexto] == 'Activo') {
                                dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                            } else {
                                dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                            }
                            return dataTexto
                        }
                    },
                    {
                        targets: 2,
                        width: "30%",
                    }
                ],
                columns: columnasDepar
            });
            recargarTabla(newConfig, nuevosTextos);
        }
    });

    // Realizar la solicitud asíncrona para obtener los datos de las dependencias
    btnDependencia.addEventListener('click', async () => {
        //Abrir Modal
        $('#modalDependencia').modal('show');
        $('#dependencia').val('');
        $('#identificador_depe').val('');
        $('#estado').val('0').trigger('change');
        $('#codigo').val('');

        $('#dependencia').removeClass('cumplido');
        $('.span_dependencia').removeClass('cumplido');

        $('#estado').removeClass('cumplido');
        $('.span_estado').removeClass('cumplido');

        $('#codigo').removeClass('cumplido');
        $('.span_codigo').removeClass('cumplido_span');

        $('#dependencia').removeClass('error_input');
        $('.span_dependencia').removeClass('error_span');
        $('.span_dependencia').removeClass('cumplido_span');
        $('#estado').removeClass('error_input');
        $('.span_estado').removeClass('error_span');
        $('#codigo').removeClass('error_input');
        $('.span_codigo').removeClass('error_span');
        $('.select2').removeClass('error_input');
        $('span_codigo').removeClass('cimplido_span');

        $('#codigo').attr('disabled', false);

        const select = document.getElementById('estado');
        try {
            const response = await fetch('src/ajax/datosDecd.php?modulo_datos=obtenerEstados');
            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }
            const data = await response.json();
            data.data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.text = item.value;
                select.appendChild(option);
            });
        } catch (error) {
            console.error('Error al obtener los datos de las dependencias:', error);
        }
    });

    btnCargo.addEventListener('click', async () => {
        //Abrir Modal
        $('#modalCargo').modal('show');
        $('#cargo').val('');
        $('#identificador_cargo').val('');
        $('#cargo').removeClass('cumplido');
        $('.span_cargo').removeClass('cumplido_span');
    });

    btnEstatus.addEventListener('click', async () => {
        //Abrir Modal
        $('#modalEstatus').modal('show');
        $('#estatus').val('');
        $('#identificador_estatus').val('');
        $('#estatus').removeClass('cumplido');
        $('.span_estatus').removeClass('cumplido_span');
    });

    btnDepartamento.addEventListener('click', async () => {
        //Abrir Modal
        $('#modalDepartamento').modal('show');
        $('#departamento').val('');
        $('#identificador_depa').val('');
        $('#departamento').removeClass('cumplido');
        $('.span_departamento').removeClass('cumplido_span');
    });

    btnSinCodigo.addEventListener('click', async () => {
        // Verificar si el campo está deshabilitado
        if ($('#codigo').is(':disabled')) {
            // Revertir los cambios
            $('#codigo').removeClass('cumplido');
            $('.span_codigo').removeClass('cumplido_span');

            $('#codigo').addClass('error_input');
            $('.span_codigo').addClass('error_span');

            $('#codigo').removeClass('cumplidoNormal');

            $('#codigo').val('');

            $('#codigo').attr('disabled', false);
        } else {
            // Aplicar los cambios
            $('#codigo').removeClass('error_input');
            $('.span_codigo').removeClass('error_span');

            $('#codigo').removeClass('cumplido');
            $('.span_codigo').removeClass('cumplido_span');

            $('#codigo').addClass('cumplidoNormal');

            $('#codigo').addClass('cumplido');
            $('.span_codigo').addClass("cumplido_span");

            $('#codigo').val('');

            $('#codigo').attr('disabled', true);
        }
    });

    function registrarEditar(id, modulo, formulario, nombre) {
        function collbackExito(data) {
            if (data) {
                if (data.exito) {
                    alertaNormalmix(data.messenger, 3000, 'success', 'top-end');
                } else {
                    alertaNormalmix(data.messenger, 3000, 'error', 'top-end');
                }
            } else {
                alert('Error al registrar');
            }
        }
        if (id !== undefined) {
            const form = new FormData(formulario);
            const data = form;
            enviarFormulario(`./src/ajax/datosDecd.php?modulo_datos=${modulo}`, data, collbackExito, true);
        } else {
            const form = new FormData(formulario);
            
            const data = form;
            enviarFormulario(`./src/ajax/datosDecd.php?modulo_datos=${modulo}`, data, collbackExito, true);
        }
        tableInic.ajax.reload(null, false);
    }

    function eliminarActivar(id, activo, modulo, messenger, icon) {
        let formData = new FormData();
        formData.append('id', id); // Añadir id al FormData
        formData.append('activo', activo); // Añadir activador al FormData
        function callbackExito(parsedData) {
            // Manejar la respuesta exitosa aquí
            tableInic.ajax.reload(null, false);
            AlertSW2("success", parsedData.messenger, "top", 3000);
    }

        function enviar() {
            enviarFormulario(`./src/ajax/datosDecd.php?modulo_datos=${modulo}`, formData, callbackExito, true);
        }
        // parametros para la alerta
        aletaCheck(messenger, icon, 'top-end', enviar);
    }

    //FORMULARIO DE DEPENDENCIA
    $('.formularioDepen').on('submit', async function (e) {
        e.preventDefault();
        if ($(this).hasClass('editarDependencia')) {
            let id = $('#identificador_depe').val();
            registrarEditar(id, 'editarDependencia', this);
            $(this).removeClass('editarDependencia');
            $('#modalDependencia').modal('hide');
        } else {
            registrarEditar('', 'agregarDependencia', this);
            $('#modalDependencia').modal('hide');
        }
        tableInic.ajax.reload(null, false);
    });

    //FORMULARIO DE ESTATUS
    $('.formularioEstatus').on('submit', function (e) {
        e.preventDefault();
        if ($(this).hasClass('editarEstatus')) {
            let id = $('#identificador_Estatus').val();
            registrarEditar(id, 'editarEstatus', this);
            $(this).removeClass('editarEstatus');
            $('#modalEstatus').modal('hide');
        } else {
            registrarEditar('', 'agregarEstatus', this);
            $('#modalEstatus').modal('hide');
        }
        tableInic.ajax.reload(null, false);
    });

    //FORMULARIO CARGO
    $('.formularioCargo').on('submit', function (e) {
        e.preventDefault();
        if ($(this).hasClass('editarCargo')) {
            let id = $('#identificador_cargo').val();
            registrarEditar(id, 'editarCargo', this);
            $(this).removeClass('editarCargo');
            $('#modalCargo').modal('hide');
        } else {
            registrarEditar('', 'agregarCargo', this);
            $('#modalCargo').modal('hide');
        }
        tableInic.ajax.reload(null, false);
    });

    //FORMULARIO DEPARTAMENTO
    $('.formularioDepa').on('submit', function (e) {
        e.preventDefault();
        if ($(this).hasClass('editarDepa')) {
            let id = $('#identificador_cargo').val();
            registrarEditar(id, 'editarDepartamento', this);
            $(this).removeClass('editarDepa');
            $('#modalDepartamento').modal('hide');
        } else {
            registrarEditar('', 'agregarDepartamento', this);
            $('#modalDepartamento').modal('hide');
            tableInic.ajax.reload(null, false);
        }
        tableInic.ajax.reload(null, false);
    });

    // Delegación de dependencia
    $('#tableInic').on('click', '.btnEditarDependencia', async function () {
        try {
            let id = $(this).data('id');
            if (id !== undefined) {
                try {
                    let urls = [
                        "src/ajax/datosDecd.php?modulo_datos=obtenerDependencia",
                        "src/ajax/datosDecd.php?modulo_datos=obtenerEstados",
                    ];

                    let options = { id: id };
                    let requests = urls.map((url, index) => {
                        if (index === 0) { // Suponiendo que quieres pasar `options` solo a la primera solicitud
                            return obtenerDatosJQuery(url, options);
                        } else {
                            return obtenerDatosJQuery(url);
                        }
                    });

                    const [dependencia, estados] = await Promise.all(requests);

                    if (dependencia.exito && estados) {
                        const data = dependencia;
                        llenarSelectDependencias(estados.data, 'estado');
                        $('#identificador_depe').val(data.id_dependencia);
                        $('#dependencia').val(data.dependencia);
                        $('#dependencia').addClass('cumplido');
                        $('.span_dependencia').addClass('cumplido_span');

                        $('#estado').val(data.idestado).trigger('change');

                        $('#codigo').val(data.codigo);
                        $('#codigo').addClass('cumplido');
                        $('.span_codigo').addClass('cumplido_span');

                        $('.formularioDepen').addClass('editarDependencia');
                    } else {
                        console.error('Error al obtener dependencias o la estructura de la respuesta es incorrecta');
                    }
                } catch (error) {
                    console.error('Error al obtener los datos de la dependencia:', error);
                }
            } else {
                console.error('El idDependencia es undefined');
            }
        } catch (error) {
            console.error('Error al manejar el evento de clic:', error);
        }
    });

    $('#tableInic').on('click', '.btnEliminarDependencia', async function () {
        let id = $(this).data('id');
        let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
        eliminarActivar(id, 0, 'eliminarActivarDependencia', messenger, 'warning');
    });

    $('#tableInic').on('click', '.btnActivarDependencia', async function () {
        let id = $(this).data('id');
        const messenger = 'Estás a punto de <b class="text-success"><i class="fa-solid fa-check"></i> <u>activar</u></b> este registro. ¿Deseas continuar?';
        eliminarActivar(id, 1, 'eliminarActivarDependencia', messenger, 'success');
    })

    // Delegación de cargo
    $('#tableInic').on('click', '.btnEditarCargo', async function () {
        let id = $(this).data('id');
        // Obtener la fila correspondiente al botón clicado
        let row = $(this).closest('tr');
        // Obtener los datos de la fila
        let rowData = tableInic.row(row).data();
        // Obtener el primer campo de la fila
        let primerCampo = rowData[0];
        $('#identificador_cargo').val(id);
        $('#cargo').val(primerCampo);
        $('#cargo').addClass('cumplido');
        $('.span_cargo').addClass('cumplido_span');
        $('.formularioCargo').addClass('editarCargo');
    });

    $('#tableInic').on('click', '.btnEliminarCargo', async function () {
        let id = $(this).data('id');
        let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
        eliminarActivar(id, 0, 'eliminarActivarCargo', messenger, 'warning');
    });

    $('#tableInic').on('click', '.btnActivarCargo', async function () {
        let id = $(this).data('id');
        const messenger = 'Estás a punto de <b class="text-success"><i class="fa-solid fa-check"></i> <u>activar</u></b> este registro. ¿Deseas continuar?';
        eliminarActivar(id, 1, 'eliminarActivarCargo', messenger, 'success');
    })

    // Delegación de estatus
    $('#tableInic').on('click', '.btnEditarEstatus', async function () {
        let id = $(this).data('id');
        // Obtener la fila correspondiente al botón clicado
        let row = $(this).closest('tr');
        // Obtener los datos de la fila
        let rowData = tableInic.row(row).data();
        // Obtener el primer campo de la fila
        let primerCampo = rowData[0];
        $('#identificador_estatus').val(id);
        $('#estatus').val(primerCampo);
        $('#estatus').addClass('cumplido');
        $('.span_estatus').addClass('cumplido_span');
        $('.formularioEstatus').addClass('editarEstatus');
    });

    $('#tableInic').on('click', '.btnEliminarEstatus', async function () {
        let id = $(this).data('id');
        let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
        eliminarActivar(id, 0, 'eliminarActivarEstatus', messenger, 'warning');
    });

    $('#tableInic').on('click', '.btnActivarEstatus', async function () {
        let id = $(this).data('id');
        const messenger = 'Estás a punto de <b class="text-success"><i class="fa-solid fa-check"></i> <u>activar</u></b> este registro. ¿Deseas continuar?';
        eliminarActivar(id, 1, 'eliminarActivarEstatus', messenger, 'success');
    })

    // Delegación de departamento
    $('#tableInic').on('click', '.btnEditarDepa', async function () {
        let id = $(this).data('id');
        // Obtener la fila correspondiente al botón clicado
        let row = $(this).closest('tr');
        // Obtener los datos de la fila
        let rowData = tableInic.row(row).data();
        // Obtener el primer campo de la fila
        let primerCampo = rowData[0];
        $('#identificador_depa').val(id);
        $('#departamento').val(primerCampo);
        $('#departamento').addClass('cumplido');
        $('.span_departamento').addClass('cumplido_span');
        $('.formularioDepa').addClass('editarDepa');
    });

    $('#tableInic').on('click', '.btnEliminarDepa', async function () {
        let id = $(this).data('id');
        let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
        eliminarActivar(id, 0, 'eliminarActivarDepartamento', messenger, 'warning');
    });

    $('#tableInic').on('click', '.btnActivarDepa', async function () {
        let id = $(this).data('id');
        const messenger = 'Estás a punto de <b class="text-success"><i class="fa-solid fa-check"></i> <u>activar</u></b> este registro. ¿Deseas continuar?';
        eliminarActivar(id, 1, 'eliminarActivarDepartamento', messenger, 'success');
    })

    async function llenarSelectDependencias(data, selectId) {

        const select = document.getElementById(selectId);
        console.log(data);
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
    // metodos para escuchar cambios en el dom y habilitar el boton de enviar formulario 
    // Función para verificar si todos los campos están cumplidos en un formulario específico
    function todosCumplidos(form) {
        const elementosCumplidos = $(form).find('input, select').filter('.cumplido, .cumplidoNormal');
        return elementosCumplidos.length === $(form).find('input, select').length;
    }

    // Función para habilitar o deshabilitar el botón en un formulario específico
    function habilitarBoton(form, boton) {
        boton.prop('disabled', !todosCumplidos(form));
    }

    // Función de debounce para limitar la frecuencia de ejecución
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Seleccionar los formularios específicos que deseas observar
    const forms = document.querySelectorAll('.formDependencia, .formCargo, .formEstatus, .formDepartamento');

    forms.forEach(form => {
        const boton = $(form).closest('.modal').find('.aceptar');

        // Inicialmente desactivar el botón
        boton.prop('disabled', true);

        // Crear una instancia de MutationObserver y observar cambios
        const observer = new MutationObserver(debounce((mutationsList) => {
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList' || mutation.type === 'attributes') {
                    habilitarBoton(form, boton);
                }
            }
        }, 300)); // Ajusta el tiempo de espera según sea necesario

        // Configurar el observer para observar cambios en los hijos y atributos del formulario
        const config = { childList: true, attributes: true, subtree: true };

        // Comenzar a observar el formulario
        observer.observe(form, config);

        // Ejecutar la validación inicialmente
        habilitarBoton(form, boton);
    });


});

