import { descargarArchivo } from "./utils/formularioAjax.js";


$(function () {

    // Configuración base para DataTables
    let table = new DataTable('#myTable', {
        responsive: true,
        ajax: {
            url: "./src/ajax/bienestarSocial.php?modulo_datos=tablaEmpleado",
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
        processing: true,
        searching: true,
        serverSide: true,
        info: false,
        order: [[0, 'desc']],
        paging: true,
        lengthMenu: [
            [2, 10, 30, -1], // Valores
            ['2', '10', '30', 'Todos'] // Etiquetas
        ],
        pageLength: 10,
        language: {
            url: "./IdiomaEspañol.json"
        },
        columns: [
            { "data": 0 }, // EnUso
            { "data": 1 }, // Usuario
            { "data": 2 }, // Nombre
            { "data": 3 }, // Apellido
            { "data": 4 }  // Correo
        ],
        columnDefs: [
            { targets: [1, 2, 3, 4], className: 'dt-center dt-middle' }
        ]
    });


    $('#myTable').on('click', '.btnDescargarFicha', function () {
        let formData = new FormData();
        formData.append('cedula', $(this).data('id'));
        descargarArchivo('./src/ajax/tablasDescargar.php?accion=fichaTecnica', 'DatosEmpleado.pdf', formData);
    });
});

