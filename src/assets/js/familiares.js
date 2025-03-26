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
import { setVariableArchivo, setVariableCarnetDiscapacidad, setVariableDeAlertaBasica, setVariableDiscapacidad } from "./ajax/variablesContenido.js";
import { calcularEdad, carculasDias } from "./ajax/funciones.js";

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

  // EVENTO PARA BUSCAR DATOS DE EMPLEADO
  $(document).on("input", "#cedula_trabajador", function () {
    function callbackExito(data) {
      // VALIDACION DEL FORMULARI CUANDO EL EMPLEADO FUE ENCONTRADO CON EXITO 
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
        // ACOMODO DE LOS DATOS CUAND OEL FORMULARIO ES ERRADO 
        $("#nombre, #apellido").val("");
        // inputs error del empleado
        clasesInputsError("#nombre", ".span_nombre");
        clasesInputsError("#apellido", ".span_apellido");
        clasesInputsError("#cedula_trabajador", ".span_cedula_empleado");
        // todos los inputs desabilitados
        $('#formulario_empleado').find('select').val('')
        $('#formulario_empleado :input:not(#cedula_trabajador, #nombre, #apellido), #formulario_empleado select').prop('disabled', true);
        alertaNormalmix(data.mensaje, 4000, "error", "top-end");
      }
    }

    // SI LA CEDULA DEL EMPLEADO NO CUMPLE CON LOS REQUISITOS MINIMOS DE 7 DIGITOS NO SE ENVIA EL FORMUALRIO
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

  // EVENTO DE ENVIO DE FORMULARIO
  $(document).on("submit", "#formulario_empleado", function (event) {
    event.preventDefault();
    // TECLA DE ACCION PARA ENVIAR DATOS POR EL FORMULARIO
    const accion = $(this).find('button[type="submit"]:focus').attr('name');
    // FORMUALRIO DE ENVIO
    const formData = new FormData(this); // CREAR FORMULARIO DEL FORM
    if ($("#familiarInces").is(":checked")) {
      formData.append("familiarInces", 1); // AGREGAR EL NUEVO VALOR DEL FAMILIAR INCES
      formData.append("parentesco", $("#parentesco").val()); // AGREGAR EL NUEVO VALOR DEL PARENTESCO
    }
    // SI EL BOTON TIENE EL PARAMETRO ACEPTAR
    if (accion == "aceptar") {

      // callback de exito
      function callbackExito(parsedData) {
        if (parsedData.resultado == 2) {
          // esta parte se puede mejorar
          // se marcar cumplido logrado
          $("#cedula_trabajador").addClass("cedulaBusqueda");
          $("#nombre").addClass("cumplido");
          $("#apellido").addClass("cumplido");
          $(".span_nombre").addClass("cumplido_span");
          $(".span_apellido").addClass("cumplido_span");
          alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
        } else if (parsedData.resultado == 3) {
          // ALERTA DE EXITO
          alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
        } else {
          // ALERTA DE ERROR
          alertaNormalmix(parsedData.mensaje, 4000, "warning", "top-end");
        }
      }
      const formDataArray = Array.from(formData.entries());
      console.log(formDataArray);
      // enviarFormulario("src/ajax/registroPersonal.php?modulo_personal=registrarFamilia", formData, callbackExito, true);
    } else {
      console.log("los destinos deben de tener un  error");
    }
  });

  // EVENTO DE CHECKBOX DE NO CEDULADO
  $(document).on("change", "#noCedula", function () {
    if ($(this).is(":checked")) {
      // SI EL FAMILIAR ES NO CEDULA SE BLOQUEA LA CEDULA Y  SE LE AGREGA UNA NUEVA CLASE
      $("#alertaNoCedula").html(setVariableDeAlertaBasica(`
        <strong>Si el familiar es</strong> 
        <strong class="text-primary"> NO CEDULADO</strong> se le creara una cédula el sistema basada en la del trabajador
        `));
      $("#cedula").prop("disabled", true).val("");
      clasesInputs("#cedula", ".span_cedula")
    } else {
      // SI EL FAMILIAR ES CEDULADO SE EMILINAN LAS CLASES QUE NO SEN ENCESARIAS
      $("#cedula").removeClass("cumplido");
      $(".span_cedula").removeClass("cumplido_span");
      $("#cedula").prop("disabled", false);
    }
  });

  // EVENTO DE CHECKBOX DE ESTADO DE DERECHO
  $(document).on("change", "#estadoDerecho", function () {
    if ($(this).is(":checked")) {
      // EDITAR EL ARCHIVO PARA ESTADO DE DERECHO
      $("#contenDoc label").text("Docuemento estado de derecho");
      $("#archivo").attr("name", "docEstadoDerechoArchivo");
    } else {
      // ACOMODAR DATOS DE FAMILIAR POR ESTADO DE DERECHO 
      $("#contenDoc label").text("Partida de nacimiento");
      $("#archivo").attr("name", "docArchivo");
      $("#cedula").prop("disabled", false);
    }
  });

  // CHECKBOX FAMILIAR INCES
  $(document).on("change", "#familiarInces", function () {
    if ($(this).is(":checked")) {
      // docfamiliarIncesArchivo
      $("#alerta").html(setVariableDeAlertaBasica(`<strong>Tras aceptar que este familiar es un trabajaor </strong> <strong class="text-danger">Inces</strong> solo debe de colocar<strong class="text-primary"></strong>los campos que esten <strong class="text-success">DESABILITADOS</strong> para finalizar el registro.`))
      $('#formulario_empleado :input:not(#cedula_trabajador, #nombre, #apellido, #buttonPendiente, #limpiar, #primerNombre, #primerApellido, #cedula, #familiarInces, #tomo, #folio, #archivo, #familiarInces, #disca, #aceptar), #formulario_empleado select:not(#parentesco)').prop('disabled', true).addClass('cumplidoNormal');
      // EVENTO SE SELECT Y CHECKBOX
      $('#parentesco').val('Estado De Derecho').trigger('change');
      $('#noCedula').prop('checked', false).trigger('change');
      $('#estadoDerecho').prop('checked', true).trigger('change');

      // VALIDAR LOS DATOS DE LA CEDULA
      if (!$("#cedula").hasClass("cumplido") && $("#cedula").val().trim() !== "") {
        clasesInputs("#cedula", ".span_cedula");
      }
    } else {
      // LIMPIAR DATOS DE NO FAMILIAR INCES
      $("#alerta").html("")
      $('#formulario_empleado :input, #formulario_empleado select').prop('disabled', false);
      $('#estadoDerecho').prop('checked', false).trigger('change');
      $('#parentesco').val('').trigger('change');
    }
  });

  // EVENTO DE CHECKBOX DE DISCAPACIDAD
  $(document).on("change", "#disca", function () {
    if ($(this).is(":checked")) {
      var contenedor = $("#contenEdad");
      // Insertamos el nuevo contenido después del contenedor
      $(contenedor).after(
        setVariableCarnetDiscapacidad("carnet", "carnet") +
        setVariableDiscapacidad("tpDiscapacidad", "tpDiscapacidad") +
        setVariableArchivo("archivoDis", "docArchivoDis", "Partida De Discapacidad", "span_docArchivoDis", "contentArchiDiscapacidad"));
      incluirSelec2("#tpDiscapacidad");
      setCargarDiscapacidad("#tpDiscapacidad");
    } else {
      // REMOVER EL CONTENIDO
      $("#contentDiscapacidad").remove()
      $("#contenCarnet").remove()
      $("#contentArchiDiscapacidad").remove()
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
