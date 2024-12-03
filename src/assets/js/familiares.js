import {
  validarNombre,
  colocarMeses,
  colocarYear,
  validarNumeroNumber,
  validarNumeros,
  validarSelectores,
  limpiarFormulario,
} from "./ajax/inputs.js";

import { alertaNormalmix, AlertSW2 } from "./ajax/alerts.js";
import { enviarDatos, enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";

$(function () {
  const cargando = document.getElementById('cargando');

  validarNumeros("#cedula_trabajador", ".span_cedula_empleado", "1");
  validarNombre("#nombre", ".span_nombre", "1");
  validarNombre("#apellido", ".span_apellido", "1");
  validarNombre("#primerNombre", ".span_nombre1", "1");
  validarNombre("#segundoNombre", ".span_nombre2", "1");
  validarNombre("#primerApellido", ".span_apellido1", "1");
  validarNombre("#segundoApellido", ".span_apellido2", "1");
  validarNumeros("#cedula", ".span_cedula");
  validarSelectores("#ano", ".span_ano", "1");
  validarSelectores("#dia", ".span_dia", "1");
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
    let cedula = $("#cedula_trabajador");
    const formData = new FormData(this);
    function callbackExito(parsedData) {
      console.log(parsedData)
      if (parsedData.logrado == true) {
      let nombre = parsedData.nombre;
      let apellido = parsedData.apellido;
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
    const url = "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal";
    enviarFormulario(url, formData, callbackExito, true);
  });


  $("#cedula_trabajador").on("input", function(){
    if ($(this).val().length < 8) {
      $("#primerNombre").prop("disabled", true);
      $("#segundoNombre").prop("disabled", true);
      $("#primerApellido").prop("disabled", true);
      $("#segundoApellido").prop("disabled", true);
      $("#cedula").prop("disabled", true);
      $("#edad").prop("disabled", true);
      $("#ano").prop("disabled", true);
      $("#meses").prop("disabled", true);
      $("#dia").prop("disabled", true);
    }
  })
  $("#limpiar").on("click", function () {
    limpiarFormulario(
      "#formulario_registro",
      "#dia", " #meses", "#ano", "#nombre", "#apellido", "#segundoNombre", "#segundoNombre", "#primerApellido", "#segundoApellido", "#cedula", ".span_ano", ".span_dia", ".span_mes", ".error_span", "cumplido", "cumplido_span", "error_input"
    );
  });
})