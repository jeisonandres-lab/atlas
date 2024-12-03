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
} from "./ajax/inputs.js";

import {
  enviarFormulario,
  obtenerDatos
} from "./ajax/formularioAjax.js";

import {
  alertaNormalmix,
  AlertDirection,
  AlertSW2
} from "./ajax/alerts.js";


// jQuery
$(function () {
  $(".formulario_empleado").hide();

  const cargando = document.getElementById('cargando');

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
  // formulario de empleados

  let url_dependencias = "src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias";
  let url_estatus = "src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus";
  let url_cargo = "src/ajax/registroPersonal.php?modulo_personal=obtenerCargo";
  let url_departamento = "src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento";
  obtenerDatos(url_dependencias)
    .then(response => {
      if (response.exito) {
        const arrayDependencias = Object.values(response);
        console.log(arrayDependencias);

        arrayDependencias[1].data.forEach(dependencia => {
          $("#dependencia").append(
            '<option value="' + dependencia.iddependencia + '">' + dependencia.dependencia + "</option>"
          );
          // Hacer algo con cada dependencia, como mostrarla en una lista
        });
      }
    });
  obtenerDatos(url_estatus)
    .then(response => {
      if (response.exito) {
        const arrayEstatus = Object.values(response);
        console.log(arrayEstatus);

        arrayEstatus[1].data.forEach(estatus => {
          $("#estatus").append(
            '<option value="' + estatus.idestatus + '">' + estatus.estatus + "</option>"
          );
          // Hacer algo con cada dependencia, como mostrarla en una lista
        });
      }
    });
  obtenerDatos(url_cargo)
    .then(response => {
      if (response.exito) {
        const arrayCargo = Object.values(response);
        console.log(arrayCargo);
        arrayCargo[1].data.forEach(cargo => {
          $("#cargo").append(
            '<option value="' + cargo.idcargo + '">' + cargo.cargo + "</option>"
          );
          // Hacer algo con cada dependencia, como mostrarla en una lista
        });
      }
    });
  obtenerDatos(url_departamento)
    .then(response => {
      if (response.exito) {
        const arrayDepartamento = Object.values(response);
        console.log(arrayDepartamento);
        arrayDepartamento[1].data.forEach(departamento => {
          $("#departamento").append(
            '<option value="' + departamento.iddepartamento + '">' + departamento.departamento + "</option>"
          );
          // Hacer algo con cada dependencia, como mostrarla en una lista
        });
      }
    });
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
      $("#aceptar").prop("disabled", false);
      console.log(parsedData);
      if (parsedData.personalEncontrado) {
        $("#alerta").slideDown('slow', 'swing').delay(10000).slideUp();
      } else {
        alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end")
      }
      // const myModal = new bootstrap.Modal(document.getElementById('modal'));
      // myModal.show();
    }
    enviarFormulario(url, data, callbackExito, true);
  });



  // Selector para todos los inputs y selects dentro del formulario
  var inputs = $('form input, form select');
  var boton = $('#aceptar'); // Reemplaza con el ID de tu botón

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
      "#dia, #meses, #ano, .span_ano, .span_dia, .span_mes", "error_span", "cumplido", "cumplido_span", "error_input"
    );
  });

});
