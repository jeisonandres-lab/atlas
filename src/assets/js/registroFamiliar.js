import { alertaNormalmix, AlertSW2, aletaCheck } from "./ajax/alerts.js";
import { enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";
import {
  colocarMeses,
  colocarYear,
  valdiarCorreos,
  validarNombre,
  validarNumeros,
  validarSelectores,
  validarTelefono,
  file,
  limpiarInput,
  colocarNivelesEducativos,
  clasesInputs,
} from "./ajax/inputs.js";

$(function () {
  validarNombre("#primerNombre", ".span_nombre");
  validarNombre("#segundoNombre", ".span_nombre2");
  validarNombre("#primerApellido", ".span_apellido");
  validarNombre("#segundoApellido", ".span_apellido2");
  validarNumeros("#cedulaEdi", ".span_cedula");
  validarSelectores("#civil", ".span_civil");
  validarSelectores("#ano2", ".span_ano", "1");
  validarSelectores("#dia2", ".span_dia", "1");
  valdiarCorreos("#correo", ".span_correo");
  validarTelefono("#telefono", ".span_telefono");
  validarSelectores("#estatus", ".span_estatus");
  validarSelectores("#cargo", ".span_cargo");
  validarSelectores("#departamento", ".span_departamento");
  validarSelectores("#dependencia", ".span_dependencia");
  validarSelectores("#academico", ".span_academico");
  file("#contrato", ".span_contrato");
  file("#notificacion", ".span_notificacion");
  colocarYear("#ano2", "1900");
  colocarMeses("#meses2");
  colocarNivelesEducativos("#academico");


  const cargando = document.getElementById('cargando');
  var boton = $('#aceptar');

  function limpiarDatos() {
    limpiarInput("#primerNombre", ".span_nombre");
    limpiarInput("#segundoNombre", ".span_nombre2");
    limpiarInput("#primerApellido", ".span_apellido");
    limpiarInput("#segundoApellido", ".span_apellido2");
    limpiarInput("#cedulaEdi", ".span_cedula");
    limpiarInput("#civil", ".span_civil");
    limpiarInput("#contrato", ".span_contrato");
    limpiarInput("#notificacion", ".span_notificacion");
    limpiarInput("#telefono", ".span_telefono");
    limpiarInput("#estatus", ".span_estatus");
    limpiarInput("#cargo", ".span_cargo");
    limpiarInput("#departamento", ".span_departamento");
    limpiarInput("#dependencia", ".span_dependencia");
    // limpiarInput("#ano2", ".span_ano");
    // limpiarInput("#meses2", ".span_mes");
    // limpiarInput("#dia2", ".span_dia");
    // limpiarInput("#academico", ".span_academico");
  }

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

  // Evento click para los botones de familiar
  function personalFamiliar(idPersonal) {
    console.log(idPersonal);
    // Aquí puedes abrir el modal y pasar el idPersonal si es necesario
    $('#exampleModal').modal('show');

    // Destruir el DataTable existente si ya ha sido inicializado
    if ($.fn.DataTable.isDataTable('#myTable2')) {
      $('#myTable2').DataTable().destroy();
    }

    // Inicializar el DataTable con el nuevo idPersonal
    let table2 = new DataTable('#myTable2', {
      responsive: true,
      ajax: {
        url: "./src/ajax/registroPersonal.php?modulo_personal=obtenerFamiliar",
        type: "POST",
        data: { id: idPersonal },
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
          targets: 1,
          width: "8%",
          class: "text-center",
          render: function (data, type, row) {
            return data ? data : 'No Cédulado';
          }
        },
        {
          targets: 2,
          class: "text-center",
          render: function (data, type, row) {
            return data ? data : 'Sin Discapacidad';
          }
        },
        {
          targets: 3,
          width: "8%",
          class: "text-center",
          render: function (data, type, row) {
            return data + " Años";
          }
        },
        {
          targets: 4,
          class: "text-center",
          render: function (data, type, row) {
            return data ? data : 'Sin Tomo';
          }
        },
        {
          targets: 5,
          class: "text-center",
          render: function (data, type, row) {
            return data ? data : 'Sin Folio';
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
        { "data": 3 }, // Dependencia
        { "data": 4 }, // Cargo
        { "data": 5 }, // Departamento
        { "data": 6 },
        { "data": 7 },
      ]
    });
  }

  function DescargarDocumento(doc) {
    console.log("Documento a descargar:", doc);
    const baseDir = './src/global/archives/personal/familiares/';
    const subDirs = ['partidasDiscapacidad', 'partidasNacimiento']; // Lista de subdirectorios conocidos

    let found = false;
    let pendingRequests = subDirs.length;
    // Ejemplo de uso
    Swal.bindClickHandler();
    /* Bind a mixin to a click handler */
    Swal.mixin({
      toast: true
    }).bindClickHandler("data-swal-toast-template");


    $('#saveButton').on('click', function () {
      let cedula = $(this).data('cedula');
    })

    subDirs.forEach(subDir => {
      const filePath = `${baseDir}${subDir}/${doc}`;
      $.ajax({
        url: filePath,
        type: 'HEAD', // Usamos HEAD para verificar si el archivo existe sin descargarlo
        success: function () {
          if (!found) {
            found = true;
            console.log("Archivo encontrado en:", filePath);
            // Crear un enlace temporal para descargar el archivo
            const link = document.createElement('a');
            link.target = "_blank";
            link.href = filePath;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          }
        },
        error: function () {
          pendingRequests--;
          if (pendingRequests === 0 && !found) {
            alert("No se consiguió el archivo: " + doc);
          }
          // No imprimir el error en la consola
        }
      });
    });
  }

  function obtenerDatosJQuery(url, options = {}) {
    let formData = new FormData();
    for (let key in options) {
      formData.append(key, options[key]);
    }

    return $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json'
    });
  }
  function editar(idPersonal) {
    
    console.log(idPersonal);
    let urls = [
      "src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerCargo",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal"
    ];

    let options = { cedulaEmpleado: idPersonal };
    let requests = urls.map((url, index) => {
      if (index === 4) { // Suponiendo que quieres pasar `options` solo a la primera solicitud
        return obtenerDatosJQuery(url, options);
      } else {
        return obtenerDatosJQuery(url);
      }
    });
    $.when(...requests).done((dependencias, estatus, cargo, departamento, datosPersonal) => {


      if (dependencias[0].exito && dependencias[0].data) {
        llenarSelectDependencias(dependencias[0].data, 'dependencia');
        
      } else {
        console.error('Error al obtener dependencias o la estructura de la respuesta es incorrecta');
      }

      if (estatus[0].exito && estatus[0].data) {
        llenarSelectDependencias(estatus[0].data, 'estatus');
      } else {
        console.error('Error al obtener los estatus o la estructura de la respuesta es incorrecta');
      }

      if (cargo[0].exito && cargo[0].data) {
        llenarSelectDependencias(cargo[0].data, 'cargo');
      } else {
        console.error('Error al obtener los cargos o la estructura de la respuesta es incorrecta');
      }

      if (departamento[0].exito && departamento[0].data) {
        llenarSelectDependencias(departamento[0].data, 'departamento');
      } else {
        console.error('Error al obtener departamento o la estructura de la respuesta es incorrecta');
      }

      if (datosPersonal[0].exito) {
        $("#primerNombre").val(datosPersonal[0].nombre);
        $("#segundoNombre").val(datosPersonal[0].segundoNombre);
        $("#primerApellido").val(datosPersonal[0].apellido);
        $("#segundoApellido").val(datosPersonal[0].segundoApellido);
        $("#cedulaEdi").val(datosPersonal[0].cedula);
        $("#telefono").val(datosPersonal[0].telefono);
        $("#civil").val(datosPersonal[0].estadoCivil);
        $("#dependencia").val(datosPersonal[0].dependencia);

        // llevarOptionIndividual(datosPersonal[0].dependencia, 'dependencia', datosPersonal[0].iddependencia);
        // se marcar cumplido logrado y se marcar span cumplido logrado 
        // $("cedula_trabajador").addClass("cedulaBusqueda"); 
        clasesInputs("#primerNombre", ".span_nombre");
        clasesInputs("#segundoNombre", ".span_nombre2");
        clasesInputs("#primerApellido", ".span_apellido");
        clasesInputs("#segundoApellido", ".span_apellido2");
        clasesInputs("#cedulaEdi", ".span_cedula");
        clasesInputs("#telefono", ".span_telefono");
        clasesInputs("#civil", ".span_civil");

        
      } else {
        console.error('Error al obtener datos personales o la estructura de la respuesta es incorrecta');
      }
    }).fail((jqXHR, textStatus, errorThrown) => {
      console.error('Error al obtener los datos:', textStatus, errorThrown);
    });
  }

  async function llenarSelectDependencias(data, selectId) {
    const select = document.getElementById(selectId);
    console.log(data);
    // Asegúrate de que el ID del select sea correcto
    if (!select) {
      console.error(`El elemento select con el ID "${selectId}" no se encontró en el DOM.`);
      return;
    }

    data.forEach(item => {
      const option = document.createElement('option');
      option.value = item.id;
      option.text = item.value;
      select.appendChild(option);
    });
  }
  // select.remove(i);
  async function llevarOptionIndividual(data, selectId, idnumber) {
    const select = document.getElementById(selectId);
    const options = select.options;
  
    // Crear la nueva opción
    const option = document.createElement('option');
    option.value = idnumber;
    option.text = data;
    option.classList.add('new-option'); // Añadir clase para fondo rojo
  
    // Insertar la opción al principio
    select.insertBefore(option, select.firstChild);

  }

  function eliminar(idPersonal) {
    console.log(idPersonal);
    let formData = new FormData();
    formData.append('id', idPersonal); // Añadir idPersonal al FormData

    function callbackExito(parsedData) {
      // Manejar la respuesta exitosa aquí
      $('#myTable').DataTable().ajax.reload(null, false);
      AlertSW2("success", "Empleado Eliminado Con exito", "top", 3000);

    }

    function enviar() {
      let destino = "src/ajax/registroPersonal.php?modulo_personal=eliminarPersonal";
      let url = destino;
      enviarFormulario(url, formData, callbackExito, true);
    }
    // parametros para la alerta
    let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
    let icons = 'warning';
    let position = 'center';

    aletaCheck(messenger, icons, position, enviar);
  }

  function eliminarFamiliar(idPersonal) {
    console.log(idPersonal);
    let formData = new FormData();
    formData.append('id', idPersonal); // Añadir idPersonal al FormData

    function callbackExito(parsedData) {
      // Manejar la respuesta exitosa aquí
      $('#myTable').DataTable().ajax.reload(null, false);
      AlertSW2("success", "Empleado Eliminado Con exito", "top", 3000);

    }

    function enviar() {
      let destino = "src/ajax/registroPersonal.php?modulo_personal=eliminarFamiliar";
      let url = destino;
      enviarFormulario(url, formData, callbackExito, true);
    }
    // parametros para la alerta
    let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
    let icons = 'warning';
    let position = 'center';

    aletaCheck(messenger, icons, position, enviar);
  }

  function todosCumplidos() {
    const elementosCumplidos = $('form input, form select').filter('.cumplido, .cumplidoNormal');
    return elementosCumplidos.length === $('form input, form select').length;
  }

  // Función para habilitar o deshabilitar el botón
  function habilitarBoton() {
    boton.prop('disabled', !todosCumplidos());
  }

  // Función de debounce para limitar la frecuencia de ejecución
  function debounce(func, wait) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }

  // Crear una instancia de MutationObserver y observar cambios
  const observer = new MutationObserver(debounce((mutationsList, observer) => {
    for (const mutation of mutationsList) {
      if (mutation.type === 'childList' || mutation.type === 'attributes') {
        // formulario de registro
        habilitarBoton();
      }
    }
  }, 300)); // Ajusta el tiempo de espera según sea necesario


  // Configurar el observer para observar cambios en los hijos y atributos del formulario
  const config = { childList: true, attributes: true, subtree: true };

  // Seleccionar el formulario y comenzar a observar
  const form = document.querySelector('form');
  observer.observe(form, config);

  $('#myTable').on('click', '.btn-familiar', function () {
    let idPersonal = $(this).data('id');
    personalFamiliar(idPersonal);
  });

  $('#myTable').on('click', '.btnEditar', function () {
    let idPersonal = $(this).data('cedula');
    editar(idPersonal);
  });

  $('#myTable').on('click', '.btnEliminar', function () {
    let idPersonal = $(this).data('id');
    eliminar(idPersonal);
  });

  $('#myTable2').on('click', '.btnEliminar', function () {
    let idPersonal = $(this).data('id');
    eliminarFamiliar(idPersonal);
  });

  $('#myTable2').on('click', '.botondocumet', function () {
    let doc = $(this).data('doc');
    DescargarDocumento(doc);
  });

  // $('#formularioActualizar').on("submit", function (event) {
  //   event.preventDefault();
  //   const formData = new FormData(this);
  //   const accion = $(this).find('button[type="submit"]:focus').attr('name');
  //   console.log(accion)

  //     function callbackExito(parsedData) {
  //     }
  //     let destino = "src/ajax/registroPersonal.php?modulo_personal=actualizarPersonal";
  //     let url = destino;
  //     enviarFormulario(url, formData, callbackExito, true);

  // });

  $(window).resize(function () {
    table.ajax.reload(null, false); // Recarga la tabla sin reiniciar la paginación
  });

  $("#meses2").on("change", function () {
    const year = 2024; // Cambia el año si lo deseas
    const month = $("#meses2").val();
    if (month == "") {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(".span_mes").removeClass("cumplido_span");
      $(".span_mes").addClass("error_span");
    } else {
      // Eliminar el cero inicial si existe
      const monthWithoutLeadingZero = month.replace(/^0+/, "");
      // Obtener el número de días en el mes seleccionado
      const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate(); // Restamos 1 al mes porque JavaScript cuenta los meses desde 0
      // Generar las opciones de los días
      $("#dia2").empty(); // Limpiar las opciones anteriores
      for (let i = 1; i <= daysInMonth; i++) {
        const diaFormateado = i.toString().padStart(2, "0");
        $("#dia2").append(
          '<option value="' + diaFormateado + '">' + diaFormateado + "</option>"
        );
      }
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(".span_mes").removeClass("error_span");
      $(".span_mes").addClass("cumplido_span");
    }
  });

  $("#meses2").trigger("input");
  validarSelectores("#dia2", ".span_dia", "1");

  $("#formularioActualizar").on("submit", function (e) {
    e.preventDefault();
    const data = new FormData(this);
    const url = "src/ajax/registroPersonal.php?modulo_personal=actualizarPersonal";
    $("#aceptar").prop("disabled", true);

    function callbackExito(parsedData) {
      let dataerror = parsedData.error;
      $("#aceptar").prop("disabled", false);
      console.log(parsedData);
      if (parsedData.exito) {
        AlertSW2("success", "Empleado Actualizado Con Exito", "top-end", 3000);
      } else {
        alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end")
      }
      // else if (dataerror) {
      //   alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end")
      // } else {
      //   alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end")
      // }
      // const myModal = new bootstrap.Modal(document.getElementById('modal'));
      // myModal.show();
    }
    enviarFormulario(url, data, callbackExito, true);
  });


  $("#noCedula").on("change", function () {
    if ($(this).is(":checked")) {
      $("#disca").prop("checked", false);
    }
  });

  $("#disca").on("change", function () {
    if ($(this).is(":checked")) {
      $("#noCedula").prop("checked", false);
    }
  });

  $(".cerrarEditar").on("click", function () {
    limpiarDatos();
  });
  $("#limpiar").on("click", function () {
    limpiarDatos();
  });

});
