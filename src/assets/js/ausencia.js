import { alertaNormalmix, AlertSW2, aletaCheck } from "./utils/alerts.js";
import { descargarArchivo, enviarFormulario } from "./utils/formularioAjax.js";
import { clasesInputs, incluirSelec2, validarNumeros, validarSelectores, validarSelectoresSelec2 } from "./utils/inputs.js";

$(function () {
  let boton = document.querySelector("#aceptar");

  $(document).on("input", function () {
    validarNumeros("#cedula", ".span_cedula");
    incluirSelec2("#permiso");
    validarSelectoresSelec2("#permiso", ".span_permiso");
    validarSelectores("#permiso", ".span_permiso");
    validarSelectores("#fecha_ini", ".span_fecha_ini");
    validarSelectores("#fecha_fin", ".span_fecha_fin");

    //FORMULARIO EDITAR
    validarNumeros("#cedula2", ".span_cedula2");
    incluirSelec2("#permiso2");
    validarSelectoresSelec2("#permiso2", ".span_permiso2");
    validarSelectores("#permiso2", ".span_permiso2");
    validarSelectores("#fecha_ini2", ".span_fecha_ini2");
    validarSelectores("#fecha_fin2", ".span_fecha_fin2");
  });

  $('#cedula').on('input', function () {
    const cedula = $(this).val();
    const imagePath = `./src/global/archives/photos/${cedula}.png`;

    // Verificar si la imagen existe
    $.ajax({
      url: imagePath,
      type: 'HEAD',
      processData: true,
      success: function () {
        // Si la imagen existe, crear la etiqueta de imagen y agregarla al div con la clase content
        const imgTag = `<img src="${imagePath}" class="img-fluid imFoto w-100 h-100" alt="Foto de ${cedula}">`;
        $('#img-contener').html(imgTag);
      },
      error: function () {
        // Si la imagen no existe, mostrar un mensaje de error o una imagen por defecto
        $('#img-contener').html('<p>No se consiguió la imagen</p>');
      }
    });
  });

  // Función para buscar datos
  function buscarDatos() {
    const valor = $("#cedula").val();
    if (valor.length >= 7) {
      function callbackExito(parsedData) {
        if (parsedData.exito == true) {
          let nombre = parsedData.nombre;
          let apellido = parsedData.apellido;
          let cargo = parsedData.cargo;
          let idEmpleado = parsedData.idEmpleado;

          // si tiene marcado error
          $("#primerNombre").removeClass("error_input");
          $("#primerApellido").removeClass("error_input");
          $("#cargo").removeClass("error_input");
          $(".span_nombre").removeClass("error_span");
          $(".span_apellido").removeClass("error_span");
          $(".span_cargo").removeClass("error_span");
          // se marcar cumplido logrado
          $("#cedula").addClass("cedulaBusqueda");
          $("#primerNombre").addClass("cumplido");
          $("#primerApellido").addClass("cumplido");
          $("#cargo").addClass("cumplido");

          $(".span_nombre").addClass("cumplido_span");
          $(".span_apellido").addClass("cumplido_span");
          $(".span_cargo").addClass("cumplido_span");

          $("#primerNombre").val(nombre);
          $("#primerApellido").val(apellido);
          $("#cargo").val(cargo);
          $("#identificador").val(idEmpleado);

          alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
        } else {
          $("#nombreEmpleado").val("");
          $("#apellidoEmpleado").val("");
          $("#nombreEmpleado").removeClass("cumplido");
          $("#apellidoEmpleado").removeClass("cumplido");
          $(".span_nombre").removeClass("cumplido_span");
          $(".span_apellido").removeClass("cumplido_span");
          alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
        }
      }
      if ($(this).val().length >= 7) {
        const datoCedula = $(this).val();
        const formData = new FormData(); // Crea un nuevo objeto FormData
        formData.append('cedulaEmpleado', datoCedula);
        enviarFormulario("src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal", formData, callbackExito, true);
      }
    }
  }

  // Aplicar debounce a la función de búsqueda
  const buscarDatosDebounced = debounce(buscarDatos, 200);

  $("#cedula").on("input", buscarDatosDebounced);
  $("#cedula2").on("input", buscarDatosDebounced);

  $(document).on("change", "#fecha_ini, #fecha_fin", function () {
    let fechaInicio = $("#fecha_ini").val();
    let fechaFin = $("#fecha_fin").val();
    if (!fechaInicio && !fechaFin) {
      alert("Por favor, seleccione la fecha de inicio y la fecha de fin.");
    } else if (!fechaInicio) {
      $("#alerta").text("Selecionar la fecha de inicio");
      $("#alerta").slideDown('slow', 'swing').delay(10000).slideUp();
    } else if (!fechaFin) {
      $("#alerta").text("Selecionar la fecha final");
      $("#alerta").slideDown('slow', 'swing').delay(10000).slideUp();
    } else {
      // Ambos campos tienen contenido, puedes continuar con tu lógica aquí
      if (fechaInicio > fechaFin) {
        // REMOVER CLASES CUMPLIDAS
        $("#fecha_ini, #fecha_fin").removeClass("cumplido error_input");
        $(".span_fecha_ini, .span_fecha_fin").removeClass("cumplido_spnan error_span");

        // AÑADIR LAS CLASES DE FALLIDO
        $("#fecha_ini, #fecha_fin").addClass("error_input");
        $(".span_fecha_ini, .span_fecha_fin").addClass("error_span");
        $("#alerta").text("La fecha inicio el mayor a la fecha final");
        $("#alerta").slideDown('slow', 'swing').delay(10000).slideUp();
      } else {
        // REMOVER CLASES CUMPLIDAS
        $("#fecha_ini, #fecha_fin").removeClass("cumplido error_input");
        $(".span_fecha_ini, .span_fecha_fin").removeClass("cumplido_spnan error_span");

        // AÑADIR LAS CLASES DE FALLIDO
        $("#fecha_ini, #fecha_fin").addClass("cumplido");
        $(".span_fecha_ini, .span_fecha_fin").addClass("cumplido_spnan");
        $("#alerta").slideUp().hide();
      }
    }

  });

  $(document).on("change", "#fecha_ini2, #fecha_fin2", function () {
    let fechaInicio = $("#fecha_ini2").val();
    let fechaFin = $("#fecha_fin2").val();
    if (!fechaInicio && !fechaFin) {
      alert("Por favor, seleccione la fecha de inicio y la fecha de fin.");
    } else if (!fechaInicio) {
      $("#alerta2").text("Selecionar la fecha de inicio");
      $("#alerta2").slideDown('slow', 'swing').delay(10000).slideUp();
    } else if (!fechaFin) {
      $("#alerta2").text("Selecionar la fecha final");
      $("#alerta2").slideDown('slow', 'swing').delay(10000).slideUp();
    } else {
      // Ambos campos tienen contenido, puedes continuar con tu lógica aquí
      if (fechaInicio > fechaFin) {
        // REMOVER CLASES CUMPLIDAS
        $("#fecha_ini2, #fecha_fin2").removeClass("cumplido error_input");
        $(".span_fecha_ini2, .span_fecha_fin2").removeClass("cumplido_spnan error_span");

        // AÑADIR LAS CLASES DE FALLIDO
        $("#fecha_ini2, #fecha_fin2").addClass("error_input");
        $(".span_fecha_ini2, .span_fecha_fin2").addClass("error_span");
        $("#alerta2").text("La fecha inicio el mayor a la fecha final");
        $("#alerta2").slideDown('slow', 'swing').delay(10000).slideUp();
      } else {
        // REMOVER CLASES CUMPLIDAS
        $("#fecha_ini, #fecha_fin").removeClass("cumplido error_input");
        $(".span_fecha_ini2, .span_fecha_fin2").removeClass("cumplido_spnan error_span");

        // AÑADIR LAS CLASES DE FALLIDO
        $("#fecha_ini2, #fecha_fin2").addClass("cumplido");
        $(".span_fecha_ini2, .span_fecha_fin2").addClass("cumplido_spnan");
        $("#alerta2").slideUp().hide();
      }
    }

  });

  $("#formAusento").on('submit', async function (e) {
    e.preventDefault();
    let data = new FormData(this);
    async function callbackExito(parametros) {
      if (parametros.exito) {
        alertaNormalmix(parametros.messenger, 4000, "success", "top-end");
      } else {
        alertaNormalmix(parametros.messenger, 4000, "error", "top-end");
      }
    }
    enviarFormulario("./src/ajax/vacaciones.php?modulo_datos=registrarAusencia", data, callbackExito, 1)
  })

  $("#formEditarAusencia").on('submit', async function (Evento) {
    Evento.preventDefault();
    let data = new FormData(this);
    async function callbackExito(parametros) {
      if (parametros.exito) {
        alertaNormalmix(parametros.messenger, 4000, "success", "top-end");
      } else {
        alertaNormalmix(parametros.messenger, 4000, "error", "top-end");
      }
    }
    enviarFormulario("./src/ajax/vacaciones.php?modulo_datos=actualizarAusencia", data, callbackExito, 1)
  })
  let fechaActual;

  function obtenerFechaActual() {
    const fechaLocal = new Date();
    const opciones = { day: '2-digit', month: '2-digit', year: 'numeric' };
    return fechaLocal.toLocaleDateString('es-ES', opciones).replace(/\//g, '-'); // Usa la fecha local con guiones
  }

  function liberarAusencia(tg) {
    console.log('Liberar ausencia:'+ tg  );
  }
  // Obtener la fecha actual al cargar la página

  let table;
  $("#verAusencia").on('click', function () {
    if (!$.fn.DataTable.isDataTable('#myTable')) {
      table = new DataTable('#myTable', {
        responsive: true,
        ajax: {
          url: "./src/ajax/vacaciones.php?modulo_datos=todasAusencias",
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
        searching: true,
        serverSide: true,
        info: false,
        order: [[0, 'desc']],
        paging: true,
        lengthMenu: [5, 10, 25],
        pageLength: 5,
        language: {
          url: "./IdiomaEspañol.json"
        },
        columnDefs: [
          {
            targets: 1, 
            className: 'text-end',
            render: function (data, type, row, meta) {
              $(data).removeClass('dt-type-numeric');
              return `<span class='text-end'>${data}</span>`;;
            }
          },
          {
            targets: 3, 
            className: 'text-end',
          },
          {
            targets:  4, 
            className: 'text-end',
            render: function (data, type, row, meta) {
              // Separar la fecha y los permisos de data
              const fecha = data;
              const fechaActual = obtenerFechaActual();

              // Calcular la diferencia de días entre la fecha de data y la fecha actual
              const fechaData = new Date(fecha.split('-').reverse().join('-'));
              const fechaActualDate = new Date(fechaActual.split('-').reverse().join('-'));
              const diferenciaDias = Math.ceil((fechaData - fechaActualDate) / (1000 * 60 * 60 * 24));

              // Aplicar diferentes colores según la proximidad de la fecha
              let colorClase = 'text-success'; // Verde por defecto
              if (diferenciaDias <= 3) {
                colorClase = 'text-warning'; 
                var span = `<span class="${colorClase}">${fecha}</span>`;
                // Rojo si está muy cerca (2 o 3 días antes)
              } else if (diferenciaDias <= 7) {
                colorClase = 'text-sucess';
                var span = `<span class="${colorClase}">${fecha}</span>`; // Naranja si está cerca (menos de una semana)
              }
              
              if (fechaData >= fechaActualDate) {
                colorClase = 'text-danger';
                var span = `<span class="${colorClase}">${fecha}</span>`;
                // var span = `<small class='d-inline-flex px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>Liberar</small>`;
              }
              return span;
            }
          },
          {
            targets:  2, 
            className: 'text-end',
            render: function (data, type, row, meta) {
              // Separar la fecha y los permisos de data
              const permiso = data;
              let colorClase = 'text-success'; // Verde por defecto

              // Actualizar el contenido de la celda
              return `<span class="${colorClase}">${permiso}</span>`;
            }
          },
          {
            targets:  5, 
            className: 'd-flex justify-content-end',
          },
        ],
        layout: {
          topStart: {
            pageLength: 10,
            buttons: [
              {
                extend: 'pdf', // Extensión para generar PDF
                text: '<i class="bi bi-file-earmark-pdf-fill"></i>', // Texto del botón (con icono)
                className: 'pdf btn buttonRojo p-2 pe-3 ps-3', // Clases CSS para el botón
                titleAttr: 'Descargar Todas las ausencias', // Título al pasar el mouse por encima
                action: function (e, dt, node, config) {
                  descargarArchivo('./src/ajax/tablasDescargar.php?accion=impirimirAusencias', 'DatosAusencias.pdf');
                }
              },
            ],
          },
        },
      });
    } else {
      table.ajax.reload();
    }
  });

  // FUNCION PARA EDITTAR LAS AUSENCIAS
  $("#myTable").on('click', '.btnEditarAusencia', function () {
    let idAusencia = $(this).data('id');
    $("#editarAausencia").modal('show');
    function callbackExito(parsedData) {
      if (parsedData.exito == true) {
        let nombre = parsedData.nombre;
        let apellido = parsedData.apellido;
        let cargo = parsedData.cargo;
        let idEmpleado = parsedData.idEmpleado;
        let cedula = parsedData.cedula;

        $("#primerNombre2").val(nombre);
        $("#primerApellido2").val(apellido);
        $("#cargo2").val(cargo);
        $("#identificador2").val(idAusencia);
        $("#cedula2").val(cedula);
        $("#fecha_ini2").val(parsedData.fechaInicio);
        $("#fecha_fin2").val(parsedData.fechaFinal);
        $('#permiso2').val(parsedData.idPermiso).trigger('input');
        // si tiene marcado error
        // clasesInputsError("#cedula2", ".span_cedula2");
        // clasesInputsError("#primerNombre2", ".span_nombre2");
        // clasesInputsError("#primerApellido2", ".span_apellido2");
        // clasesInputsError("#cargo2", ".span_cargo2");
        // se marcar cumplido logrado
        clasesInputs("#cedula2", ".span_cedula2");
        clasesInputs("#primerNombre2", ".span_nombre2");
        clasesInputs("#primerApellido2", ".span_apellido2");
        clasesInputs("#cargo2", ".span_cargo2");
        clasesInputs("#fecha_ini2", ".span_fecha_ini2");
        clasesInputs("#fecha_fin2", ".span_fecha_fin2");
        clasesInputs("#permiso2", ".span_permiso2");


        alertaNormalmix(parsedData.messenger, 4000, "success", "top-end");
      } else {
        $("#nombreEmpleado").val("");
        $("#apellidoEmpleado").val("");
        $("#nombreEmpleado").removeClass("cumplido");
        $("#apellidoEmpleado").removeClass("cumplido");
        $(".span_nombre").removeClass("cumplido_span");
        $(".span_apellido").removeClass("cumplido_span");
        alertaNormalmix(parsedData.messenger, 4000, "error", "top-end");
      }
    }
    const formData = new FormData(); // Crea un nuevo objeto FormData
    formData.append('id', idAusencia);
    enviarFormulario("src/ajax/vacaciones.php?modulo_datos=buscarDatosAusencia", formData, callbackExito, true);

  });

  $("#myTable").on('click', '.btnEliminar', function () {
    let idAusencia = $(this).data('id');
    let formData = new FormData();
    formData.append('id', idAusencia); // Añadir idPersonal al FormData

    function callbackExito(parsedData) {
      // Manejar la respuesta exitosa aquí
      $('#myTable').DataTable().ajax.reload(null, false);
      AlertSW2("success", "Empleado Eliminado Con exito", "top", 3000);

    }

    function enviar() {
      let destino = "./src/ajax/vacaciones.php?modulo_datos=liberarAusencia";
      let url = destino;
      enviarFormulario(url, formData, callbackExito, true);
    }
    // parametros para la alerta
    let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
    let icons = 'primary';
    let position = 'top-end';

    aletaCheck(messenger, icons, position, enviar);
  });


  // metodos para escuchar cambios en el dom y habilitar el boton de enviar formulario 
  // Función para verificar si todos los campos están cumplidos en un formulario específico
  function todosCumplidos(form) {
    const elementosCumplidos = $(form).find('input, select').filter('.cumplido, .cumplidoNormal');
    return elementosCumplidos.length === $(form).find('input, select').length;
  }

  // Función para habilitar o deshabilitar el botón en un formulario específico
  function habilitarBoton(form, boton) {
    boton.prop('disabled', !todosCumplidos(form));
  }

  // Función de debounce para limitar la frecuencia de ejecución
  function debounce(func, wait) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }

  // Seleccionar los formularios específicos que deseas observar
  const forms = document.querySelectorAll('.formAusento, .formEditarAusencia');

  forms.forEach(form => {
    const boton = $(form).closest('.modalContent').find('.aceptar');

    // Inicialmente desactivar el botón
    boton.prop('disabled', true);

    // Crear una instancia de MutationObserver y observar cambios
    const observer = new MutationObserver(debounce((mutationsList) => {
      for (const mutation of mutationsList) {
        if (mutation.type === 'childList' || mutation.type === 'attributes') {
          habilitarBoton(form, boton);
        }
      }
    }, 300)); // Ajusta el tiempo de espera según sea necesario

    // Configurar el observer para observar cambios en los hijos y atributos del formulario
    const config = { childList: true, attributes: true, subtree: true };

    // Comenzar a observar el formulario
    observer.observe(form, config);

    // Ejecutar la validación inicialmente
    habilitarBoton(form, boton);
  });
})
