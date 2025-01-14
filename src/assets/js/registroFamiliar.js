import { aletaCheck } from "./ajax/alerts.js";
import { enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";
import {
  colocarMeses,
  colocarYear,
  limpiarFormulario,
  valdiarCorreos,
  validarBusquedaCedula,
  validarNombre,
  validarNumeros,
  validarSelectores,
  validarTelefono,
  file,
  limpiarInput,
} from "./ajax/inputs.js";

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

    // subDirs.forEach(subDir => {
    //   const filePath = `${baseDir}${subDir}/${doc}`;
    //   $.ajax({
    //     url: filePath,
    //     type: 'HEAD', // Usamos HEAD para verificar si el archivo existe sin descargarlo
    //     success: function () {
    //       if (!found) {
    //         found = true;
    //         console.log("Archivo encontrado en:", filePath);
    //         // Crear un enlace temporal para descargar el archivo
    //         const link = document.createElement('a');
    //         link.target = "_blank";
    //         link.href = filePath;
    //         document.body.appendChild(link);
    //         link.click();
    //         document.body.removeChild(link);
    //       }
    //     },
    //     error: function () {
    //       pendingRequests--;
    //       if (pendingRequests === 0 && !found) {
    //         alert("No se consiguió el archivo: " + doc);
    //       }
    //       // No imprimir el error en la consola
    //     }
    //   });
    // });
  }

  async function obtenerDatosAsync(url) {
    try {
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error(`Error en la solicitud: ${response.status} ${response.statusText}`);
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error al obtener los datos:', error);
      throw error; // Re-lanzar el error para que pueda ser manejado por el llamador
    }
  }

  async function editar(idPersonal) {
    console.log(idPersonal);

    let url_dependencias = "src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias";
    // try {
    //     const data = await obtenerDatosAsync(url_dependencias);
    //     if (data.exito && data.data) {
    //         llenarSelectDependencias(data.data);
    //     } else {
    //         console.error('Error al obtener dependencias o la estructura de la respuesta es incorrecta');
    //     }
    // } catch (error) {
    //     console.error('Error al obtener los datos:', error);
    // }
  }

  // async function llenarSelectDependencias(dependencias) {
  //     const select = document.getElementById('dependencia'); // Asegúrate de que el ID del select sea correcto
  //     if (!select) {
  //         console.error('El elemento select con el ID "dependencia" no se encontró en el DOM.');
  //         return;
  //     }
  //     select.innerHTML = ''; // Limpia el select antes de llenarlo
  //     dependencias.forEach(dependencia => {
  //         const option = document.createElement('option');
  //         option.value = dependencia.iddepartamento;
  //         option.text = dependencia.departamento;
  //         select.appendChild(option);
  //     });
  // }


  function eliminar(idPersonal) {
    console.log(idPersonal);
    let formData = new FormData();
    formData.append('id', idPersonal); // Añadir idPersonal al FormData

    function callbackExito(parsedData) {
      // Manejar la respuesta exitosa aquí
      console.log(parsedData);
      $('#myTable').DataTable().ajax.reload(null, false);
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


  $('#myTable').on('click', '.btn-familiar', function () {
    let idPersonal = $(this).data('id');
    personalFamiliar(idPersonal);
  });

  $('#myTable').on('click', '.btnEditar', function () {
    let idPersonal = $(this).data('id');
    editar(idPersonal);
  });

  $('#myTable').on('click', '.btnEliminar', function () {
    let idPersonal = $(this).data('id');
    eliminar(idPersonal);
  });


  $('#myTable2').on('click', '.botondocumet', function () {
    let doc = $(this).data('doc');
    DescargarDocumento(doc);
  });

  $(window).resize(function () {
    table.ajax.reload(null, false); // Recarga la tabla sin reiniciar la paginación
  });


  const cargando = document.getElementById('cargando');


  // formulario de empleados


  // formulario de empleado


  $("#meses").on("change", function () {
    const year = 2024; // Cambia el año si lo deseas
    const month = $("#meses").val();
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
      $("#dia").empty(); // Limpiar las opciones anteriores
      for (let i = 1; i <= daysInMonth; i++) {
        const diaFormateado = i.toString().padStart(2, "0");
        $("#dia").append(
          '<option value="' + diaFormateado + '">' + diaFormateado + "</option>"
        );
      }
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(".span_mes").removeClass("error_span");
      $(".span_mes").addClass("cumplido_span");
    }
  });

  $("#meses").trigger("input");
  validarSelectores("#dia", ".span_dia", "1");

  $("#formulario_registro").on("submit", function (e) {
    e.preventDefault();
    const data = new FormData(this);
    const url = "src/ajax/registroPersonal.php?modulo_personal=registrar";
    $("#aceptar").prop("disabled", true);

    function callbackExito(parsedData) {
      let dataerror = parsedData.error;
      $("#aceptar").prop("disabled", false);
      console.log(parsedData);
      if (parsedData.personalEncontrado) {
        $("#alerta").slideDown('slow', 'swing').delay(10000).slideUp();
      }
      else if (dataerror) {
        alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end")
      } else {
        alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end")
      }
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

  var boton = $('#aceptar'); // Reemplaza con el ID de tu botón
  // metodos para escuchar cambios en el dom y habilitar el boton de enviar formulario 
  // Función para verificar si todos los campos están cumplidos
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
        validarNombre("#primerNombre", ".span_nombre");
        validarNombre("#segundoNombre", ".span_nombre2");
        validarNombre("#primerApellido", ".span_apellido");
        validarNombre("#segundoApellido", ".span_apellido2");
        validarNumeros("#cedula", ".span_cedula");
        validarBusquedaCedula("#cedula", ["#img-modals", "#img-contener"]);
        validarSelectores("#civil", ".span_civil");
        validarSelectores("#ano", ".span_ano", "1");
        validarSelectores("#dia", ".span_dia", "1");
        valdiarCorreos("#correo", ".span_correo");
        colocarYear("#ano", "1900");
        colocarMeses("#meses");
        validarTelefono("#telefono", ".span_telefono");
        validarSelectores("#estatus", ".span_estatus");
        validarSelectores("#cargo", ".span_cargo");
        validarSelectores("#departamento", ".span_departamento");
        validarSelectores("#dependencia", ".span_dependencia");
        validarSelectores("#academico", ".span_academico");
        file("#contrato", ".span_contrato");
        file("#notificacion", ".span_notificacion");
        habilitarBoton();
      }
    }
  }, 300)); // Ajusta el tiempo de espera según sea necesario


  // Configurar el observer para observar cambios en los hijos y atributos del formulario
  const config = { childList: true, attributes: true, subtree: true };

  // Seleccionar el formulario y comenzar a observar
  const form = document.querySelector('form');
  observer.observe(form, config);


  $("#limpiar").on("click", function () {
    limpiarInput("#primerNombre", ".span_nombre");
    limpiarInput("#segundoNombre", ".span_nombre2");
    limpiarInput("#primerApellido", ".span_apellido");
    limpiarInput("#segundoApellido", ".span_apellido2");
    limpiarInput("#cedula", ".span_cedula");
    limpiarInput("#civil", ".span_civil");
    limpiarInput("#ano", ".span_ano");
    limpiarInput("#meses", ".span_mes");
    limpiarInput("#dia", ".span_dia");
    limpiarInput("#contrato", ".span_contrato");
    limpiarInput("#notificacion", ".span_notificacion");
    limpiarInput("#telefono", ".span_telefono");
    limpiarInput("#estatus", ".span_estatus");
    limpiarInput("#cargo", ".span_cargo");
    limpiarInput("#departamento", ".span_departamento");
    limpiarInput("#dependencia", ".span_dependencia");
    limpiarInput("#academico", ".span_academico");
    $(".imgFoto").remove();
  });

});
