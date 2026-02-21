
import { AlertSW2 } from "./ajax/alerts.js";
import { obtenerDatosJQuery } from "./ajax/formularioAjax.js";
// Dependencias: jQuery, DataTables. Gráficos: homeCharts.js (ApexCharts)
$(function () {

    const homeUsersTableLang = {
        lengthMenu: "Mostrar _MENU_ registros",
        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
        infoEmpty: "Mostrando 0 a 0 de 0 registros",
        infoFiltered: "(filtrado de _MAX_ registros)",
        search: "Buscar:",
        paginate: { first: "<<", last: ">>", next: ">", previous: "<" },
    };

    let table = new DataTable('#tableUsers', {
        responsive: true,
        ajax: {
            url: "./src/ajax/userAjax.php?modulo_usuario=DatosUsuariosBasicos",
            type: "POST",
            dataSrc: function (json) {
                if (json.data) return json.data;
                console.error('Estructura de datos incorrecta:', json);
                return [];
            }
        },
        processing: true,
        searching: false,
        serverSide: true,
        info: false,
        order: [[0, 'desc']],
        paging: true,
        lengthMenu: [2, 10, 25],
        pageLength: 5,
        columnDefs: [
            {
                targets: 0,
                className: 'text-center',
                width: "10%",
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
                targets: 1, // Ajusta el índice de la columna según sea necesario
                width: "40%",
            },
            {
                targets: 2,
                width: "25%",
                render: function (data, type, row) {
                    const dataTextoMap = {
                        'Administrador': 'Administrador',
                        'Medico': 'Usuario',
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
                targets: 3,
                width: "25%",
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

        language: {
            url: "./IdiomaEspañol.json"
        },
        columns: [
            { "data": 0 }, // EnUso
            { "data": 1 }, // Usuario
            { "data": 2 }, // Activo
            { "data": 3 }, // Rol
        ]
    });

    let urlsCard = [
        "src/ajax/totalDate.php?modulo_Datos=totalDatos"
    ];

    let requests = urlsCard.map((url, index) => {
        // Suponiendo que quieres pasar `options` solo a la primera solicitud
        return obtenerDatosJQuery(url);
    });

    async function obtenerDatosCards() {
        try {
            const totalPersonal = await Promise.all(requests);
            if (totalPersonal[0].exito) {
                console.log(totalPersonal[0]);
                $('#totalPersonal').text(totalPersonal[0].empleado[0].totalEmpleados);
                $('#totalArchivos').text(totalPersonal[0].archivos[0].totalArchivos);
                $('#atencionMedica').text(totalPersonal[0].atencionMedica[0].atencionMedica);
                $('#totalMedicamentos').text(totalPersonal[0].medicamentos[0].totalMedicamentos);
                $('#personalAusencia').text(totalPersonal[0].ausencia[0].totalPermisos);
                $('#porcentajeArchivos').text(totalPersonal[0].porcentajeArchivos[0].porcentaje_documentos_subidos + '%');
                // Rellenar los indicadores pequeños (tarjetas superiores)
                $('#totalPersonalSmall').text(totalPersonal[0].empleado[0].totalEmpleados);
                $('#totalArchivosSmall').text(totalPersonal[0].archivos[0].totalArchivos);
                $('#personalVacacionesSmall').text(totalPersonal[0].vacaciones && totalPersonal[0].vacaciones[0] ? totalPersonal[0].vacaciones[0].totalVacaciones : (totalPersonal[0].vacaciones_count || 0));
                $('#personalAusenciaSmall').text(totalPersonal[0].ausencia[0].totalPermisos);
                // permisos pendientes: usar campo disponible o fallback a 0
                const permisosPend = totalPersonal[0].permisosPendientes || totalPersonal[0].ausencia[0].totalPermisos || 0;
                $('#permisosPendientesSmall').text(permisosPend);
            } else {
                console.error('Error al obtener dependencias o la estructura de la respuesta es incorrecta');
            }
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    }

    obtenerDatosCards();

    function obtenerFechaYDia(parametro) {
        const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        const hoy = new Date();
        const diaSemana = diasSemana[hoy.getDay()];
        const dia = hoy.getDate();
        const mes = hoy.getMonth() + 1; // Los meses en JavaScript son 0-indexados
        const año = hoy.getFullYear();

        if (parametro === 'fecha') {
            return `${dia} de ${meses[mes - 1]} de ${año}`;
        } else if (parametro === 'dia') {
            return diaSemana;
        } else if (parametro === 'fechaISO') {
            const mesConCero = mes.toString().padStart(2, '0');
            const diaConCero = dia.toString().padStart(2, '0');
            return `${año}-${mesConCero}-${diaConCero}`;
        } else {
            return 'Parámetro no válido. Usa "fecha", "dia" o "fechaISO".';
        }
    }

    var fecha = obtenerFechaYDia('fecha');
    var dia = obtenerFechaYDia('dia');
    var fechaISO = obtenerFechaYDia('fechaISO');

    $('#fecha').text(fecha);
    $('.descargarBD').click(function () {
        $.ajax({
            url: './src/ajax/administrador.php?modulo_datos=descargarBD', // Reemplaza con la URL de tu script de descarga
            method: 'POST', // O 'POST' si es necesario
            success: function (response, data) {
                // Si la descarga fue exitosa, muestra el mensaje
                AlertSW2('success', 'listo!, ya se logro de descargar la base de datos', 'top', 4000)
            },
            error: function (xhr, status, error) {
                // Si hubo un error, muestra un mensaje de error
                $('#mensaje').text('Error al descargar la base de datos: ' + error);
            }
        });
    });

})
document.addEventListener('DOMContentLoaded', async function () {
    const { initHomeCharts } = await import('./homeCharts.js');
    initHomeCharts();
});