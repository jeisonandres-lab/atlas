
import { AlertSW2 } from "./ajax/alerts.js";
import { obtenerDatosJQuery } from "./ajax/formularioAjax.js";
import { BaseDataTable } from "./class/BaseTablet.js";
// Dependencias: jQuery, DataTables. Gráficos: homeCharts.js (ApexCharts)
$(function () {

    const tableUsuarios = new BaseDataTable('#tableUsers', {
        url: "./src/ajax/userAjax.php?modulo_usuario=DatosUsuarios",
        columnDefs: [
            {
                targets: 0, // Estado (Badge con icono)
                className: 'dt-center',
                render: function (data, type, row) {
                    // Definimos la configuración según el valor de 'data'
                    let config = {
                        1: { clase: 'badge success', icono: 'fa-solid fa-check' },
                        2: { clase: 'badge danger', icono: 'fa-solid fa-x' },
                        3: { clase: 'badge warning', icono: 'fa-regular fa-triangle-exclamation' }
                    };

                    // Obtenemos la configuración o valores por defecto por si llega un dato raro
                    let res = config[data] || { clase: 'badge secondary', icono: 'fa-question' };

                    return `<div class="d-flex align-items-center justify-content-center">
                                 <span class="rounded-circle circulop ${res.clase} d-flex align-items-center justify-content-center">
                                    <i class="fa-light ${res.icono}"></i>
                                 </span>
                            </div>
                            `;
                }
            },
            {
                targets: 1, // Cliente (Avatar + Datos)
                render: (data, type, row) => `
                <div class="container-fluid d-flex gap-3 align-items-center">
                    <img src="./src/global/photos/${row[1].cedula}.png" class="circulo-tablet" onerror="this.src='./src/global/photos/default.png'"/>
                    <div class="d-flex flex-column ">
                        <span class="">${row[1].nombre}</span>
                        <small class="user-email text-muted">jeisonandres12@gmail.com</small>
                    </div>
                </div>`
            },
            {
                targets: 2, // Rol (Badge pastel)
                render: function (data) {
                    return `<span class="badge">${data}</span>`;
                }
            },
            // {
            //     targets: 3, // Acciones (Iconos uno al lado del otro)
            //     className: 'text-center',
            //     render: function () {
            //         return `
            //     <div class="action-icons">
            //         <a href="#" ><i class="fa-regular fa-trash-can"></i></a>
            //         <a href="#" ><i class="fa-regular fa-user-pen"></i></a>
            //     </div>`;
            //     }
            // }
        ],
    });

    // Conectamos el buscador que ya tienes en el HTML
    tableUsuarios.bindSearch('#homeUsersSearch');

    // Abrir/Cerrar menú dropdown
    $('#dropdownBtn').on('click', function(e) {
        $('#customDropdown').toggle();
    });

    // Al hacer clic en una opción del dropdown
    $('.dropdown-item').on('click', function(e) {
        e.stopPropagation(); // Evitar que el evento llegue al document
        console.log('Clic en item:', $(this).data('value')); // Para depurar
        var valor = $(this).data('value');
        
        // 1. Actualizar texto del botón
        $('#currentValue').text(valor);
        
        // 2. Cambiar clase seleccionada (el check visual)
        $('.dropdown-item').removeClass('selected').find('.check').remove();
        $(this).addClass('selected').append('<span class="check"><i class="fa-regular fa-check"></i></span>');
        
        // 3. Actualizar DataTable usando el método de la clase
        tableUsuarios.pageLengthChange(valor);
        
        // 4. Cerrar menú
        $('#customDropdown').hide();
    });

    // Cerrar si se hace clic fuera
    $(document).click(function(e) {
        if (!$(e.target).closest('.select_customDropdown').length) {
            console.log('Clic fuera, cerrando menú'); // Para depurar
            $('#customDropdown').hide();
        }
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