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
                width: "45%",
            },
            {
                targets: 1, // Ajusta el índice de la columna según sea necesario
                render: function (data, type, row) {
                    const dataTextoMap = {
                        'Administrador': 'Administrador',
                        'Medico': 'Usuario',
                        // Agrega más roles según sea necesario
                    };

                    const colores = [
                        'bg-success-subtle border border-success-subtle ',
                        'bg-primary-subtle border border-primary-subtle',

                    ];

                    const colorAleatorio = colores[Math.floor(Math.random() * colores.length)];

                    return `<small class='d-inline-flex px-2 py-1 fw-semibold text-success-emphasis ${colorAleatorio} border border-success-subtle rounded-2'>${dataTextoMap[data]}</small>`;
                }
            },
            {
                targets: 2,
                width: "25%",
                render: function (data, type, row) {
                    let dataTexto = data;
                    const dataTextoMap = {
                        1: "Activo",
                        0: "Desactivado",
                    };

                    if (dataTextoMap[dataTexto] == 'Activo') {
                        dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                    } else {
                        dataTexto = `<small class='d-inline-flex px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>${dataTextoMap[dataTexto]}</small>`;
                    }
                    return dataTexto
                }
            },
        ],

        language: {
            url: "./IdiomaEspañol.json"
        },
        columns: [
            { "data": 0 }, // Cédula
            { "data": 1 }, // Nombre Y Apellido
            { "data": 2 }, // Estatus
        ]
    });



})
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



document.addEventListener('DOMContentLoaded', function () {
    fetch('chart.php') // Reemplaza esto con la ruta correcta a tu script PHP
        .then(response => response.json())
        .then(data => {
            const playerNames = data.map(item => item.personal);
            const scores = data.map(item => item.firma);

            const ctx = document.getElementById('scoreChart').getContext('2d');
            const scoreChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: playerNames, // Usar playerNames para las etiquetas
                    datasets: [{
                        label: 'Scores', // Etiqueta para el conjunto de datos
                        data: scores, // Usar scores para los datos
                        borderWidth: 1,
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ]
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});