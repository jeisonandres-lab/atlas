import {
  validarNombre,
  colocarMeses,
  colocarYear,
  validarNumeroNumber,
  validarNumeros,
  validarSelectores,
  limpiarFormulario,
  liberarInputs,
  file,
} from "./ajax/inputs.js";

import { alertaNormalmix, AlertSW2 } from "./ajax/alerts.js";
import { enviarDatos, enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";

$(function () {
  const cargando = document.getElementById('cargando');
  var boton = $('#aceptar_emepleado'); // Reemplaza con el ID de tu botón

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
  validarSelectores("#familiarTipo", ".span_familiarTipo");
  colocarYear("#ano", "1900");
  colocarMeses("#meses");
  validarNumeroNumber("#edad", ".span_edad");
  file("#achivo", ".span_docArchivo");
  file("#achivo", ".span_achivo");

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
    if (accion == "buscar") {
      function callbackExito(parsedData) {
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
          $("#noCedula").prop("disabled", false);
          $("#disca").prop("disabled", false);
          $("#achivo").prop("disabled", false);
          $("#edad").prop("disabled", false);
          $("#familiarTipo").prop("disabled", false);
          $("#ano").prop("disabled", false);
          $("#meses").prop("disabled", false);
          $("#dia").prop("disabled", false);
          $("#aceptar_emepleado").show();
          alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
        } else {
          alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
        }
      }
      let destino = "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal";
      let url = destino;
      enviarFormulario(url, formData, callbackExito, true);

    } else if (accion == "aceptar") {
      function callbackExito(parsedData) {
        if (parsedData.resultado == 2) {

          // se marcar cumplido logrado
          $("#cedula_trabajador").addClass("cedulaBusqueda");
          $("#nombre").addClass("cumplido");
          $("#apellido").addClass("cumplido");
          $(".span_nombre").addClass("cumplido_span");
          $(".span_apellido").addClass("cumplido_span");

          $("#primerNombre").prop("disabled", false);
          $("#segundoNombre").prop("disabled", false);
          $("#primerApellido").prop("disabled", false);
          $("#segundoApellido").prop("disabled", false);
          $("#cedula").prop("disabled", false);
          $("#edad").prop("disabled", false);
          $("#familiarTipo").prop("disabled", false);
          $("#ano").prop("disabled", false);
          $("#meses").prop("disabled", false);
          $("#dia").prop("disabled", false);
          $("#aceptar_emepleado").show();
          alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
        } else if (parsedData.resultado == 3) {
          alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
        }else{
          alertaNormalmix(parsedData.mensaje, 4000, "warning", "top-end");
        }
      }
      let destino = "src/ajax/registroPersonal.php?modulo_personal=registrarFamilia";
      let url = destino;
      enviarFormulario(url, formData, callbackExito, true);
    } else {
      console.log("los destinos deben de tener un  error");
    }
  });

  function cedulaEjecutar(valor) {
    if (valor == 1) {
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
        $("#achivo").prop("disabled", true);
        $("#folio").prop("disabled", true);
        $("#tomo").prop("disabled", true);
        $("#disca").prop("disabled", true);
        $("#noCedula").prop("disabled", true);
        $("#achivoDis").prop("disabled", true);
        $("#carnet").prop("disabled", true);

        // inputs de busqueda del familiar
        $("#nombre").val("");
        $("#apellido").val("");
        $("#nombre").removeClass("cumplido");
        $("#apellido").removeClass("cumplido");
        $(".span_nombre").removeClass("cumplido_span");
        $(".span_apellido").removeClass("cumplido_span");
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

  $("#edad").on("input", function() {
  const edad = parseInt($(this).val());
    if (!isNaN(edad)) {
      let check = $("#noCedula");
      if(check.is(":checked")){
        if (edad >= 18) {
          let contenCedula = document.querySelector("#contenDoc");
          contenCedula.remove();
        } else {
          var contenedor = $("#cedula");
          let contenDoc = document.getElementById("contenDoc");
          if(!contenDoc){
            $(partidaNacimiento).insertAfter(contenedor);
          }
        }
      }else{
        if (edad >= 18) {
          let contenCedula = document.querySelector("#contenDoc");
          contenCedula.remove();
        } else {
          var contenedor = $("#edad");
          let contenDoc = document.getElementById("contenDoc");
          if(!contenDoc){
            $(partidaNacimiento).insertAfter(contenedor);
          }
        }
      }
      
    }
  });

  $("#noCedula").on("change", function () {
    var contenedor = $("#contenApellidoDos");
    if ($(this).is(":checked")) {
      let contenCedula = document.querySelector("#contenCedula");
      contenCedula.remove();
      $(noCedulado).insertAfter(contenedor);
    } else {
      let contenTomo = document.querySelector("#contenTomo");
      let contenFolio = document.querySelector("#contenFolio");
      contenTomo.remove();
      contenFolio.remove();
    // Insertamos el nuevo contenido después del contenedor
    $(cedulaContenido).insertAfter(contenedor);
    }
  });

  $("#disca").on("change", function () {
    if ($(this).is(":checked")) {
      var contenedor = $("#contenEdad");
      // Insertamos el nuevo contenido después del contenedor
      $(numeroCernet).insertAfter(contenedor);
    } else {
      let contencedual = document.querySelector("#contenCarnet");
      let contenPartida = document.querySelector("#contentPartida");
      contenPartida.remove();
      contencedual.remove();
    }
  });
  
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
    return function(...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }

  // Crear una instancia de MutationObserver y observar cambios
  const observer = new MutationObserver(debounce((mutationsList, observer) => {
    for (const mutation of mutationsList) {
      if (mutation.type === 'childList' || mutation.type === 'attributes') {
        habilitarBoton();
        validarNumeros("#carnet",".span_carnet");
        file("#achivoDis", ".span_docArchivoDis");
        file("#achivo", ".span_docArchivo");
        validarNumeros("#tomo", ".span_tomo");
        validarNumeros("#folio", ".span_folio");
      }
    }
  }, 300)); // Ajusta el tiempo de espera según sea necesario

  // Configurar el observer para observar cambios en los hijos y atributos del formulario
  const config = { childList: true, attributes: true, subtree: true };

  // Seleccionar el formulario y comenzar a observar
  const form = document.querySelector('form');
  observer.observe(form, config);

  // Ejecutar la validación inicialmente
  habilitarBoton();
  
// funcion lick para limpiar los input y select 
    $("#limpiar").on("click", function () {
        limpiarFormulario("#cedula_trabajador", ".span_cedula_empleado");
        limpiarFormulario("#nombre", ".span_nombre");
        limpiarFormulario("#apellido", ".span_apellido");
        limpiarFormulario("#disca");
        limpiarFormulario("#noCedula");
        limpiarFormulario("#primerNombre", ".span_nombre1");
        limpiarFormulario("#segundoNombre", ".span_nombre2");
        limpiarFormulario("#primerApellido", ".span_apellido1");
        limpiarFormulario("#segundoApellido", ".span_apellido2");
        limpiarFormulario("#cedula", ".span_cedula");
        limpiarFormulario("#edad", ".span_edad");
        limpiarFormulario("#achivo", ".span_docArchivo");
        limpiarFormulario("#ano", ".span_ano");
        limpiarFormulario("#meses", ".span_mes");
        limpiarFormulario("#dia", ".span_dia");
        limpiarFormulario("#tomo", ".span_tomo");
        limpiarFormulario("#folio", ".span_folio");
        limpiarFormulario("#carnet", ".span_carnet");
        limpiarFormulario("#achivoDis", ".span_docArchivoDis");
    });
});
// plantillas HTML
let cedulaContenido = 
`
<div class="col-sm-6 col-md-6" id="contenCedula">
    <div class="form-group" >
      <label for="cedula">Cédula</label>
      <div class="input-group">
        <span class="input-group-text span_cedula"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control " id="cedula" name="cedula" placeholder="Cédula de Identidad" required >
      </div>
  </div>
</div>
`;

