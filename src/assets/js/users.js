import { AlertSW2, aletaCheck } from "./utils/alerts.js";
import { enviarFormulario, obtenerDatos } from "./utils/formularioAjax.js";

$(function () {

    let table = new DataTable('#myTable', {
        responsive: true,
        ajax: {
            url: "./src/ajax/userAjax.php?modulo_usuario=DatosUsuarios",
            type: "POST",
            dataSrc: function (json) {
                // Verificar la estructura de los datos devueltos
                if (json.data) {
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
                className: 'text-center',
                width: "10%",
                render: function (data, type, row) {
                    let dataTexto = data;
                    console.log('dasdas' + dataTexto);
                    const dataTextoMap = {
                        1: "Activo",
                        2: "Desactivado",
                        0: "Inactivo",
                    };

                    if (dataTextoMap[dataTexto] == 'Activo') {
                        dataTexto = `<span class="badge text-bg-success text-white">${dataTextoMap[dataTexto]}</span>`;
                    } else {
                        dataTexto = `<span class="badge text-bg-danger text-white">${dataTextoMap[dataTexto]}</span>`;
                    }
                    return dataTexto
                }
            },
            {
                targets: 4,
                className: 'text-center',
                width: "10%",
                render: function (data, type, row) {
                    if (data == "Si") {
                        return `<span class="badge text-bg-success text-white">Activo</span>`;
                    } else {
                        return `<span class="badge text-bg-danger text-white">Inactivo</span>`;
                    }
                }
            },
            {
                targets: 3,
                render: function (data, type, row) {
                    let dataTexto = data;

                    dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-white-emphasis bg-primary-subtle border border-primary-subtle rounded-2'>${dataTexto}</small>`;

                    return dataTexto
                }
            },
        ],
        processing: true,
        searching: true,
        serverSide: true,
        info: false,
        order: [[0, 'desc']],
        paging: true,
        lengthMenu: [10, 25],
        pageLength: 10,
        language: {
            url: "./IdiomaEspañol.json"
        },
        columns: [
            { "data": 0 }, // EnUso
            { "data": 1 }, // Usuario
            { "data": 2 }, // Activo
            { "data": 3 }, // Rol
            { "data": 4 }, // Rol
            { "data": 5 }, // Rol
        ]
    });

    $("#myTable").on('click', '.btnEliminarUsuario', function () {
        let idAusencia = $(this).data('id');
        let formData = new FormData();
        formData.append('id', idAusencia); // Añadir idPersonal al FormData
    
        function callbackExito(parsedData) {
          // Manejar la respuesta exitosa aquí
          $('#myTable').DataTable().ajax.reload(null, false);
          AlertSW2("success", parsedData.messenger, "top", 3000);
    
        }
    
        function enviar() {
          let destino = "./src/ajax/userAjax.php?modulo_usuario=desactivarUsuario";
          let url = destino;
          enviarFormulario(url, formData, callbackExito, true);
        }
        // parametros para la alerta
        let messenger = 'Estás a punto de <b class="text-warning"><i class="fa-solid fa-xmark"></i> <u>desactivar</u></b> este usuario. ¿Deseas continuar?';
        let icons = 'primary';
        let position = 'top-end';
    
        aletaCheck(messenger, icons, position, enviar);
      });
});