
import {
  colocarMeses,
  colocarYear,
  validarBusquedaCedula,
  validarNombre,
  validarNumeros,
  validarSelectores,
  validarTelefono,
  file,
  validarSelectoresSelec2,
  incluirSelec2,
  clasesInputsError,
  validarDosDatos,
  validarNombreConEspacios,
  validarNumeroNumber,
  validarInputFecha,
  clasesInputs,
  llenarSelect,
} from "./ajax/inputs.js";

import {
  enviarFormulario,
  observarFormulario,
  obtenerDatosJQuery
} from "./ajax/formularioAjax.js";

import {
  alertaBasica,
  alertaNormalmix,
  AlertDirection,
  AlertSW2,
} from "./ajax/alerts.js";

import {
  setCargarDiscapacidad,
  setCargarEstadoCivil,
  setCargarNivelesAcademicos,
  setCargarSexo,
  setCargarTipoVivienda
} from "./ajax/variablesArray.js";

import {
  calcularEdad,
  carculasDias,
  cedulaExisteEmpleado,
  recargarConVerificacionDeCache
} from "./ajax/funciones.js";

import {
  buscarMunicipioPorEstado,
  buscarParroquiaPorMunicipio
} from "./ajax/peticiones.js";

import {
  setContenedorNombreDepa,
  setContenedorNumDepa,
  setContenedorPiso,
  setVariableApellidoFamiliar,
  setVariableCedulaFamiliar,
  setVariableCheckboxInces,
  setVariableDocumentoFamiliar,
  setVariableNombreFamiliar,
  setVariableNumVivienda
} from "./ajax/variablesContenido.js";

import {
  configurarFlatpickrSinFinesDeSemana
} from "./ajax/inputCalendar.js";

