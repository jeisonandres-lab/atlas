
import {obtenerDatosJQuery} from "./ajax/formularioAjax.js";
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
                $('#totalArchivos').text(totalPersonal.archivos[0].totalArchivos);totalMedicamentos
                $('#atencionMedica').text(totalPersonal.atencionMedica[0].atencionMedica);personalAusencia
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
    
})

document.addEventListener('DOMContentLoaded', function () {
    fetch('src/ajax/totalDate.php?modulo_Datos=totalArchivosDia')
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                console.table(data);
                const chartData = {
                    labels: data.values, // Asegúrate de que los labels sean correctos
                    datasets: [{
                        label: 'My First Dataset',
                        data: data.labels, // Asegúrate de que los datos sean correctos
                        backgroundColor: [
                            'rgb(255, 99, 132)', // Rojo
                            'rgb(54, 162, 235)', // Azul
                            'rgb(255, 205, 86)', // Amarillo
                            'rgb(75, 192, 192)', // Verde azulado
                            'rgb(153, 102, 255)', // Morado
                            'rgb(255, 159, 64)', // Naranja
                            'rgb(255, 99, 132, 0.5)', // Rojo transparente
                            'rgb(54, 162, 235, 0.5)', // Azul transparente
                            'rgb(255, 205, 86, 0.5)', // Amarillo transparente
                            'rgb(75, 192, 192, 0.5)', // Verde azulado transparente
                            'rgb(153, 102, 255, 0.5)', // Morado transparente
                            'rgb(255, 159, 64, 0.5)'  // Naranja transparente
                          ],
                        hoverOffset: 4
                    }]
                };

                const config = {
                    type: 'bar',
                    data: chartData,
                    options: {
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const originalLabel = data.original_labels[context.dataIndex];
                                        return `${context.label}: ${originalLabel}`;
                                    }
                                }
                            }
                        }
                    }
                };

                const ctx = document.getElementById('scoreChart').getContext('2d');
                const scoreChart = new Chart(ctx, config);
            } else {
                console.error('Error en los datos:', data.messenger);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
});

document.addEventListener('DOMContentLoaded', function () {
    fetch('src/ajax/totalDate.php?modulo_Datos=totalArchivosMes')
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                console.table(data);
                const chartData = {
                    barPercentage: 0.5,
                    labels: data.values, // Asegúrate de que los labels sean correctos
                    datasets: [{
                        label: 'My First Dataset',
                        data: data.labels, // Asegúrate de que los datos sean correctos
                        backgroundColor: [
                            'rgb(255, 99, 132)', // Rojo
                            'rgb(54, 162, 235)', // Azul
                            'rgb(255, 205, 86)', // Amarillo
                            'rgb(75, 192, 192)', // Verde azulado
                            'rgb(153, 102, 255)', // Morado
                            'rgb(255, 159, 64)', // Naranja
                            'rgb(255, 99, 132, 0.5)', // Rojo transparente
                            'rgb(54, 162, 235, 0.5)', // Azul transparente
                            'rgb(255, 205, 86, 0.5)', // Amarillo transparente
                            'rgb(75, 192, 192, 0.5)', // Verde azulado transparente
                            'rgb(153, 102, 255, 0.5)', // Morado transparente
                            'rgb(255, 159, 64, 0.5)'  // Naranja transparente
                          ],
                        hoverOffset: 4
                    }]
                };

                const config = {
                    type: 'doughnut',
                    data: chartData,
                    options: {
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const originalLabel = data.original_labels[context.dataIndex];
                                        return `${context.label}: ${originalLabel}`;
                                    }
                                }
                            }
                        }
                    }
                };

                const ctx = document.getElementById('scoreChart2').getContext('2d');
                const scoreChart = new Chart(ctx, config);
            } else {
                console.error('Error en los datos:', data.messenger);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
});