$(function () {
  let table = new DataTable('#myTable', {
    responsive: true,
    ajax: {
      url: "./src/ajax/registroPersonal.php?modulo_personal=obtenerPersonal",
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
    serverSide: true,
    info: false,
    order: [[0, 'desc']],
    paging: true,
    lengthMenu: [2, 10, 25],
    pageLength: 10,
    columnDefs: [
      {
        targets: 0,
        width: "7%"
        // render: function (data, type, userRow){
        // }
      }
    ],
    language: {
      url: "./IdiomaEspañol.json"
    },
    columns: [
      { "data": 0 }, // Primer Nombre + Primer Apellido
      { "data": 1 }, // Estatus
      { "data": 2 }, // Cargo
      { "data": 3 }, // Dependencia
      { "data": 4 }, // Departamento
      { "data": 5 }, // Cédula
      { "data": 6 }  // Botones de acción
    ]
  });

  // Función para cambiar la URL del AJAX y recargar la tabla
  function recargarTablaConNuevaURL(nuevaURL) {
    table.ajax.url(nuevaURL).load();
  }

  // Ejemplo de uso: cambiar la URL y recargar la tabla
  $('#botonCambiarURL').on('click', function () {
    let nuevaURL = "php/php_datatable/data-nuevaURL.php";
    recargarTablaConNuevaURL(nuevaURL);
  });
});