import {
  formulariomultiple
} from "./ajax/multiForm.js";
// jQuery
$(function () {
  $(".formulario_empleado").hide();
  // todos los elementos del body en hide
  $("#contenTipoDiscapacidad").hide();
  $("#contentPartida").hide();
  $("#botonModalEstadoDerecho").hide();
  // formulario de registro
  validarNombre("#primerNombre", ".span_nombre");
  validarNombre("#segundoNombre", ".span_nombre2");
  validarNombre("#primerApellido", ".span_apellido");
  validarNombre("#segundoApellido", ".span_apellido2");
  validarNombreConEspacios("#calle", ".span_calle");
  validarNombreConEspacios("#urbanizacion", ".span_urbanizacion");
  validarNumeros("#cedula", ".span_cedula");
  validarNumeroNumber("#edad", ".span_edad", 2);
  validarNumeroNumber("#piso", ".span_piso", 2);
  validarNumeroNumber("#numeroVivienda", ".span_numeroVivienda", 4);
  validarBusquedaCedula("#cedula", ["#img-modals", "#img-contener"]);
  validarInputFecha("#fechaing", ".span_fechaing")
  colocarYear("#ano", "1900");
  colocarMeses("#meses");
  validarTelefono("#telefono", ".span_telefono", "#linea");
  validarSelectores("#ano", ".span_ano", "1");
  validarSelectores("#dia", ".span_dia", "1");
  file("#contrato", ".span_contrato");
  file("#notificacion", ".span_notificacion");
  file("#achivoDis", ".span_docArchivoDis");

  // formulario de empleados por select 2
  incluirSelec2("#estatus");
  incluirSelec2("#cargo");
  incluirSelec2("#departamento");
  incluirSelec2("#dependencia");
  incluirSelec2("#estado");
  incluirSelec2("#municipio");
  incluirSelec2("#parroquia");
  incluirSelec2("#ano");
  incluirSelec2("#meses");
  incluirSelec2("#dia");
  incluirSelec2("#civil");
  incluirSelec2("#sexo");
  incluirSelec2("#vivienda");
  incluirSelec2("#academico");

  validarSelectoresSelec2("#dependencia", ".span_dependencia");
  validarSelectoresSelec2("#estatus", ".span_estatus");
  validarSelectoresSelec2("#cargo", ".span_cargo");
  validarSelectoresSelec2("#departamento", ".span_departamento");
  validarSelectoresSelec2("#dependencia", ".span_dependencia");
  validarSelectoresSelec2("#academico", ".span_academico");
  validarSelectoresSelec2("#sexo", ".span_sexo");
  validarSelectoresSelec2("#estado", ".span_estado");
  validarSelectoresSelec2("#municipio", ".span_municipio");
  validarSelectoresSelec2("#parroquia", ".span_parroquia");
  validarSelectoresSelec2("#vivienda", ".span_vivienda");
  validarSelectoresSelec2("#ano", ".span_ano");
  validarSelectoresSelec2("#meses", ".span_meses");
  validarSelectoresSelec2("#dia", ".span_dia");
  validarSelectoresSelec2("#civil", ".span_civil");
  validarSelectoresSelec2("#tpDiscapacidad", ".span_tpDiscapacidad");

  validarDosDatos("#numeroDepa", ".span_numeroDepa");
  setCargarEstadoCivil("#civil"); // Carga los estados civiles
  setCargarSexo("#sexo"); // Carga los sexos
  setCargarNivelesAcademicos("#academico"); // Carga los niveles académicos
  setCargarTipoVivienda("#vivienda"); // Carga los tipos de vivienda
  setCargarDiscapacidad("#tpDiscapacidad")

  carculasDias("#meses", "#ano", "#dia", ".span_mes"); // funcion de calcular dias de los meses
  $("#meses").trigger("input"); // ejecucion de calcular los meses


  // modal de estado civil

  //cargar calendario 
  configurarFlatpickrSinFinesDeSemana("#fechaing3");
  let contenidoAlerta = `
              <div class="d-flex alert alert-warning alert-dismissible m-0 contentAlerta" role="alert" >
                <div class="d-flex align-items-center alert-icon me-3">
                  <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-text">
                  <strong>Debes de llenar los campos </strong> con los datos necesarios, <strong class="text-success">cada campo debe de estar de color verde</strong>, si alguno esta de<strong class="text-danger"> color rojo</strong> no podra pasar a la otra página.
                </div>
              </div>
            `;
  formulariomultiple('.f1 .btn-next', "#alert", contenidoAlerta);
  //Función para realizar consultas y llenar selectores
  async function realizarConsultas() {
    const urls = [
      "src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerCargo",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerEstados"
    ];

    try {
      const results = await Promise.allSettled(urls.map(url => obtenerDatosJQuery(url)));

      const selectores = [
        { result: results[0], selector: 'dependencia', mensaje: 'Seleccione una dependencia' },
        { result: results[1], selector: 'estatus', mensaje: 'Seleccione un estatus' },
        { result: results[2], selector: 'cargo', mensaje: 'Seleccione un cargo' },
        { result: results[3], selector: 'departamento', mensaje: 'Seleccione un departamento' },
        { result: results[4], selector: 'estado', mensaje: 'Seleccione un estado' },
      ];

      selectores.forEach(async ({ result, selector, mensaje }) => {
        if (result.status === 'fulfilled' && result.value.exito && result.value.data) {
          await llenarSelect(result.value.data, selector, mensaje);
        } else {
          console.error(`Error al obtener ${selector} o la estructura de la respuesta es incorrecta`);
        }
      });
    } catch (error) {
      console.error('Error al realizar las consultas:', error);
    }
  }

  //formulario de registro de trabajadores 
  $(document).on("submit", "#formulario_registro", async function (e) {
    e.preventDefault();
    const fechaIngreso = $("#fechaing3").val().split("-").reverse().join("-");
    const data = new FormData(this);
    data.append("fechaing", fechaIngreso);
    if ($("#btnEDInces").prop('checked')) {
      data.append("FamiliarInces", "si");
    }
    const url = "src/ajax/registroPersonal.php?modulo_personal=registrar";
    $("#aceptar").prop("disabled", true);
    async function callbackExito(parsedData) {
      if (parsedData.exito) {
        console.log(parsedData.exito)
        $("#aceptar").prop("disabled", false);
        await AlertDirection("success", parsedData.mensaje, "top", 7000, recargarConVerificacionDeCache());
      } else {
        await alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
        // if (error) limpiarFormulario($("#formulario_registro"));
      }
    }
    await enviarFormulario(url, data, callbackExito, true);
  });

  // cargar datos de personal de discapacidad
  $(document).on("click", ".buttonDisca", function () {
    incluirSelec2("#tpDiscapacidad");
    const boton = $(this);
    const contenedor = $("#contentPartida");
    const tipoDiscapacidad = $("#contenTipoDiscapacidad");

    // Verificar el ID del botón
    if (boton.attr("id") === "asignarDisca") {

      // Mostrar contenedores con animación
      tipoDiscapacidad.slideDown(500);
      contenedor.slideDown(500);

      // Cambiar el ID y texto del botón
      boton.attr("id", "cargaDiscaEliminar");
      boton.html('<i class="fa-solid fa-xmark me-2"></i> Eliminar Todo');
    } else if (boton.attr("id") === "cargaDiscaEliminar") {
      // Agregar la clase ignore-validation a los inputs
      $("#tpDiscapacidad").addClass("ignore-validation");
      $("#achivoDis").addClass("ignore-validation");

      $("#tpDiscapacidad").select2('destroy');
      // Limpiar los valores de los inputs
      $("#tpDiscapacidad").val("");
      $("#achivoDis").val("");

      // Ocultar contenedores con animación
      tipoDiscapacidad.slideUp(500);
      contenedor.slideUp(500);

      // Cambiar el ID y texto del botón
      boton.attr("id", "asignarDisca");
      boton.html('<i class="fa-solid fa-plus me-2"></i> Asignar Discapacidad');
    }
  });

  // cargar vivienda
  $(document).on("change", "#vivienda", async function () {
    let vivienda = $(this).val();
    if (vivienda == 'Departamento') {
      // Crea el HTML que quieres insertar
      const pisoContenedor = setContenedorPiso('piso', 'piso');
      const nombreDepaContenedor = setContenedorNombreDepa('urbanizacion', 'urbanizacion');
      const numDepaContenedor = setContenedorNumDepa('numeroDepa', 'numeroDepa');
      const nuevoHTML = pisoContenedor + nombreDepaContenedor + numDepaContenedor;
      // Inserta el HTML después del elemento con ID "contenCalle"
      $("#contenCalle").after(nuevoHTML);
    } else {
      // Si el valor del select no es "Departamento", elimina el HTML adicional (si existe)
      $("#contenPiso").remove();
      $("#contenNombreDepa").remove();
      $("#contenNumDepa").remove();
    }

    if (vivienda == 'Casa') {
      // Crea el HTML que quieres insertar
      const vivienda = setVariableNumVivienda('numeroVivienda', 'numeroVivienda');
      // Inserta el HTML después del elemento con ID "contenCalle"
      $("#contenCalle").after(vivienda);
    } else {
      // Si el valor del select no es "Departamento", elimina el HTML adicional (si existe)
      $("#contenNVivienda").remove();
    }
  });

  // fechas de ingreso de los trabajadores
  $(document).on("change", "#fechaing3", async function () {
    let fechaING = $(this).val();
    let diaN = $("#dia").val();
    let mesN = $("#meses").val();
    let anoN = $("#ano").val();
    let fechaNacimientoStr = anoN + "-" + mesN + "-" + diaN; // Formato YYYY-MM-DD
    let fechaIngresoStr = fechaING.split("-").reverse().join("-"); // Formato YYYY-MM-DD
    let fechaNacimiento = new Date(fechaNacimientoStr);
    let fechaIngreso = new Date(fechaIngresoStr);
    if (fechaIngreso > fechaNacimiento) {
      await clasesInputs("#fechaing3", ".span_fechaing");
    } else {
      await clasesInputsError("#fechaing3", ".span_fechaing");

    }
  });

  // calcular la edad por los días 
  $(document).on("input", "#dia, #meses, #ano", function () {
    const dia = $("#dia").val();
    const mes = $("#meses").val();
    const ano = $("#ano").val();

    if (!ano) {
      alertaNormalmix("Seleccione un año.", 2000, "warning", "top");
      return; // Detiene la ejecución si el año está vacío
    }

    if (!mes) {
      alertaNormalmix("Seleccione un mes.", 2000, "warning", "top");
      return; // Detiene la ejecución si el mes está vacío
    }

    if (!dia) {
      alertaNormalmix("Seleccione un día.", 2000, "warning", "top");
      return; // Detiene la ejecución si el día está vacío
    }


    const fechaNacimiento = new Date(ano, mes - 1, dia);
    const calcularEdad2 = calcularEdad(fechaNacimiento);
    $("#edad").val(calcularEdad2);
    clasesInputs("#edad", ".span_edad");

    // Validar la edad (si la fecha de nacimiento es válida)
    if (!isNaN(fechaNacimiento.getTime())) {
      if (calcularEdad2 >= 100) {
        alertaNormalmix(`¡Wow! Tienes ${calcularEdad2} de edad, ¡felicitaciones! al empleado`, 4000, "info", "top");
      }

      if (calcularEdad2 < 18) {
        alertaBasica(`Lamentablemente, no podemos permitir el acceso a esta persona. La edad mínima requerida es de 18 años, y esta persona tiene ${calcularEdad2} años`, 7000, "info", "top-center", "Edad no requerida");
        clasesInputsError("#edad", ".span_edad");
      }

    }
  });

  // el evento de estado civil del modal
  $(document).on("change", "#civil", async function () {
    // DATOS DE IDENTIFICACION 
    const cedulaHTML = setVariableCedulaFamiliar("cedulaFamiliar", "cedulaFamiliar");
    const nombreHTML = setVariableNombreFamiliar("nombreFamiliar", "primerNombreFamiliar");
    const apellidoHTML = setVariableApellidoFamiliar("apellidoFamiliar", "primerApellidoFamiliar");
    // DOCUMENTO DE ESTADO DE DERECHO
    const documentoEstadoDerechoHTML = setVariableDocumentoFamiliar("docEstadoDerecho", "docEstadoDerechoArchivo", "span_docEstadoDerecho", "Documento estado derecho");
    // DOCUMENTO DE CASADO
    const documentoCasadoHTML = setVariableDocumentoFamiliar("docCasado", "docCasadoArchivo", "span_docCasado", "Acta de matrimonio");
    // DOCUMENTO DE LA COPIA DE LA CEDULA DE IDENTIDAD
    const documentoCopiaCedulaHTML = setVariableDocumentoFamiliar("docCopiaCedula", "docCopiaCedulaArchivo", "span_docCopiaCedula", 'Copia de cédula');
    // DOCUMENTO DE VIUDO
    const documentoViudoHTML = setVariableDocumentoFamiliar("docViuda", "docViudaArchivo", "span_docViuda", "Acta de defunción");
    // DOCUMENTO DEL DIVORCIO
    const documentoActaDivorcioHTML = setVariableDocumentoFamiliar("docDivorcio", "docDivorcioArchivo", "span_docDivorcio", "Acta de divorcio");
    // DOCUMENTO DE ACTA DE CAMBIO DE ESTADO CIVIL DEL DEVORCIO
    const documentoActaDivorcioCivilHTML = setVariableDocumentoFamiliar("docSolicEstCivil", "docSolicEstCivilArchivo", "span_docSolicEstCivil", "Carta de cambio de estado civil");
    // CHECKBOX DE EMPLEAOD INCES
    const checkboxHTML = setVariableCheckboxInces("btnEDInces", `Empleado <strong class="text-danger">INCES</strong>`, "contenchecbox")
    // MODAL DE ESTADO DE DERECHO TOTAL DE TODOS LOS ESADOS CIVIL
    $('#estadoDerecho').modal({
      backdrop: 'static',
      keyboard: true
    });

    // documentos de estado de derecho
    if ($(this).val() === "EstadoDerecho") {
      $('#estadoDerecho').modal('show');
      $("#exampleModalLabel").text("Estado De Derecho");
      $(".contendorEstadoDerecho").html(checkboxHTML + cedulaHTML + nombreHTML + apellidoHTML + documentoEstadoDerechoHTML);
      // validaciones
      file("#docEstadoDerecho", ".span_docEstadoDerecho");
    }

    // documento de casado
    if ($(this).val() === "Casado") {
      $('#estadoDerecho').modal('show');
      $("#exampleModalLabel").text("Casado");
      $(".contendorEstadoDerecho").html(documentoCasadoHTML + documentoCopiaCedulaHTML);
      // validaciones
      file("#docCasado", ".span_docCasado");
      file("#docCopiaCedula", ".span_docCopiaCedula");

    }

    // documento de viudo
    if ($(this).val() === "Viudo") {
      $('#estadoDerecho').modal('show');
      $("#exampleModalLabel").text("Viudo");
      $(".contendorEstadoDerecho").html(documentoViudoHTML + documentoCopiaCedulaHTML);
      // validaciones
      file("#docViuda", ".span_docViuda");
      file("#docCopiaCedula", ".span_docCopiaCedula");
    }

    // documento de divorcio
    if ($(this).val() === "Divorciado") {
      $('#estadoDerecho').modal('show');
      $("#exampleModalLabel").text("Divorciado");
      $(".contendorEstadoDerecho").html(documentoActaDivorcioHTML + documentoActaDivorcioCivilHTML);

      // validaciones
      file("#docDivorcio", ".span_docDivorcio");
      file("#docSolicEstCivil", ".span_docSolicEstCivil");
    }

    // validaciones general de estado de derecho
    validarNumeros("#cedulaFamiliar", ".span_cedulaFamiliar");
    validarNombre("#nombreFamiliar", ".span_nombreFamiliar");
    validarNombre("#apellidoFamiliar", ".span_apellidoFamiliar");
  });

  // Maneja el clic en el botón "aceptarModalEstadoDerecho"
  $(document).on('click', '#aceptarModalEstadoDerecho', function () {
    $('#estadoDerecho').modal('hide'); // Oculta el modal
    $("#botonModalEstadoDerecho").slideDown(400);
  })

  // Maneja el clic en el botón "cerrarModalEstadoDerecho"
  $(document).on('click', '#cerrarModalEstadoDerecho', function () {
    // // Limpia los inputs y aplica las clases (misma lógica que "aceptar")
    $('#estadoDerecho').modal('hide'); // Oculta el modal
    $("#botonModalEstadoDerecho").slideUp(400);
  })

  // evento de escucha del evento modal abierto 
  $('#estadoDerecho').on('show.bs.modal', function (e) {
    // Remueve las clases cuando el modal se muestra
    file("#docEstadoDerecho", ".span_docEstadoDerecho");
    $('#cedulaFamiliar, #nombreFamiliar, #apellidoFamiliar, #docEstadoDerecho').removeClass('ignore-validation cumplidoNormal');
  });

  // validar doble cedula
  $(document).on('input', '#cedulaFamiliar', function () {
    const cedulaFamiliarValue = $('#cedulaFamiliar').val();
    const cedulaValue = $('#cedula').val();
    if (cedulaFamiliarValue.length >= 7 && cedulaValue.length >= 7) {
      if ($(this).val() == $("#cedula").val()) {
        AlertSW2("error", "La cédula del familiar no puede ser la misma que la del trabajador", "top", 3000);
        clasesInputsError("#cedulaFamiliar", ".span_cedulaFamiliar");
      }
    }
  })

  // validar el evneto del boton de estado de derecho inces
  $(document).on("change", '#btnEDInces', async function () {
    $("#cedulaFamiliar").val("");

    if ($(this).prop('checked')) {
      console.log("activo")
      $("#cedulaFamiliar").removeClass("busquedaCedula");
      $('#nombreFamiliar, #apellidoFamiliar').prop('disabled', true).val('').addClass('cumplido ignore-validation');

    } else {
      // Si el checkbox está marcado, habilita los inputs y agrega la clase busquedaCedula
      $('#nombreFamiliar, #apellidoFamiliar').prop('disabled', false).removeClass('cumplido ignore-validation').val('');
      $("#cedulaFamiliar").addClass("busquedaCedula");

    }
  });

  // buscar empelado por medio de la dcedula del familiar por si ecxiste ya esa cedula como empleado
  $(document).on("input", "#cedulaFamiliar", async function () {
    if ($(this).hasClass("busquedaCedula")) {
      await cedulaExisteEmpleado("#cedulaFamiliar", ".span_cedulaFamiliar", "La cédula le pertenece a un trabajador inces");
    }
  });
  
  // buscar empelado por medio de la dcedula del familiar por si ecxiste ya esa cedula como empleado
  $(document).on("input", "#cedula", async function () {
    if ($(this).hasClass("busquedaCedula")) {
      await cedulaExisteEmpleado("#cedula", ".span_cedula", "Este empleado ya esta registrado en el sistema ");
    }
  });

  // Llamar a la función para realizar las consultas
  realizarConsultas();// realizar la cunsultas por promesas
  //cargar los datos de estaod y municipio
  buscarMunicipioPorEstado('#estado', '#municipio');
  buscarParroquiaPorMunicipio('#municipio', '#parroquia');
  // Observar cambios en cada formulario por separado
  observarFormulario($("#formulario_registro")[0], $('#aceptar'));
  observarFormulario($(".contendorEstadoDerecho")[0], $('#aceptarModalEstadoDerecho'));

});