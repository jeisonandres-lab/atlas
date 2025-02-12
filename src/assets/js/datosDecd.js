import {  enviarFormulario } from './ajax/formularioAjax.js';
import { validarNombre, incluirSelec2, validarSelectoresSelec2, soloNumeros, validarNombreConEspacios } from './ajax/inputs.js';
import { alertaNormalmix } from './ajax/alerts.js';

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
            const $celda = $('<th>').text(texto).addClass('bg-primary text-white');
            // console.log(`Añadiendo celda con texto: ${texto}`); // Depuración
            $fila.append($celda);
        });

        // Agregar la fila al thead
        $thead.append($fila);

        tableInic = $('#tableInic').DataTable(newConfig); // Inicializar una nueva instancia con la nueva configuración
    }

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
                            console.log('holisss:' + dataTexto);
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
                option.value = item.id_estado;
                option.text = item.estado;
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
    });

    btnEstatus.addEventListener('click', async () => {
        //Abrir Modal
        $('#modalEstatus').modal('show');
        $('#estatus').val('');
    });

    btnDepartamento.addEventListener('click', async () => {
        //Abrir Modal
        $('#modalDepartamento').modal('show');
        $('#departamento').val('');
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

    //FORMULARIO DE DEPENDENCIA
    $('.formularioDepen').on('submit', async function (e) {
        e.preventDefault();
        function collbackExito(data) {
            if (data) {
                if (data.exito) {
                    alertaNormalmix(data.messenger, 3000, 'success', 'top-end');
                } else {
                    console.log('si llegaorn datos pero la respuesta fue falsa')
                }
            } else {
                alert('Error al registrar');
            }
        }
        const form = new FormData(this);
        const data = form;
        enviarFormulario('./src/ajax/datosDecd.php?modulo_datos=agregarDependencia', data, collbackExito, true);
    });

    //FORMULARIO DE ESTATUS
    $('.formularioEstatus').on('submit', function (e) {
        e.preventDefault();
        async function collbackExito(data) {
            if (data.exito) {
                alertaNormalmix(data.messenger, 3000, 'success', 'top-end');
            } else {
                console.log('si llegaorn datos pero la respuesta fue falsa')
            }
        }
        const form = new FormData(this);
        const data = form;
        enviarFormulario('./src/ajax/datosDecd.php?modulo_datos=agregarEstatus', data, collbackExito, true);
    });

    //FORMULARIO CARGO
    $('.formularioCargo').on('submit', function (e) {
        e.preventDefault();
        async function collbackExito(data) {
            if (data.exito) {
                alertaNormalmix(data.messenger, 3000, 'success', 'top-end');
            } else {
                console.log('si llegaorn datos pero la respuesta fue falsa');
            }
        }
        const form = new FormData(this);
        const data = form;
        enviarFormulario('./src/ajax/datosDecd.php?modulo_datos=agregarCargo', data, collbackExito, true);
    });

    //FORMULARIO DEPARTAMENTO
    $('.formularioDepa').on('submit', function (e) {
        e.preventDefault();
        async function collbackExito(data) {
            if (data.exito) {
                alertaNormalmix(data.messenger, 3000, 'success', 'top-end');
            } else {
                console.log('si llegaorn datos pero la respuesta fue falsa')
            }
        }
        const form = new FormData(this);
        const data = form;
        enviarFormulario('./src/ajax/datosDecd.php?modulo_datos=agregarDepartamento', data, collbackExito, true);
    });


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

