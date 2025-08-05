
import { funcionAsync } from "../utils/formularioAjax.js";
import { animateNumberFromHTML } from "../utils/funciones.js";


$(async function () {

    // Funcion para obtener los datos de las cards
    async function obtenerDatosCards() {

        try {
            // Respuesta del servidor de los datos
            const respuestaDataCard = await funcionAsync("./src/routers/totalDate.php?modulo_Datos=totalDatos");

            // En caso que sea exitosa 
            if (respuestaDataCard.exito) {
                console.log(respuestaDataCard);
                $('#totalPersonal').text(respuestaDataCard.empleado[0].totalEmpleados);
                $('#totalArchivos').text(respuestaDataCard.archivos[0].totalArchivos);
                // $('#personalVacaciones').text(respuestaDataCard.vacaciones[0].totalVacaciones);
                // $('#personalAusencia').text(respuestaDataCard.ausencias[0].totalAusencias);

                // Card de total de personal
                animateNumberFromHTML('totalPersonal', 2000); // 2 segundos
                // Card de total de archivos
                animateNumberFromHTML('totalArchivos', 2000); // 3 segundos
                // Card de personal de vacaciones
                animateNumberFromHTML('personalVacaciones', 5000); // 3 segundos
                // Card de personal de ausencias
                animateNumberFromHTML('personalAusencia', 5000); // 3 segundos

            } else {
                console.error('la solitud no fue exitosa o tuvo un error');
            }

        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    }

   await obtenerDatosCards();
})