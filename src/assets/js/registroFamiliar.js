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
      { "data": 5 }, // Cédula
      { "data": 0 }, // Nombre Y Apellido
      { "data": 1 }, // Estatus
      { "data": 3 }, // Dependencia
      { "data": 2 }, // Cargo
      { "data": 4 }, // Departamento
      { "data": 6 }  // Acciones O Botones
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

  // Evento click para los botones de familiar
  function personalFamiliar(idPersonal) {
    console.log(idPersonal);
    // Aquí puedes abrir el modal y pasar el idPersonal si es necesario
    $('#exampleModal').modal('show');
    // Puedes agregar lógica adicional aquí si necesitas pasar el idPersonal al modal
    let table2 = new DataTable('#myTable2', {
      responsive: true,
      ajax: {
        url: "./src/ajax/registroPersonal.php?modulo_personal=obtenerPersonal",
        type: "POST",
        data: function (d) {
          d.idPersonal = idPersonal; // Agrega el idPersonal a los datos enviados al servidor
        },
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
        { "data": 5 }, // Cédula
        { "data": 0 }, // Nombre Y Apellido
        { "data": 1 }, // Estatus
        { "data": 3 }, // Dependencia
        { "data": 2 }, // Cargo
        { "data": 4 }, // Departamento
        { "data": 6 }  // Acciones O Botones
      ]
    });  
  }
    
    $('#myTable').on('click', '.btn-familiar', function () {
      let idPersonal = $(this).data('id');
      personalFamiliar(idPersonal);
    });
  


});

