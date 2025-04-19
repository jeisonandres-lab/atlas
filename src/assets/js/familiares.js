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
} from "./utils/inputs.js";

import { alertaNormalmix } from "./utils/alerts.js";
import { enviarFormulario, observarFormulario } from "./utils/formularioAjax.js";
import { setCargarDiscapacidad, setCargarParentesco } from "./utils/variablesArray.js";
import { 
  setVariableArchivo, 
  setVariableCarnetDiscapacidad, 
  setVariableDeAlertaBasica, 
  setVariableDiscapacidad 
} from "./utils/variablesContenido.js";
import { calcularEdad, carculasDias } from "./utils/funciones.js";

/**
 * Módulo Familiares: gestiona todas las funciones relacionadas con el registro de miembros de la familia.
 */
const ModuloFamiliares = (() => {
  // Selectores del DOM
  const SELECTORES = {
    form: '#formulario_empleado',
    cedulaTrabajador: '#cedula_trabajador',
    cedulaFamiliar: '#cedula_familiar',
    cedulaFamiliarPendiente: '#cedulaFamiliarPendiente',
    nombre: '#nombre',
    apellido: '#apellido',
    primerNombre: '#primerNombre',
    segundoNombre: '#segundoNombre',
    primerApellido: '#primerApellido',
    segundoApellido: '#segundoApellido',
    cedula: '#cedula',
    ano: '#ano',
    dia: '#dia',
    meses: '#meses',
    parentesco: '#parentesco',
    familiarTipo: '#familiarTipo',
    sexo: '#sexo',
    edad: '#edad',
    tomo: '#tomo',
    folio: '#folio',
    archivoDis: '#archivoDis',
    archivo: '#archivo',
    tpDiscapacidad: '#tpDiscapacidad',
    noCedula: '#noCedula',
    estadoDerecho: '#estadoDerecho',
    familiarInces: '#familiarInces',
    disca: '#disca',
    limpiar: '#limpiar',
    aceptarEmpleado: '#aceptar_emepleado',
    buscarFamiliarPendiente: '#buscarFamiliarPendiente',
    alerta: '#alerta',
    alertaNoCedula: '#alertaNoCedula',
    contenDoc: '#contenDoc',
    contenEdad: '#contenEdad'
  };

  // Puntos finales de API
  const ENDPOINTS_API = {
    obtenerDatosPersonal: 'src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal',
    buscarFamiliarPendiente: 'src/ajax/registroPersonal.php?modulo_personal=buscarFamiliarPendiente',
    registrarFamilia: 'src/ajax/registroPersonal.php?modulo_personal=registrarFamilia'
  };

  // Constantes de configuración
  const CONFIG = {
    longitudMinimaCedula: 7,
    duracionAlerta: 4000,
    duracionAlertaError: 5000,
    añoInicial: "1900"
  };

  /**
   * Inicializa todos los validadores del formulario
   */
  const inicializarValidadores = () => {
    const validadores = {
      numericos: [
        [SELECTORES.cedulaTrabajador, ".span_cedula_empleado"],
        [SELECTORES.cedulaFamiliarPendiente, ".span_cedulaFamiliarPendiente"],
        [SELECTORES.cedula, ".span_cedula"]
      ],
      nombres: [
        [SELECTORES.nombre, ".span_nombre"],
        [SELECTORES.apellido, ".span_apellido"],
        [SELECTORES.primerNombre, ".span_nombre1"],
        [SELECTORES.segundoNombre, ".span_nombre2"],
        [SELECTORES.primerApellido, ".span_apellido1"],
        [SELECTORES.segundoApellido, ".span_apellido2"]
      ],
      selectores: [
        [SELECTORES.ano, ".span_ano"],
        [SELECTORES.dia, ".span_dia"],
        [SELECTORES.parentesco, ".span_parentesco"],
        [SELECTORES.familiarTipo, ".span_familiarTipo"],
        [SELECTORES.sexo, ".span_sexo"]
      ],
      numeros: [
        [SELECTORES.edad, ".span_edad", 3],
        [SELECTORES.tomo, ".span_tomo", 5, true],
        [SELECTORES.folio, ".span_folio", 4, true]
      ],
      archivos: [
        [SELECTORES.archivoDis, ".span_docArchivo"],
        [SELECTORES.archivo, ".span_achivo"]
      ]
    };

    // Aplicar validadores
    validadores.numericos.forEach(([selector, span]) => validarNumeros(selector, span));
    validadores.nombres.forEach(([selector, span]) => validarNombre(selector, span));
    validadores.selectores.forEach(([selector, span]) => validarSelectores(selector, span));
    validadores.numeros.forEach(([selector, span, ...args]) => validarNumeroNumber(selector, span, ...args));
    validadores.archivos.forEach(([selector, span]) => file(selector, span));
  };

  /**
   * Inicializa los menús desplegables Select2
   */
  const inicializarSelect2 = () => {
    const selectores = [
      SELECTORES.parentesco,
      SELECTORES.ano,
      SELECTORES.meses,
      SELECTORES.dia,
      SELECTORES.sexo
    ];

    // Inicializar Select2
    selectores.forEach(selector => incluirSelec2(selector));

    // Validar Select2
    const validadoresSelect2 = [
      [SELECTORES.parentesco, ".span_parentesco"],
      [SELECTORES.ano, ".span_ano"],
      [SELECTORES.meses, ".span_meses"],
      [SELECTORES.dia, ".span_dia"],
      [SELECTORES.tpDiscapacidad, ".span_tpDiscapacidad"],
      [SELECTORES.sexo, ".span_sexo"]
    ];

    validadoresSelect2.forEach(([selector, span]) => 
      validarSelectoresSelec2(selector, span)
    );

    // Inicializar datos
    colocarYear(SELECTORES.ano, CONFIG.añoInicial);
    colocarMeses(SELECTORES.meses);
    setCargarParentesco(SELECTORES.parentesco);
    carculasDias(SELECTORES.meses, SELECTORES.ano, SELECTORES.dia, ".span_mes");
  };

  /**
   * Maneja la búsqueda de empleado por ID
   */
  const manejarBusquedaEmpleado = () => {
    $(document).on("input", SELECTORES.cedulaTrabajador, function() {
      const valorCedula = $(this).val();
      
      if (valorCedula.length >= CONFIG.longitudMinimaCedula) {
        const datosFormulario = new FormData();
        datosFormulario.append('cedulaEmpleado', valorCedula);
        
        enviarFormulario(
          ENDPOINTS_API.obtenerDatosPersonal, 
          datosFormulario, 
          manejarRespuestaBusquedaEmpleado, 
          true
        );
      }
    });
  };

  /**
   * Callback para la búsqueda de empleado
   * @param {Object} datos - Datos de respuesta del servidor
   */
  const manejarRespuestaBusquedaEmpleado = datos => {
    const { exito, mensaje, nombre, apellido } = datos;
    const $form = $(SELECTORES.form);
    const $cedulaTrabajador = $(SELECTORES.cedulaTrabajador);
    const $nombre = $(SELECTORES.nombre);
    const $apellido = $(SELECTORES.apellido);

    if (exito) {
      // Caso de éxito
      $cedulaTrabajador.addClass("cedulaBusqueda");
      
      // Establecer clases y valores
      [nombre, apellido, cedulaTrabajador].forEach(selector => 
        clasesInputs(SELECTORES[selector], `.span_${selector}`)
      );
      
      $nombre.val(nombre);
      $apellido.val(apellido);
      
      // Habilitar formulario
      $form.find(':input, select').prop('disabled', false);
      $(SELECTORES.aceptarEmpleado).show();
      
      alertaNormalmix(mensaje, CONFIG.duracionAlerta, "success", "top-end");
    } else {
      // Caso de error
      $nombre.val("").add(apellido).val("");
      
      // Establecer clases de error
      [nombre, apellido, cedulaTrabajador].forEach(selector => 
        clasesInputsError(SELECTORES[selector], `.span_${selector}`)
      );
      
      // Restablecer y deshabilitar formulario
      $form.find('select').val('');
      $form.find(`:input:not(${SELECTORES.cedulaTrabajador}, ${SELECTORES.nombre}, ${SELECTORES.apellido}), select`)
        .prop('disabled', true);
      
      alertaNormalmix(mensaje, CONFIG.duracionAlerta, "error", "top-end");
    }
  };

  /**
   * Maneja la búsqueda de familiar pendiente
   */
  const manejarBusquedaFamiliarPendiente = () => {
    $(document).on("click", SELECTORES.buscarFamiliarPendiente, async function() {
      const cedula = $(SELECTORES.cedulaFamiliarPendiente).val();
      
      if (cedula.length >= CONFIG.longitudMinimaCedula) {
        await buscarFamiliarPendiente(cedula);
      } else {
        clasesInputsError(SELECTORES.cedulaFamiliarPendiente, ".span_cedulaFamiliarPendiente");
        alertaNormalmix("Ingrese cédula del familiar pendiente", CONFIG.duracionAlertaError, "error", "top");
      }
    });
  };

  /**
   * Busca un familiar pendiente
   * @param {string} cedula - ID del familiar
   */
  const buscarFamiliarPendiente = async cedula => {
    const datosFormulario = new FormData();
    datosFormulario.append('cedulaFamiliar', cedula);
    
    enviarFormulario(
      ENDPOINTS_API.buscarFamiliarPendiente, 
      datosFormulario, 
      manejarRespuestaBusquedaFamiliarPendiente, 
      true
    );
  };

  /**
   * Callback para la búsqueda de familiar pendiente
   * @param {Object} datos - Datos de respuesta del servidor
   */
  const manejarRespuestaBusquedaFamiliarPendiente = datos => {
    const { exito, cedula, primerNombre, primerApellido, cedulaEmpleado } = datos;
    const $form = $(SELECTORES.form);

    if (exito) {
      // Habilitar formulario
      $form.find(':input, select').prop('disabled', false);
      $(SELECTORES.buscarFamiliarPendiente).val("");
      $('#modalPendiente').modal('hide');

      // Establecer datos
      const datosFamiliar = {
        [SELECTORES.cedula]: cedula,
        [SELECTORES.primerNombre]: primerNombre,
        [SELECTORES.primerApellido]: primerApellido,
        [SELECTORES.nombre]: primerNombre,
        [SELECTORES.apellido]: primerApellido,
        [SELECTORES.cedulaTrabajador]: cedulaEmpleado
      };

      Object.entries(datosFamiliar).forEach(([selector, valor]) => {
        $(selector).val(valor);
        clasesInputs(selector, `.span_${selector.split('#')[1]}`);
      });

      alertaNormalmix("Familiar Pendiente encontrado", CONFIG.duracionAlertaError, "success", "top");
    } else {
      alertaNormalmix("Familiar pendiente no encontrado", CONFIG.duracionAlertaError, "error", "top");
    }
  };

  /**
   * Calcula la edad basada en la fecha de nacimiento
   */
  const manejarCalculoEdad = () => {
    $(document).on("input", `${SELECTORES.dia}, ${SELECTORES.meses}, ${SELECTORES.ano}`, function() {
      const dia = $(SELECTORES.dia).val();
      const mes = $(SELECTORES.meses).val();
      const ano = $(SELECTORES.ano).val();

      if (dia && mes && ano) {
        const fechaNacimiento = new Date(ano, mes - 1, dia);
        const edad = calcularEdad(fechaNacimiento);
        const $edad = $(SELECTORES.edad);
        
        $edad
          .val(edad)
          .addClass("cumplido")
          .removeClass("error_input");
        
        $(".span_edad")
          .addClass("cumplido_span")
          .removeClass("error_span");
      }
    });
  };

  /**
   * Maneja el envío del formulario
   */
  const manejarEnvioFormulario = () => {
    $(document).on("submit", SELECTORES.form, function(event) {
      event.preventDefault();
      
      const accion = $(this).find('button[type="submit"]:focus').attr('name');
      const datosFormulario = new FormData(this);
      
      if ($(SELECTORES.familiarInces).is(":checked")) {
        datosFormulario.append("familiarInces", 'si');
        datosFormulario.append("parentesco", $(SELECTORES.parentesco).val());
      }
      
      if (accion === "aceptar") {
        enviarFormulario(
          ENDPOINTS_API.registrarFamilia, 
          datosFormulario, 
          manejarRespuestaEnvioFormulario, 
          true
        );
      } else {
        console.warn("Los destinos deben tener un error");
      }
    });
  };

  /**
   * Callback para el envío del formulario
   * @param {Object} datosProcesados - Datos de respuesta del servidor
   */
  const manejarRespuestaEnvioFormulario = datosProcesados => {
    const { exito, mensaje } = datosProcesados;
    const $cedulaTrabajador = $(SELECTORES.cedulaTrabajador);
    const $nombre = $(SELECTORES.nombre);
    const $apellido = $(SELECTORES.apellido);

    if (exito) {
      $cedulaTrabajador.addClass("cedulaBusqueda");
      $nombre.addClass("cumplido");
      $apellido.addClass("cumplido");
      $(".span_nombre").addClass("cumplido_span");
      $(".span_apellido").addClass("cumplido_span");
      
      alertaNormalmix(mensaje, CONFIG.duracionAlerta, "success", "top-end");
    } else {
      alertaNormalmix(mensaje, CONFIG.duracionAlerta, "warning", "top-end");
    }
  };

  /**
   * Maneja la casilla de familiar sin cédula
   */
  const manejarFamiliarSinCedula = () => {
    $(document).on("change", SELECTORES.noCedula, function() {
      const $cedula = $(SELECTORES.cedula);
      const $alertaNoCedula = $(SELECTORES.alertaNoCedula);
      
      if ($(this).is(":checked")) {
        $alertaNoCedula.html(setVariableDeAlertaBasica(`
          <strong>Si el familiar es</strong> 
          <strong class="text-primary"> NO CEDULADO</strong> se le creara una cédula el sistema basada en la del trabajador
        `));
        
        $cedula.prop("disabled", true).val("");
        clasesInputs(SELECTORES.cedula, ".span_cedula");
      } else {
        $cedula
          .removeClass("cumplido")
          .prop("disabled", false);
        $(".span_cedula").removeClass("cumplido_span");
      }
    });
  };

  /**
   * Maneja la casilla de estado de derecho
   */
  const manejarEstadoDerecho = () => {
    $(document).on("change", SELECTORES.estadoDerecho, function() {
      const $contenDoc = $(SELECTORES.contenDoc);
      const $archivo = $(SELECTORES.archivo);
      const $cedula = $(SELECTORES.cedula);
      
      if ($(this).is(":checked")) {
        $contenDoc.find("label").text("Docuemento estado de derecho");
        $archivo.attr("name", "docEstadoDerechoArchivo");
      } else {
        $contenDoc.find("label").text("Partida de nacimiento");
        $archivo.attr("name", "docArchivo");
        $cedula.prop("disabled", false);
      }
    });
  };

  /**
   * Maneja la casilla de familiar INCE
   */
  const manejarFamiliarInce = () => {
    $(document).on("change", SELECTORES.familiarInces, function() {
      const $form = $(SELECTORES.form);
      const $alerta = $(SELECTORES.alerta);
      const $parentesco = $(SELECTORES.parentesco);
      const $noCedula = $(SELECTORES.noCedula);
      const $estadoDerecho = $(SELECTORES.estadoDerecho);
      const $cedula = $(SELECTORES.cedula);
      
      if ($(this).is(":checked")) {
        $alerta.html(setVariableDeAlertaBasica(`
          <strong>Tras aceptar que este familiar es un trabajaor </strong> 
          <strong class="text-danger">Inces</strong> solo debe de colocar
          <strong class="text-primary"></strong>los campos que esten 
          <strong class="text-success">DESABILITADOS</strong> para finalizar el registro.
        `));
        
        // Deshabilitar campos
        const camposHabilitados = [
          SELECTORES.cedulaTrabajador,
          SELECTORES.nombre,
          SELECTORES.apellido,
          '#buttonPendiente',
          SELECTORES.limpiar,
          SELECTORES.primerNombre,
          SELECTORES.primerApellido,
          SELECTORES.cedula,
          SELECTORES.familiarInces,
          SELECTORES.tomo,
          SELECTORES.folio,
          SELECTORES.archivo,
          SELECTORES.disca,
          '#aceptar'
        ].join(',');
        
        $form.find(`:input:not(${camposHabilitados}), select:not(${SELECTORES.parentesco})`)
          .prop('disabled', true)
          .addClass('cumplidoNormal');
        
        // Establecer valores
        $parentesco.val('Estado De Derecho').trigger('change');
        $noCedula.prop('checked', false).trigger('change');
        $estadoDerecho.prop('checked', true).trigger('change');

        // Validar ID si es necesario
        if (!$cedula.hasClass("cumplido") && $cedula.val().trim() !== "") {
          clasesInputs(SELECTORES.cedula, ".span_cedula");
        }
      } else {
        // Restablecer formulario
        $alerta.html("");
        $form.find(':input, select').prop('disabled', false);
        $estadoDerecho.prop('checked', false).trigger('change');
        $parentesco.val('').trigger('change');
      }
    });
  };

  /**
   * Maneja la casilla de discapacidad
   */
  const manejarDiscapacidad = () => {
    $(document).on("change", SELECTORES.disca, function() {
      const $contenedor = $(SELECTORES.contenEdad);
      
      if ($(this).is(":checked")) {
        // Agregar campos de discapacidad
        $contenedor.after(
          setVariableCarnetDiscapacidad("carnet", "carnet") +
          setVariableDiscapacidad("tpDiscapacidad", "tpDiscapacidad") +
          setVariableArchivo("archivoDis", "docArchivoDis", "Partida De Discapacidad", "span_docArchivoDis", "contentArchiDiscapacidad")
        );
        
        incluirSelec2("#tpDiscapacidad");
        setCargarDiscapacidad("#tpDiscapacidad");
      } else {
        // Eliminar campos de discapacidad
        $("#contentDiscapacidad, #contenCarnet, #contentArchiDiscapacidad").remove();
      }
    });
  };

  /**
   * Valida que los IDs del empleado y del familiar sean diferentes
   */
  const validarIdsDiferentes = () => {
    $(document).on("input", `${SELECTORES.cedulaTrabajador}, ${SELECTORES.cedulaFamiliar}`, function() {
      const cedulaTrabajador = $(SELECTORES.cedulaTrabajador).val();
      const cedulaFamiliar = $(SELECTORES.cedulaFamiliar).val();
      
      if (cedulaTrabajador && cedulaFamiliar && cedulaTrabajador === cedulaFamiliar) {
        clasesInputsError(SELECTORES.cedula, ".span_cedula");
      }
    });
  };

  /**
   * Limpia los campos del formulario
   */
  const manejarLimpiezaFormulario = () => {
    $(SELECTORES.limpiar).on("click", function() {
      const $form = $(SELECTORES.form);
      
      // Restablecer casillas y limpiar campos
      $form.find('input[type="checkbox"]').prop('checked', false).trigger('change');
      $(".imgFoto").remove();
      $form.find('select').val('').trigger('change');
      $form.find(':input').val('');
      
      // Deshabilitar campos
      const camposHabilitados = [
        SELECTORES.cedulaTrabajador,
        SELECTORES.nombre,
        SELECTORES.apellido,
        '#buttonPendiente',
        SELECTORES.limpiar
      ].join(',');
      
      $form.find(`:input:not(${camposHabilitados}), select`).prop('disabled', true);
      
      // Eliminar clases
      $form.find(':input, select, span').removeClass('cumplido cumplido_span error_input error_span');

      // Restablecer Select2
      $form.find('select').each(function() {
        if ($(this).hasClass('select2-hidden-accessible')) {
          $(this).next('.select2-container').find('.select2-selection')
            .removeClass('cumplido error_input');
        }
      });
    });
  };

  /**
   * Inicializa el módulo
   */
  const inicializar = () => {
    inicializarValidadores();
    inicializarSelect2();
    manejarBusquedaEmpleado();
    manejarBusquedaFamiliarPendiente();
    manejarCalculoEdad();
    manejarEnvioFormulario();
    manejarFamiliarSinCedula();
    manejarEstadoDerecho();
    manejarFamiliarInce();
    manejarDiscapacidad();
    validarIdsDiferentes();
    manejarLimpiezaFormulario();
    
    // Observar cambios en el formulario
    observarFormulario($(SELECTORES.form)[0], $(SELECTORES.aceptarEmpleado));
  };

  // API pública
  return {
    inicializar
  };
})();

// Inicializar cuando el documento esté listo
$(function() {
  ModuloFamiliares.inicializar();
});
