
import { AlertSW2 } from "./ajax/alerts.js";
import { obtenerDatosJQuery } from "./ajax/formularioAjax.js";
// Dependencias: jQuery, DataTables, Chart.js
$(function () {
    
    let table = new DataTable('#tableUsers', {
        responsive: true,
        ajax: {
            url: "./src/ajax/userAjax.php?modulo_usuario=DatosUsuariosBasicos",
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
        $.when(...requests).done((totalPersonal) => {
            if (totalPersonal.exito) {
                console.log(totalPersonal);
                $('#totalPersonal').text(totalPersonal.empleado[0].totalEmpleados);
                $('#totalArchivos').text(totalPersonal.archivos[0].totalArchivos); totalMedicamentos
                $('#atencionMedica').text(totalPersonal.atencionMedica[0].atencionMedica); personalAusencia
                $('#totalMedicamentos').text(totalPersonal.medicamentos[0].totalMedicamentos);
                // $('#personalVacaciones').text(totalPersonal.vacaciones[0].totalVacaciones);
                $('#personalAusencia').text(totalPersonal.ausencia[0].totalPermisos);
                // PORCENTAJES DE DATOS
                $('#porcentajeArchivos').text(totalPersonal.porcentajeArchivos[0].porcentaje_documentos_subidos + '%');
            } else {
                console.error('Error al obtener dependencias o la estructura de la respuesta es incorrecta');
            }

        }).fail((jqXHR, textStatus, errorThrown) => {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        });
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
    $('.descargarBD').click(function() {
        $.ajax({
            url: './src/ajax/administrador.php?modulo_datos=descargarBD', // Reemplaza con la URL de tu script de descarga
            method: 'POST', // O 'POST' si es necesario
            success: function(response, data) {
                // Si la descarga fue exitosa, muestra el mensaje
                AlertSW2('success', 'listo!, ya se logro de descargar la base de datos', 'top', 4000)
            },
            error: function(xhr, status, error) {
                // Si hubo un error, muestra un mensaje de error
                $('#mensaje').text('Error al descargar la base de datos: ' + error);
            }
        });
    });
    
})
document.addEventListener('DOMContentLoaded', async function () {
    async function fetchData(url) {
        try {
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
            return null;
        }
    }

    async function loadChartDia() {
        const dataDia = await fetchData('src/ajax/totalDate.php?modulo_Datos=totalArchivosDia');
        if (dataDia && dataDia.exito) {
            console.table(dataDia);
            const chartDataDia = {
                labels: dataDia.values,
                datasets: [{
                    label: 'Datos Subidos',
                    data: dataDia.labels,
                    backgroundColor: ['rgb(25, 41, 187)', 'rgb(54, 162, 235)'],
                    with: 20,
                    hoverOffset: 4
                }]
            };

            const configDia = {
                type: 'bar',
                data: chartDataDia,
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const originalLabel = dataDia.original_labels[context.dataIndex];
                                    return `${context.label}: ${originalLabel}`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: 20,

                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }

                }
            };

            const ctxDia = document.getElementById('scoreChart').getContext('2d');
            new Chart(ctxDia, configDia);
        } else {
            console.error('Error en los datos del día:', dataDia ? dataDia.messenger : 'No data');
        }
    }

    async function loadChartMes() {
        const dataMes = await fetchData('src/ajax/totalDate.php?modulo_Datos=totalArchivosMes');
        if (dataMes && dataMes.exito) {
            console.table(dataMes);
            const chartDataMes = {
                labels: dataMes.values,
                datasets: [{
                    label: 'Cantidad de archivos subidos',
                    data: dataMes.labels,
                    backgroundColor: [
                        'rgb(25, 41, 187)', 'rgb(54, 162, 235)', 'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)', 'rgb(255, 99, 132, 0.5)', 'rgb(54, 162, 235, 0.5)',
                        'rgb(255, 205, 86, 0.5)', 'rgb(75, 192, 192, 0.5)', 'rgb(153, 102, 255, 0.5)',
                        'rgb(255, 159, 64, 0.5)'
                    ],
                    hoverOffset: 4
                }]
            };

            const configMes = {
                type: 'doughnut',
                data: chartDataMes,
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const originalLabel = dataMes.original_labels[context.dataIndex];
                                    return `${context.label}: ${originalLabel}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            // ... opciones de escala ...
                        },
                        x: {
                            barThickness: 120 // Ancho de barra fijo de 50 píxeles
                        }
                    }
                }
            };

            const ctxMes = document.getElementById('scoreChart2').getContext('2d');
            new Chart(ctxMes, configMes);
        } else {
            console.error('Error en los datos del mes:', dataMes ? dataMes.messenger : 'No data');
        }
    }

    // Cargar las gráficas de manera asíncrona
    loadChartDia();
    loadChartMes();
});
