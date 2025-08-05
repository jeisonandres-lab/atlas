/**
 * Inicializa una tabla de datos.
 * @param {string} url - La URL del endpoint para obtener los datos.
 * @param {string} selector - El selector CSS de la tabla.
 * @param {object} options - Opciones adicionales para la tabla.
 */
// datatable.js
export async function inicializarDataTable(selector, options, cantidadPaginas = 5, url ) {
    // Puedes definir opciones por defecto aquí si quieres
    const configuracionDefecto = {
        // responsive: true,
        processing: true,
        serverSide: true,
        info: false,
        lengthMenu: [2, 10, 25],
        pageLength: cantidadPaginas,
        ajax: {
            url: url,
            type: "POST",
            dataSrc: function (json) {
                if (json.data) {
                    return json.data;
                } else {
                    console.error('Estructura de datos incorrecta:', json);
                    return [];
                }
            }
        },
        language: {
            url: "./IdiomaEspañol.json"
        },
        // Otras opciones que quieras aplicar a todas las tablas
    };

    // Combinar las opciones por defecto con las opciones específicas de la vista
    const congifuracionFinal = { ...configuracionDefecto, ...options };
    // console.log(congifuracionFinal)
    return new DataTable(selector, congifuracionFinal);
}