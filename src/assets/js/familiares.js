import {
  validarNombre,
  colocarMeses,
  colocarYear,
  validarNumeroNumber,
  validarNumeros,
  validarSelectores,
  limpiarFormulario,
  liberarInputs,
} from "./ajax/inputs.js";

import { alertaNormalmix, AlertSW2 } from "./ajax/alerts.js";
import { enviarDatos, enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";

$(function () {
  const cargando = document.getElementById('cargando');

  validarNumeros("#cedula_trabajador", ".span_cedula_empleado");
  validarNombre("#nombre", ".span_nombre");
  validarNombre("#apellido", ".span_apellido");
  validarNombre("#primerNombre", ".span_nombre1");
  validarNombre("#segundoNombre", ".span_nombre2");
  validarNombre("#primerApellido", ".span_apellido1");
  validarNombre("#segundoApellido", ".span_apellido2");
  validarNumeros("#cedula", ".span_cedula");
  validarSelectores("#ano", ".span_ano");
  validarSelectores("#dia", ".span_dia");
  colocarYear("#ano", "1900");
  colocarMeses("#meses");
  validarNumeroNumber("#edad", ".span_edad");

  $("#dia").append('<option value="">Selecciona un día</option>');
  $("#meses").on("change", function () {
    const year = 2024;
    const month = $("#meses").val();
    if (month === "") {
      $("#dia").append('<option value="">Selecciona un día</option>');
      $(this).removeClass("cumplido").addClass("error_input");
      $(".span_mes").removeClass("cumplido_span").addClass("error_span");
    } else {
      const monthWithoutLeadingZero = month.replace(/^0+/, "");
      const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate();
      for (let i = 1; i <= daysInMonth; i++) {
        const diaFormateado = i.toString().padStart(2, "0");
        $("#dia").append('<option value="' + diaFormateado + '">' + diaFormateado + "</option>");
      }
      $(this).removeClass("error_input").addClass("cumplido");
      $(".span_mes").removeClass("error_span").addClass("cumplido_span");
    }
  });

  $('#formulario_empleado').on("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    const accion = $(this).find('button[type="submit"]:focus').attr('name');
    console.log(accion)

    if(accion == "buscar"){
      var destino = "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal";
    }else if(accion == "aceptar"){
      var destino = "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal";
      console.log("se le dio al boton aceptar")
    }else{
      console.log("los destinos deben de tener un  error")
    }

    function callbackExito(parsedData) {
      console.log(parsedData);
      if (parsedData.logrado == true) {
        let nombre = parsedData.nombre;
        let apellido = parsedData.apellido;
        // si tiene marcado error
        $("#nombre").removeClass("error_input");
        $("#apellido").removeClass("error_input");
        $(".span_nombre").removeClass("error_span");
        $(".span_apellido").removeClass("error_span");

        // se marcar cumplido logrado
        $("#cedula_trabajador").addClass("cedulaBusqueda");
        $("#nombre").addClass("cumplido");
        $("#apellido").addClass("cumplido");
        $(".span_nombre").addClass("cumplido_span");
        $(".span_apellido").addClass("cumplido_span");
        $("#nombre").val(nombre);
        $("#apellido").val(apellido);

        $("#primerNombre").prop("disabled", false);
        $("#segundoNombre").prop("disabled", false);
        $("#primerApellido").prop("disabled", false);
        $("#segundoApellido").prop("disabled", false);
        $("#cedula").prop("disabled", false);
        $("#edad").prop("disabled", false);
        $("#ano").prop("disabled", false);
        $("#meses").prop("disabled", false);
        $("#dia").prop("disabled", false);
        $("#aceptar_emepleado").show();
        alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
      } else {
        alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
      }
    }
    let url = destino;
    enviarFormulario(url, formData, callbackExito, true);
  });

  function cedulaEjecutar(valor) {
    if (valor == 1) {
      //liberar inputs
      liberarInputs("#primerNombre", ".span_nombre1", "1");
      liberarInputs("#segundoNombre", ".span_nombre2", "1");
      liberarInputs("#primerApellido", ".span_apellido1", "1");
      liberarInputs("#segundoApellido", ".span_apellido2", "1");
      liberarInputs("#cedula", ".span_cedula", "1");
      liberarInputs("#edad", ".span_edad", "1");
      liberarInputs("#ano", ".span_ano", "1");
      liberarInputs("#meses", ".span_mes", "1");
      liberarInputs("#dia", ".span_dia", "1");
    } else {
      $("#primerNombre").prop("disabled", true);
      $("#segundoNombre").prop("disabled", true);
      $("#primerApellido").prop("disabled", true);
      $("#segundoApellido").prop("disabled", true);
      $("#cedula").prop("disabled", true);
      $("#edad").prop("disabled", true);
      $("#ano").prop("disabled", true);
      $("#meses").prop("disabled", true);
      $("#dia").prop("disabled", true);
      // inputs de busqueda
      $("#nombre").val("");
      $("#apellido").val("");
      // nombre del trabajador
      $("#nombre").removeClass("cumplido");
      $("#nombre").addClass("error_input");
      $(".span_nombre").removeClass("cumplido_span");
      $(".span_nombre").addClass("error_span");

      // apellido del trabajador
      $("#apellido").removeClass("cumplido");
      $("#apellido").addClass("error_input");
      $(".span_apellido").removeClass("cumplido_span");
      $(".span_apellido").addClass("error_span");

      //liberar inputs
      liberarInputs("#primerNombre", ".span_nombre1", "0");
      liberarInputs("#segundoNombre", ".span_nombre2", "0");
      liberarInputs("#primerApellido", ".span_apellido1", "0");
      liberarInputs("#segundoApellido", ".span_apellido2", "0");
      liberarInputs("#cedula", ".span_cedula", "0");
      liberarInputs("#edad", ".span_edad", "0");
      liberarInputs("#ano", ".span_ano", "0");
      liberarInputs("#meses", ".span_mes", "0");
      liberarInputs("#dia", ".span_dia", "0");
    }

  }

  $(document).on("input", ".cedulaBusqueda", function () {
    if ($(this).val().length < 7) {
      $("#aceptar_emepleado").hide();
      $("#cedula_trabajador").removeClass("cedulaBusqueda");
      cedulaEjecutar();
    } else {
      cedulaEjecutar(1);
    }
  });


  

  // Selector para todos los inputs y selects dentro del formulario
  var inputs = $('form input, form select');
  var boton = $('#aceptar_emepleado'); // Reemplaza con el ID de tu botón

  // Función para verificar si todos los elementos tienen la clase "cumplido"
  function todosCumplidos() {
    return inputs.filter('.cumplido').length === inputs.length;
  }

  // Función para habilitar o deshabilitar el botón
  function habilitarBoton() {
    boton.prop('disabled', !todosCumplidos());
  }

  // Inicialmente verificamos el estado
  habilitarBoton();

  // Evento para detectar cambios en los inputs
  inputs.on('change', function () {
    habilitarBoton();
  });

  $("#limpiar").on("click", function () {
    limpiarFormulario(
      "#formulario_registro",
      "#dia", " #meses", "#ano", "#nombre", "#apellido", "#segundoNombre", "#segundoNombre", "#primerApellido", "#segundoApellido", "#cedula", ".span_ano", ".span_dia", ".span_mes", ".error_span", "cumplido", "cumplido_span", "error_input"
    );
  });
})