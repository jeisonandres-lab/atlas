import { alertaNormalmix } from "./ajax/alerts.js";
import { enviarFormulario } from "./ajax/formularioAjax.js";
import { incluirSelec2, validarNumeros, validarSelectores, validarSelectoresSelec2 } from "./ajax/inputs.js";

$(function () {
  let boton = document.querySelector("#aceptar");
  validarNumeros("#cedula", ".span_cedula");
  incluirSelec2("#permiso");
  validarSelectoresSelec2("#permiso", ".span_permiso");
  validarSelectores("#permiso", ".span_permiso");
  validarSelectores("#fecha_ini", ".span_fecha_ini");
  validarSelectores("#fecha_fin", ".span_fecha_fin");
  

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
        if (parsedData.logrado == true) {
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
  const buscarDatosDebounced = debounce(buscarDatos, 600);

  // Evento de input para el campo de búsqueda
  $("#cedula").on("input", buscarDatosDebounced);
 
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

  $("#formAusento").on('submit', async function (e) {
    e.preventDefault();
    let data = new FormData(this);
    async function callbackExito(parametros) {
     if(parametros.exito){
      alertaNormalmix(parametros.messenger, 4000, "success", "top-end");
     }else{
      alertaNormalmix(parametros.messenger, 4000, "error", "top-end");
     }
    }
    enviarFormulario("./src/ajax/vacaciones.php?modulo_datos=registrarAusencia", data, callbackExito, 1)
  })











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
  const forms = document.querySelectorAll('.formAusento');

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
