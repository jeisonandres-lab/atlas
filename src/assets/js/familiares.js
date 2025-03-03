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
  validarNumerosMenores,
  limpiarInput,
} from "./ajax/inputs.js";

import { alertaNormalmix, AlertSW2 } from "./ajax/alerts.js";
import { enviarDatos, enviarDatosPersonalizados, enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";

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
  validarSelectores("#parentesco", ".span_parentesco");
  validarSelectores("#familiarTipo", ".span_familiarTipo");
  colocarYear("#ano", "1900");
  colocarMeses("#meses");
  validarNumeros("#edad", ".span_edad");
  file("#achivo", ".span_docArchivo");
  file("#achivo", ".span_achivo");
  $("#dia").append('<option value="">Selecciona un día</option>');

  $("#cedula_trabajador").on("input", function () {
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
        $("#parentesco").prop("disabled", false);
        $("#cedula").prop("disabled", false);
        $("#noCedula").prop("disabled", false);
        $("#tomo").prop("disabled", false);
        $("#folio").prop("disabled", false);
        $("#disca").prop("disabled", false);
        $("#achivo").prop("disabled", false);
        $("#familiarTipo").prop("disabled", false);
        $("#ano").prop("disabled", false);
        $("#meses").prop("disabled", false);
        $("#dia").prop("disabled", false);
        $("#edad").prop("disabled", false);
        $("#aceptar_emepleado").show();
        alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
      } else {
        $("#nombre").val("");
        $("#apellido").val("");
        $("#nombre").removeClass("cumplido");
        $("#apellido").removeClass("cumplido");
        $(".span_nombre").removeClass("cumplido_span");
        $(".span_apellido").removeClass("cumplido_span");

        $("#primerNombre").prop("disabled", true);
        $("#segundoNombre").prop("disabled", true);
        $("#primerApellido").prop("disabled", true);
        $("#segundoApellido").prop("disabled", true);
        $("#parentesco").prop("disabled", true);
        $("#cedula").prop("disabled", true);
        $("#noCedula").prop("disabled", true);
        $("#disca").prop("disabled", true);
        $("#achivo").prop("disabled", true);
        $("#familiarTipo").prop("disabled", true);
        $("#ano").prop("disabled", true);
        $("#meses").prop("disabled", true);
        $("#dia").prop("disabled", true);
        $("#aceptar_emepleado").hide();
        alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
      }
    }

    if ($(this).val().length >= 7) {
      const datoCedula = $(this).val();
      const formData = new FormData(); // Crea un nuevo objeto FormData
      formData.append('cedulaEmpleado', datoCedula);
      enviarFormulario("src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal", formData, callbackExito, true);
    }
  });

  $("#dia, #meses, #ano").on("input", function () {
    const dia = $("#dia").val();
    const mes = $("#meses").val();
    const ano = $("#ano").val();

    if (dia && mes && ano) {
      const fechaNacimiento = new Date(ano, mes - 1, dia);
      const edad = calcularEdad(fechaNacimiento);
      $("#edad").val(edad);
      $("#edad").addClass("cumplido");
      $(".span_edad").addClass("cumplido_span");
      $("#edad").removeClass("error_input");
      $(".span_edad").removeClass("error_span");
      if (!isNaN(edad)) {
        let check = $("#noCedula");
        if (check.is(":checked")) {
          if (edad >= 18) {
            let contenCedula = document.querySelector("#contenDoc");
            let contenedor = $("#contenApellidoDos");
            let contenTomo = document.querySelector("#contenTomo");
            let contenFolio = document.querySelector("#contenFolio");
            contenTomo.remove();
            contenFolio.remove();
            contenCedula.remove();
            // Insertamos el nuevo contenido después del contenedor
            $(cedulaContenido).insertAfter(contenedor);
          } else {
            var contenedor = $("#cedula");
            let contenDoc = document.getElementById("contenDoc");
            if (!contenDoc) {
              $(partidaNacimiento).insertAfter(contenedor);
            }
          }
        } else {
          if (edad >= 18) {
            let contenCedula = document.querySelector("#contenDoc");
            contenCedula.remove();
          } else {
            var contenedor = $("#contenEdad");
            let contenDoc = document.getElementById("contenDoc");
            if (!contenDoc) {
              $(partidaNacimiento).insertAfter(contenedor);
            }
          }
        }

      }
      console.log(edad)
    }
  });

  function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
      edad--;
    }
    return edad;
  }

  $("#meses").on("change", function () {
    const year = 2024;
    const month = $("#meses").val();
    if (month === "") {
      $("#dia").val("");
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
    if (accion == "aceptar") {
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
        } else {
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

  // $("#noCedula").on("change", function () {
  //   let contenedor = $("#contenApellidoDos");
  //   if ($(this).is(":checked")) {
  //     let contenCedula = document.querySelector("#contenCedula");
  //     contenCedula.remove();
  //     $(noCedulado).insertAfter(contenedor);
  //   } else {
  //     let contenTomo = document.querySelector("#contenTomo");
  //     let contenFolio = document.querySelector("#contenFolio");
  //     contenTomo.remove();
  //     contenFolio.remove();
  //     // Insertamos el nuevo contenido después del contenedor
  //     $(cedulaContenido).insertAfter(contenedor);
  //   }
  // });

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

  $('#edad').on("input", function () {
    this.value = this.value.replace(/[^0-9]/g, ""); // Permitir solo números
    if (this.value.length > 2) {
      this.value = this.value.slice(0, 2); // Limitar a 2 dígitos
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
        validarNumeros("#carnet", ".span_carnet");
        validarNumeros("#cedula", ".span_cedula");
        file("#achivoDis", ".span_docArchivoDis");
        file("#achivo", ".span_docArchivo");
        validarNumerosMenores("#tomo", ".span_tomo");
        validarNumerosMenores("#folio", ".span_folio");
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

    let contenedor = $("#contenApellidoDos");
    let contenTomo = document.querySelector("#contenTomo");
    let contenFolio = document.querySelector("#contenFolio");

    let contencedual = document.querySelector("#contenCarnet");
    let contenPartida = document.querySelector("#contentPartida");

    $("#noCedula").on("change", function () {
      if ($(this).is(":checked")) {
        contenTomo.remove();
        contenFolio.remove();
        $(cedulaContenido).insertAfter(contenedor);
      }
    });

    $("#disca").on("change", function () {
      if ($(this).is(":checked")) {
        contenPartida.remove();
        contencedual.remove();
      }
    });

    $(".imgFoto").remove();
    limpiarInput("#cedula_trabajador", ".span_cedula_empleado");
    limpiarInput("#nombre", ".span_nombre");
    limpiarInput("#apellido", ".span_apellido");
    limpiarInput("#disca");
    limpiarInput("#noCedula");
    limpiarInput("#primerNombre", ".span_nombre1");
    limpiarInput("#segundoNombre", ".span_nombre2");
    limpiarInput("#primerApellido", ".span_apellido1");
    limpiarInput("#segundoApellido", ".span_apellido2");
    limpiarInput("#cedula", ".span_cedula");
    limpiarInput("#edad", ".span_edad");
    limpiarInput("#achivo", ".span_docArchivo");
    limpiarInput("#ano", ".span_ano");
    limpiarInput("#meses", ".span_mes");
    limpiarInput("#dia", ".span_dia");
    limpiarInput("#tomo", ".span_tomo");
    limpiarInput("#folio", ".span_folio");
    limpiarInput("#carnet", ".span_carnet");
    limpiarInput("#achivoDis", ".span_docArchivoDis");

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
  });

});

// plantillas HTML
let cedulaContenido =
  `
<div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4" id="contenCedula">
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
<div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3" id="contenTomo">
    <div class="form-group" >
      <label for="tomo">Tomo</label>
      <div class="input-group">
        <span class="input-group-text span_tomo"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control" id="tomo" name="tomo" placeholder="Tomo De partida De Nacimiento" required >
      </div>
  </div>
</div>

<div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3" id="contenFolio">
    <div class="form-group" >
      <label for="folio">Folio</label>
      <div class="input-group">
        <span class="input-group-text span_folio"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control" id="folio" name="folio" placeholder="Número de folio" required >
      </div>
  </div>
</div>
`;

let numeroCernet = `
<div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6 mb-3" id="contenCarnet">
  <div class="form-group" >
      <label for="cedula">Número de Carnet de Discapacidad</label>
        <div class="input-group">
        <span class="input-group-text span_carnet"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control " id="carnet" name="carnet" placeholder="Cédula de Identidad" required>
    </div>
  </div>
</div>

<div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6 mb-3" id="contenTipoDiscapacidad">
  <div class="form-group" >
      <label for="tpDiscapacidad">Tipo De Discapacidad</label>
        <div class="input-group">
        <span class="input-group-text span_tpDiscapacidad"><i class="fa-regular fa-address-card"></i></span>
        <select type="text" class="form-control " id="tpDiscapacidad" name="tpDiscapacidad" placeholder="Tipo de Discapacidad ">
          <option value="">Seleccione una discapacidad</option>
          <option value="visual">Discapacidad visual</option>
          <option value="auditiva">Discapacidad auditiva</option>
          <option value="motriz">Discapacidad motriz</option>
          <option value="intelectual">Discapacidad intelectual</option>
          <option value="psicosocial">Discapacidad psicosocial</option>
          <option value="visceral">Discapacidad visceral</option>
          <option value="multiples">Discapacidades múltiples</option>
          <option value="otra">Otra discapacidad</option>
        </select>
    </div>
  </div>
</div>


<div class="col-sm-12 col-xl-12 col-xxl-12 mb-2" id="contentPartida">
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
<div class="col-sm-12 col-xl-12 col-xxl-12 mb-2 mt-3" id="contenDoc">
  <div class="form-group">
    <label for="correo">Partida De Nacimiento</label>
    <div class="input-group">
      <span class="input-group-text span_docArchivo"><i class="fa-regular fa-file-zipper"></i></span>
      <input type="file" class="form-control" name="docArchivo" id="achivo" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required >
    </div>
  </div>
</div>
`;


