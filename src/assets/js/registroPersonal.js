
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

import {
  enviarFormulario,
  obtenerDatos,
  obtenerDatosJQuery
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
  validarSelectores("#academico", ".span_academico");
  file("#contrato", ".span_contrato");
  file("#notificacion", ".span_notificacion");
  // formulario de empleados

  let urls = [
    "src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias",
    "src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus",
    "src/ajax/registroPersonal.php?modulo_personal=obtenerCargo",
    "src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento"
  ];

  let requests = urls.map(url => obtenerDatosJQuery(url));

  $.when(...requests).done((dependencias, estatus, cargo, departamento) => {
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
  }).fail((jqXHR, textStatus, errorThrown) => {
    console.error('Error al obtener los datos:', textStatus, errorThrown);
  });


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