import {  AlertSW2 } from "./ajax/alerts.js";
import { descargarArchivo, obtenerDatos, obtenerDatosJQuery} from "./ajax/formularioAjax.js";
import {
    colocarNivelesEducativos,
    incluirSelec2,
    validarSelectoresSelec2,
    validarNumeroNumber,
    validarInputFecha,

} from "./ajax/inputs.js";
$(function () {

    $(document).on("click", '.reporteTrabajador', async function (event) {
        event.preventDefault();
        const href = $(this).attr('href');
      
        $.ajax({
            url: './src/views/personal/reporteFamiliar.php',
            type: 'GET',
            dataType: 'html',
            data: { tipo: href }, // O 'excel'
            beforeSend: function () {
                AlertSW2("info", "Cargando datos del reporte...", "top",); // Cambié "error" a "info" para mayor claridad
            },
            success: function (html) {
                Swal.close(); // Cierra la alerta SweetAlert2
                // $("#datosReporte").prop("hidden", false);
                $("#datosReporte").removeAttr("hidden");
                $('#contentBodyCard2').html(html);
                if (href == 'pdf') {
                    $("#cabeza-reporte").html('Generar Reporte PDF');
                    $("#descargarReporte2").addClass('btn-danger btn-hover-rojo');
                    $("#descargarReporte2").removeClass('btn-success btn-verde-rojo');
                    $("#descargarReporte2").html('<i class="fa-regular fa-file-pdf fa-sm me-2"></i>Descargar PDF');
                    
                }else{
                    $("#cabeza-reporte").html('Generar Reporte EXCEL');
                    $("#descargarReporte2").removeClass('btn-danger btn-hover-rojo');
                    $("#descargarReporte2").addClass('btn-success btn-hover-verde');
                    $("#descargarReporte2").html('<i class="fa-regular fa-table fa-sm me-2"></i>Descargar EXCEL');
        
                }
                $('#datosReporte').slideDown(500, function () {
                    $('#datosReporte').animate({
                        transform: 'scale(1)'
                    }, 350, function () {

                        $('html, body').animate({
                            scrollTop: $('#contentReport')[0].scrollIntoView({ behavior: 'smooth' })
                        }, 800);


                        incluirSelec2("#sexo_filtar");
                    });
                });
            },
            error: function (error) {
                Swal.close(); // Cierra la alerta SweetAlert2
                console.error('Error al cargar el contenido:', error);
                AlertSW2("error", "Error al cargar el reporte", "top", 5000); // Muestra un mensaje de error
            }
        });



    })
});