let noCedulado = 
`
<div class="col-sm-6 col-md-6 mb-3" id="contenTomo">
    <div class="form-group" >
      <label for="tomo">Tomo</label>
      <div class="input-group">
        <span class="input-group-text span_tomo"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control" id="tomo" name="tomo" placeholder="Tomo De partida De Nacimiento" required >
      </div>
  </div>
</div>

<div class="col-sm-6 col-md-6 mb-3" id="contenFolio">
    <div class="form-group" >
      <label for="folio">Folio</label>
      <div class="input-group">
        <span class="input-group-text span_folio"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control" id="folio" name="folio" placeholder="Número de folio" required >
      </div>
  </div>
</div>`;

let numeroCernet = `
<div class="col-sm-6 col-md-6 mb-3" id="contenCarnet">
  <div class="form-group" >
      <label for="cedula">Número de Carnet de Discapacidad</label>
        <div class="input-group">
        <span class="input-group-text span_carnet"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control " id="carnet" name="carnet" placeholder="Cédula de Identidad" required>
    </div>
  </div>
</div>

<div class="col-sm-12 mb-2" id="contentPartida">
  <div class="form-group">
      <label for="correo">Partida De Discapacidad</label>
      <div class="input-group">
          <span class="input-group-text span_docArchivoDis"><i class="fa-regular fa-file-zipper"></i></span>
          <input type="file" class="form-control" name="docArchivoDis" id="achivoDis" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
      </div>
  </div>
</div>
`;

let partidaNacimiento = `
<div class="col-sm-12 mb-2 mt-3" id="contenDoc">
  <div class="form-group">
    <label for="correo">Partida De Nacimiento</label>
    <div class="input-group">
      <span class="input-group-text span_docArchivo"><i class="fa-regular fa-file-zipper"></i></span>
      <input type="file" class="form-control" name="docArchivo" id="achivo" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required >
    </div>
  </div>
</div>
`;


