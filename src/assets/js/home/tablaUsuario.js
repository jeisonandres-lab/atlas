import { inicializarDataTable } from "../utils/dataTablet.js";

// Dependencias: jQuery
$(async function () {
    // Configuración de la tabla de usuarios
    const configuracionTablaUsuario = {
        searching: false,
        order: [[0, 'desc']],
        paging: false,
        columnDefs: [
            {
                targets: 4,
                width: "25%",
                render: function (data, type, row) {
                    console.log(data)
                    const dataTextoMap = {
                        'Administrador': 'Administrador',
                        'Medico': 'Medico',
                        // Agrega más roles según sea necesario
                    };

                    const colores = [
                        'badge text-bg-success ',
                    ];

                    const colorAleatorio = colores[Math.floor(Math.random() * colores.length)];

                    return `<span class=' ${colorAleatorio}' style='color: white !important'>${dataTextoMap[data]}</span>`;
                }
            },
            {
                targets: 0,
                className: '',
                visible: false,
                width: "20%",
                render: function (data, type, row) {
                    let dataTexto = data;
                    const dataTextoMap = {
                        1: "1",
                        0: "",
                    };

                    if (dataTextoMap[dataTexto] == '1') {
                        dataTexto = `<div class='conten-circulo d-flex justify-content-center aling-items-center h-100'><span class='rounded circulo-success'></span></div>`;
                    } else {
                        dataTexto = `<div class='conten-circulo d-flex justify-content-center aling-items-center h-100'><span class='rounded circulo-danger'></span></div>`;
                    }
                    return dataTexto
                }
            },

            {
                targets: 1,
                width: "20%",
                render: function (data, type, row) {
                    let dataTexto = data;
                    const dataTextoMap = {
                        1: "Activo",
                        0: "Desactivado",
                        2: "Inactivo",
                    };

                    if (dataTextoMap[dataTexto] == 'Activo') {
                        dataTexto = `<span class="badge text-bg-success" style='color: white !important'>${dataTextoMap[dataTexto]}</span>`;
                    } else {
                        dataTexto = `<span class="badge text-bg-danger" style='color: white !important'>${dataTextoMap[dataTexto]}</span>`;
                    }
                    return dataTexto
                }
            },
        ],
        columns: [
            { "data": 0 }, // EnUso
            { "data": 3 }, // Activo
            { "data": 4 },
            { "data": 1 }, // Usuario
            { "data": 2 }, // Rol
        ]
    };
    
    await inicializarDataTable('#tablaUsuarios', configuracionTablaUsuario,"", "./src/routers/usuario.php?modulo_usuario=datosUsuariosBasicos");
});

