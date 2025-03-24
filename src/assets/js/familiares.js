import {
  validarNombre,
  colocarMeses,
  colocarYear,
  validarNumeroNumber,
  validarNumeros,
  validarSelectores,
  file,
  clasesInputs,
  incluirSelec2,
  validarSelectoresSelec2,
  clasesInputsError,
} from "./ajax/inputs.js";

import { alertaNormalmix } from "./ajax/alerts.js";
import { enviarFormulario, observarFormulario } from "./ajax/formularioAjax.js";
import { setCargarDiscapacidad, setCargarParentesco } from "./ajax/variablesArray.js";
import { setVariableCarnetDiscapacidad, setVariableDiscapacidad } from "./ajax/variablesContenido.js";
import { carculasDias } from "./ajax/funciones.js";

$(function () {

  // VALIDADOR DE EVENTOS 
  validarNumeros("#cedula_trabajador", ".span_cedula_empleado");
  validarNumeros("#cedulaFamiliarPendiente", ".span_cedulaFamiliarPendiente");
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
  validarSelectores("#sexo", ".span_sexo");
  validarNumeroNumber("#edad", ".span_edad", 3);
  validarNumeroNumber("#tomo", ".span_tomo", 5, true);
  validarNumeroNumber("#folio", ".span_folio", 4, true);
  file("#archivoDis", ".span_docArchivo");
  file("#archivo", ".span_achivo");

  //INCLUIR SELEC 2
  incluirSelec2("#parentesco");
  incluirSelec2("#ano");
  incluirSelec2("#meses");
  incluirSelec2("#dia");
  incluirSelec2("#sexo");

  // VALIDAR SELECTORES 2
  validarSelectoresSelec2("#parentesco", ".span_parentesco");
  validarSelectoresSelec2("#ano", ".span_ano");
  validarSelectoresSelec2("#meses", ".span_meses");
  validarSelectoresSelec2("#dia", ".span_dia");
  validarSelectoresSelec2("#tpDiscapacidad", ".span_tpDiscapacidad");
  validarSelectoresSelec2("#sexo", ".span_sexo");

  colocarYear("#ano", "1900");// COLOCAR AÑOS
  colocarMeses("#meses");// COLOCAR MESES 
  
  setCargarParentesco("#parentesco");// CARGAR DATOS DE PARENTESCO

  carculasDias("#meses", "#ano", "#dia", ".span_mes"); // FUNCION PARA CARCULAR LOS DIAS POR MES

  // SOLOCAR SELECT A DIA
  $("#dia").append('<option value="">Selecciona un día</option>');

  // EVENTO PARA BUSCAR DATOS DE EMPLEADO
  $(document).on("input", "#cedula_trabajador", function () {
    function callbackExito(data) {
      if (data.exito == true) {
        // se marcar cumplido logrado
        $("#cedula_trabajador").addClass("cedulaBusqueda");
        // inputs exitoso del empleado
        clasesInputs("#nombre", ".span_nombre");
        clasesInputs("#apellido", ".span_apellido");
        clasesInputs("#cedula_trabajador", ".span_cedula_empleado");
        $("#nombre").val(data.nombre);
        $("#apellido").val(data.apellido);
        // hacer que todos los campos del formulario se activen 
        $('#formulario_empleado :input, #formulario_empleado select').prop('disabled', false);
        $("#aceptar_emepleado").show();
        alertaNormalmix(data.mensaje, 4000, "success", "top-end");
      } else {
        $("#nombre, #apellido").val("");
        // inputs error del empleado
        clasesInputsError("#nombre", ".span_nombre");
        clasesInputsError("#apellido", ".span_apellido");
        clasesInputsError("#cedula_trabajador", ".span_cedula_empleado");
        // todos los inputs desabilitados
        $('#formulario_empleado :input:not(#cedula_trabajador, #nombre, #apellido), #formulario_empleado select').prop('disabled', true);
        alertaNormalmix(data.mensaje, 4000, "error", "top-end");
      }
    }

    if ($(this).val().length >= 7) {
      const datoCedula = $(this).val();
      const formData = new FormData(); // Crea un nuevo objeto FormData
      formData.append('cedulaEmpleado', datoCedula);
      enviarFormulario("src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal", formData, callbackExito, true);
    }
  });

  // EVENTO APRA BUSCAR FAMILIAR PENDIENTE
  $(document).on("click", "#buscarFamiliarPendiente", async function () {
    const cedula = $("#cedulaFamiliarPendiente").val(); // obtener valor de campo cedula familiar pendiente
    // CONDICIONAR DE VALOR TERNARIO 
    // si el valor es mas o igual a 7 se cumple la condicional
    cedula.length >= 7 ? await buscarFamiliarPendiente(cedula) : (clasesInputsError("#cedulaFamiliarPendiente", ".span_cedulaFamiliarPendiente"), alertaNormalmix("Ingrese cédula del familiar pendiente", 5000, "error", "top"));
    async function buscarFamiliarPendiente(cedula) {
      const formData = new FormData(); // Crea un nuevo objeto FormData
      formData.append('cedulaFamiliar', cedula); // colocar dato adicional de cedula 
      //ENVIAR FORMULARIO 
      enviarFormulario("src/ajax/registroPersonal.php?modulo_personal=buscarFamiliarPendiente", formData, callbackExito, true);
    }

    // callback de evento 
    async function callbackExito(data) {
      // si data fue exitoso 
      if (data.exito == true) {
        // hacer que todos los campos del formulario se activen 
        $('#formulario_empleado :input, #formulario_empleado select').prop('disabled', false);
        $("#buscarFamiliarPendiente").val(""); // vaciar el campo
        $('#modalPendiente').modal('hide'); // Oculta el modal

        // DATA DEL FAMILIAR 
        $("#cedula").val(data.cedula);
        $("#primerNombre").val(data.primerNombre);
        $("#primerApellido").val(data.primerApellido);
        // DATA DEL TRABAJADOR
        $("#nombre").val(data.primerNombre);
        $("#apellido").val(data.primerApellido);
        $("#cedula_trabajador").val(data.cedulaEmpleado);

        // inputs exitosos del familiar
        clasesInputs("#cedula", ".span_cedula");
        clasesInputs("#primerNombre", ".span_nombre1");
        clasesInputs("#primerApellido", ".span_apellido1");
        // inputs exitoso del empleado
        clasesInputs("#nombre", ".span_nombre");
        clasesInputs("#apellido", ".span_apellido");
        clasesInputs("#cedula_trabajador", ".span_cedula_empleado");

        // alerta de exito de encontrar del familiar
        alertaNormalmix("Familiar Pendiente encontrado", 5000, "success", "top");
      } else {
        // es caso que data exito sea falso se ejecuta la alerta
        alertaNormalmix("Familiar pendiente no encontrado", 5000, "error", "top");
      }
    }
  });

  // CALCULAR AÑOS DE EDAD POR MESES DIAS Y AÑOS
  $(document).on("input", "#dia, #meses, #ano", function () {
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
    }
  });

  // FUNCION PARA CALCULAR LA EDAD
  function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
      edad--;
    }
    return edad;
  }

  // EVENTO DE ENVIO DE FORMULARIO
  $(document).on("submit", "#formulario_empleado", function (event) {
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
          $("#sexo").prop("disabled", false);
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

  // FUNCION DE CALCULAR LA LONGITUD DE LA CEDULA Y DEPENDIENDO SE BLOQUEAN LOS DATOS 
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
      $("#archivo").prop("disabled", true);
      $("#folio").prop("disabled", true);
      $("#tomo").prop("disabled", true);
      $("#disca").prop("disabled", true);
      $("#noCedula").prop("disabled", true);
      $("#archivoDis").prop("disabled", true);
      $("#carnet").prop("disabled", true);
      $("#parentesco").prop("disabled", true);
      $("#tpDiscapacidad").prop("disabled", true);
      $("#sexo").prop("disabled", true);

      // inputs de busqueda del familiar
      $("#nombre").val("");
      $("#apellido").val("");
      $("#nombre").removeClass("cumplido");
      $("#apellido").removeClass("cumplido");
      $(".span_nombre").removeClass("cumplido_span");
      $(".span_apellido").removeClass("cumplido_span");
    }
  }


  // SE DEBE DE REVISAR PORQUE ES UN EVENTO CASI INNECESARIO
  // EVENTO PARA BUSCAR LA EJECUTAR LA FUNCION CEDUlAEJECUTAR
  $(document).on("input", ".cedulaBusqueda", function () {
    if ($(this).val().length < 7) {
      $("#aceptar_emepleado").hide();
      $("#cedula_trabajador").removeClass("cedulaBusqueda");
      cedulaEjecutar();
    } else {
      cedulaEjecutar(1);
    }
  });

  // EVENTO DE CHECKBOX DE NO CEDULADO
  $(document).on("change", "#noCedula", function () {
    if ($(this).is(":checked")) {
      $("#cedula").prop("disabled", true).val("");
      clasesInputs("#cedula", ".span_cedula")
    } else {
      $("#cedula").removeClass("cumplido");
      $(".span_cedula").removeClass("cumplido_span");
      $("#cedula").prop("disabled", false);
    }
  });

  // EVENTO DE CHECKBOX DE ESTADO DE DERECHO
  $(document).on("change", "#estadoDerecho", function () {
    if ($(this).is(":checked")) {
      // docEstadoDerechoArchivo
      $("#contenDoc label").text("Docuemento estado de derecho");
      $("#archivo").attr("name", "docEstadoDerechoArchivo");
    } else {
      $("#contenDoc label").text("Partida de nacimiento");
      $("#archivo").attr("name", "docArchivo");
      $("#cedula").prop("disabled", false);
    }
  });

  // EVENTO DE CHECKBOX DE DISCAPACIDAD
  $(document).on("change", "#disca", function () {
    if ($(this).is(":checked")) {
      var contenedor = $("#contenEdad");
      // Insertamos el nuevo contenido después del contenedor
      $(contenedor).after(setVariableCarnetDiscapacidad("carnet", "carnet") + setVariableDiscapacidad("tpDiscapacidad", "tpDiscapacidad") + numeroCernet);
      incluirSelec2("#tpDiscapacidad");
      setCargarDiscapacidad("#tpDiscapacidad");
    } else {
      $("#contentDiscapacidad").remove()
      $("#contenCarnet").remove()
      $("#contentPartida").remove()
    }
  });

  // funcion lick para limpiar los input y select 
  $("#limpiar").on("click", function () {
    $('#formulario_empleado input[type="checkbox"]').prop('checked', false).trigger('change');
    $(".imgFoto").remove();
    $('#formulario_empleado select').val('').trigger('change');
    $('#formulario_empleado :input').val('');
    $('#formulario_empleado :input:not(#cedula_trabajador, #nombre, #apellido, #buttonPendiente, #limpiar), #formulario_empleado select').prop('disabled', true);
    $('#formulario_empleado :input, #formulario_empleado select, #formulario_empleado span').removeClass('cumplido cumplido_span error_input error_span');

    $('#formulario_empleado select').each(function () {
      if ($(this).hasClass('select2-hidden-accessible')) {
        $(this).next('.select2-container').find('.select2-selection').removeClass('cumplido error_input');
      }
    });
  });

  // Observar cambios en cada formulario por separado
  observarFormulario($("#formulario_empleado")[0], $('#aceptar_emepleado'));

});

let numeroCernet = `
<div class="col-sm-12 col-xl-12 col-xxl-6 mb-2" id="contentPartida">
  <div class="form-group">
      <label for="correo">Partida De Discapacidad</label>
      <div class="input-group">
          <span class="input-group-text span_docArchivoDis"><i class="icons fa-regular fa-file-zipper"></i></span>
          <input type="file" class="form-control" name="docArchivoDis" id="archivoDis" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
      </div>
  </div>
</div>
`;