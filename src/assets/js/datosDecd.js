

let tableInic = new DataTable("#tableInic",{
    responsive: true,
    processing: true,
    info: false,
    paging: true,
    lengthMenu: [2, 10, 25],
    pageLength: 10,
    language: {
        url: "./IdiomaEspañol.json"
      }
});

// Función para cambiar la URL del AJAX y recargar la tabla
function recargarTablaConNuevaURL(nuevaURL) {
    tableInic.ajax.url(nuevaURL).load();
}

$(document).on("click", "#switchDepe", function(){
    recargarTablaConNuevaURL("src/ajax/datosDecd.php?modulo_datos=ObtenerDatosDepe");
})
