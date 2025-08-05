import { AlertSW2 } from "../utils/alerts.js";

$(async function (){

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
            url: './src/requests/administrador.php?modulo_datos=descargarBD', // Reemplaza con la URL de tu script de descarga
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



    const tbody = document.querySelector('.tbody-tabletUser');

    // Ejemplo de cómo agregar una fila con animación
    function addNewRow(userData) {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <th scope="row">${userData.id}</th>
            <td>${userData.estatus}</td>
            <td>${userData.empleado}</td>
            <td>${userData.usuario}</td>
            <td>${userData.rol}</td>
        `;

        // Agregar la fila al tbody
        tbody.appendChild(newRow);

        // Con un pequeño retraso, añadir la clase 'visible' para activar la animación
        setTimeout(() => {
            newRow.classList.add('visible');
        }, 10); // Un retraso de 10ms es suficiente para que funcione
    }

    // Ejemplo de uso: agregando 3 filas al cargar la página
    addNewRow({ id: 1, estatus: 'Activo', empleado: 'Juan Pérez', usuario: 'jperez', rol: 'Admin' });
    addNewRow({ id: 2, estatus: 'Inactivo', empleado: 'María Gómez', usuario: 'mgomez', rol: 'Usuario' });
    addNewRow({ id: 3, estatus: 'Activo', empleado: 'Carlos Ruiz', usuario: 'cruiz', rol: 'Editor' });

    let chartInstanceMes = null;
    let chartInstanceForDate = null;
    let backButton = null;

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
        const dataDia = await fetchData('./src/routers/totalDate.php?modulo_Datos=totalArchivosDia');
        if (dataDia && dataDia.exito) {
            // console.table(dataDia);
            const chartDataDia = {
                labels: dataDia.values,
                datasets: [{
                    label: 'Archivos subidos en el mes actual',
                    data: dataDia.labels,
                    backgroundColor: ['rgba(25, 41, 187, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(25, 41, 187, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1,
                    hoverOffset: 4
                }]
            };

            const configDia = {
                type: 'bar',
                data: chartDataDia,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                        y: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                }
            };

            requestAnimationFrame(() => {
                const ctxDia = document.getElementById('scoreChart').getContext('2d');
                new Chart(ctxDia, configDia);
            });
        } else {
            console.error('Error en los datos del día:', dataDia ? dataDia.messenger : 'No data');
        }
    }

    async function loadChartMes() {
        const dataMes = await fetchData('src/routers/totalDate.php?modulo_Datos=totalArchivosMes');
        if (dataMes && dataMes.exito) {
            // console.table(dataMes);
            const chartDataMes = {
                labels: dataMes.values,
                datasets: [{
                    label: 'Cantidad de archivos subidos por mes',
                    data: dataMes.labels,
                    backgroundColor: [
                        'rgba(0, 100, 0, 0.8)',   // Verde oscuro
                        'rgba(50, 205, 50, 0.8)',  // Verde lima
                        'rgba(0, 128, 0, 0.8)',   // Verde medio
                        'rgba(144, 238, 144, 0.8)', // Verde claro
                        'rgba(60, 179, 113, 0.8)', // Verde mar
                        'rgba(34, 139, 34, 0.8)',  // Verde bosque
                        'rgba(154, 205, 50, 0.8)', // Verde amarillo
                        'rgba(107, 142, 35, 0.8)', // Verde oliva
                        'rgba(173, 255, 47, 0.8)', // Verde césped
                        'rgba(0, 250, 154, 0.8)', // Verde primavera medio
                        'rgba(127, 255, 212, 0.8)', // Aguamarina claro
                        'rgba(143, 188, 143, 0.8)', // Verde militar
                        'rgba(152, 251, 152, 0.8)'  // Verde pálido
                    ],
                    borderColor: 'green',
                    pointBackgroundColor: [
                        'rgba(0, 100, 0, 0.8)',
                        'rgba(50, 205, 50, 0.8)',
                        'rgba(0, 128, 0, 0.8)',
                        'rgba(144, 238, 144, 0.8)',
                        'rgba(60, 179, 113, 0.8)',
                        'rgba(34, 139, 34, 0.8)',
                        'rgba(154, 205, 50, 0.8)',
                        'rgba(107, 142, 35, 0.8)',
                        'rgba(173, 255, 47, 0.8)',
                        'rgba(0, 250, 154, 0.8)',
                        'rgba(127, 255, 212, 0.8)',
                        'rgba(143, 188, 143, 0.8)',
                        'rgba(152, 251, 152, 0.8)'
                    ],
                    pointBorderColor: 'green',
                    hoverOffset: 4
                }]
            };

            const configMes = {
                type: 'line',
                data: chartDataMes,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                            // Opciones de escala
                        },
                        x: {
                            barThickness: 120
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                    onClick: async (event, elements) => {
                        if (elements.length > 0) {
                            const elementIndex = elements[0].index;
                            const label = dataMes.values[elementIndex];
                            const value = dataMes.labels[elementIndex];
                            await loadChartForDate(label);
                        }
                    }
                }
            };

            requestAnimationFrame(() => {
                const ctxMes = document.getElementById('scoreChart2').getContext('2d');
                if (chartInstanceMes) {
                    chartInstanceMes.destroy();
                    chartInstanceMes = null;
                }
                if (chartInstanceForDate) {
                    chartInstanceForDate.destroy();
                    chartInstanceForDate = null;
                }
                chartInstanceMes = new Chart(ctxMes, configMes);
            });

            // Eliminar el botón de "Regresar" si existe
            if (backButton) {
                backButton.remove();
                backButton = null;
            }
        } else {
            console.error('Error en los datos del mes:', dataMes ? dataMes.messenger : 'No data');
        }
    }

    async function loadChartForDate(date) {
        const daysInMonth = new Date(date.split('-')[0], date.split('-')[1], 0).getDate();
        const dataForDate = {
            exito: true,
            values: Array.from({ length: daysInMonth }, (_, i) => `${date}-${String(i + 1).padStart(2, '0')}`),
            labels: Array.from({ length: daysInMonth }, () => {
                const randomValue = Math.random();
                if (randomValue < 0.5) {
                    return `${Math.floor(Math.random() * 100) + 1} MB`;
                } else {
                    return `${Math.floor(Math.random() * 100) + 1} KB`;
                }
            })
        };

        if (dataForDate && dataForDate.exito) {
            console.table(dataForDate);
            const chartDataForDate = {
                labels: dataForDate.values,
                datasets: [{
                    label: `Datos subidos en ${date}`,
                    data: dataForDate.labels.map(label => parseInt(label)),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            const configForDate = {
                type: 'bar',
                data: chartDataForDate,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.label}: ${dataForDate.labels[context.dataIndex]}`;
                                }
                            }
                        }
                    }
                }
            };

            requestAnimationFrame(() => {
                const ctxForDate = document.getElementById('scoreChart2').getContext('2d');
                if (chartInstanceMes) {
                    chartInstanceMes.destroy();
                    chartInstanceMes = null;
                }
                if (chartInstanceForDate) {
                    chartInstanceForDate.destroy();
                }
                chartInstanceForDate = new Chart(ctxForDate, configForDate);
            });

            // Crear botón para regresar a la gráfica inicial si no existe
            if (!backButton) {
                backButton = document.createElement('button');
                backButton.id = 'botonGrafica1';
                backButton.className = 'btn btn-primary btn-hover-azul';
                backButton.innerText = 'Regresar';
                backButton.onclick = () => {
                    if (chartInstanceForDate) {
                        chartInstanceForDate.destroy();
                        chartInstanceForDate = null;
                    }
                    loadChartMes();
                };
                document.getElementById('contentbutton').appendChild(backButton);
            }
        } else {
            console.error('Error en los datos para la fecha:', dataForDate ? dataForDate.messenger : 'No data');
        }
    }

    // Cargar las gráficas de manera asíncrona
    loadChartDia();
    loadChartMes();
})