import {
  colocarMeses,
  colocarYear,
  limpiarFormulario,
  valdiarCorreos,
  validarBusquedaCedula,
  validarNombre,
  validarNumeros,
  validarSelectores,
} from "./ajax/inputs.js";

import { enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";

setTimeout(() => {





}, 1000);
$(function () {
  $(".formulario_empleado").hide();

  // $("#dependencia").select2();
  // $("#estatus").select2();
  // $("#cargo").select2();
  // $("#departamento").select2();

  validarNombre("#primerNombre", ".span_nombre");
  validarNombre("#segundoNombre", ".span_nombre2");
  validarNombre("#primerApellido", ".span_apellido");
  validarNombre("#segundoApellido", ".span_apellido2");
  validarNumeros("#cedula", ".span_cedula");
  validarBusquedaCedula("#cedula", "#img-contener");
  validarBusquedaCedula("#cedula_trabajador", "#img-contener");
  validarSelectores("#civil", ".span_civil");
  validarSelectores("#ano", ".span_ano", "1");
  valdiarCorreos("#correo", ".span_correo");
  colocarYear("#ano", "1900");
  colocarMeses("#meses");

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

  $("#meses").trigger("change");

  validarSelectores("#dia", ".span_dia", "1");

  $("#formulario_registro").on("submit", function (event) {
    event.preventDefault();
    const data = new FormData(this);
    const url = "src/ajax/registroPersonal.php?modulo_personal=registrar";
    $("#aceptar").prop("disabled", true);

    function callbackExito(parsedData) {
      $("#aceptar").prop("disabled", false);
      console.log(parsedData);
      if (parsedData.personalEncontrado) {
        $("#alerta").slideDown('slow', 'swing').delay(10000).slideUp();
      } else {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;

          }
        });
        Toast.fire({
          icon: "success",
          title: "Registro de personal exitoso, procesando datos"
        }).then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
            let url_dependencias = "src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias";
            let url_estatus = "src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus";
            let url_cargo = "src/ajax/registroPersonal.php?modulo_personal=obtenerCargo";
            let url_departamento = "src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento";
            console.log(parsedData.exito)
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
            $("#id").val(parsedData.idPersonal);
            $("#cedula_trabajador").val(parsedData.cedula);
            $("#nombreTrabajador").val(parsedData.nombre);
            $("#apellidoTrabajador").val(parsedData.apellido);
            $("#formulario_registro").remove();
            $(".formulario_empleado").show();
            $(".formulario_empleado").addClass('d-flex');
          }
        });
      }


      // const myModal = new bootstrap.Modal(document.getElementById('modal'));
      // myModal.show();
    }
    enviarFormulario(url, data, callbackExito, true);

  });

  $("#limpiar").on("click", function () {
    limpiarFormulario(
      "#formulario_registro",
      "#dia, #meses, #ano, .span_ano, .span_dia, .span_mes"
    );
  });

  $("#formulario_empleado").on("submit", function (event) {
    event.preventDefault();
    const data = new FormData(this);
    function callbackExito(parsedData) {
      // const myModal = new bootstrap.Modal(document.getElementById('modal'));
      // myModal.show();
    }
    let url = "src/ajax/registroPersonal.php?modulo_personal=registrarEmpleado";
    enviarFormulario(url, data, callbackExito, true);
  });
});
