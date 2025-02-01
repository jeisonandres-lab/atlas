$(function () {
    const btnDependencia = document.querySelector('#btnAgregarDependencia');
    const btnCargo = document.querySelector('#btnAgregarCargo');
    const btnEstatus = document.querySelector('#btnAgregarEstatus');
    const btnDepartamento = document.querySelector('#btnAgregarDepartamento');
    $('#btnAgregarDependencia').hide();
    $('#btnAgregarCargo').hide();
    $('#btnAgregarEstatus').hide();
    $('#btnAgregarDepartamento').hide();
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
            console.log(`Añadiendo celda con texto: ${texto}`); // Depuración
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
            console.log(`Añadiendo celda con texto: ${texto}`); // Depuración
            $fila.append($celda);
        });

        console.log($fila.html()); // Depuración: Verificar el contenido de la fila
        console.log($thead.html()); // Depuración: Verificar el contenido del thead
        return true;
    }

    // Ejemplo de uso de las funciones
    $('#switchDepe').on('click', () => {
        $('#btnAgregarDependencia').slideDown();

        $('#btnAgregarCargo').hide();
        $('#btnAgregarEstatus').hide();
        $('#btnAgregarDepartamento').hide();
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
                            console.log(json.data);
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

    $('#switchCargo').on('click', () => {
        $('#btnAgregarCargo').slideDown();

        $('#btnAgregarDependencia').hide();
        $('#btnAgregarEstatus').hide();
        $('#btnAgregarDepartamento').hide();
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
                            console.log(json.data);
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

    $('#switchEstatus').on('click', () => {
        $('#btnAgregarEstatus').slideDown();

        $('#btnAgregarCargo').hide();
        $('#btnAgregarDependencia').hide();
        $('#btnAgregarDepartamento').hide();
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
                            console.log(json.data);
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

    $('#switchDepa').on('click', () => {
        $('#btnAgregarDepartamento').slideDown();

        $('#btnAgregarDependencia').hide();
        $('#btnAgregarCargo').hide();
        $('#btnAgregarEstatus').hide();
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
                            console.log(json.data);
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

});