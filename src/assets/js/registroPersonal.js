// IMPORT DE VALIDACION DE INPUTS 
import {  alertaNormalmix } from "./utils/alerts.js";
import {  observarFormulario } from "./utils/formularioAjax.js";
import {  carculasDias, crearManejadorEdad, validarBusquedaCedula } from "./utils/funciones.js";
import { configurarFlatpickrSinFinesDeSemana } from "./utils/inputCalendar.js";
import {
  colocarMeses,
  colocarYear,
  validarNombre,
  validarNumeros,
  validarSelectoresSelec2,
  incluirSelec2,
  validarNombreConEspacios,
  validarNumeroNumber,
  validarInputFecha,
  llenarSelect,
} from "./utils/inputs.js";
import { formulariomultiple } from "./utils/multiForm.js";
import { buscarMunicipioPorEstado, buscarParroquiaPorMunicipio } from "./utils/peticiones.js";
import { setCargarDiscapacidad, setCargarEstadoCivil, setCargarNivelesAcademicos, setCargarSexo, setCargarTipoVivienda } from "./utils/variablesArray.js";

/**
 * Módulo Personal: gestiona todas las funciones relacionadas con el registro de personal
 */
const ModuloPersonal = (() => {
  // Selectores del DOM
  const selectores = {
    cedula: '#cedula',
    primerNombre: '#primerNombre',
    segundoNombre: '#segundoNombre',
    primerApellido: '#primerApellido',
    segundoApellido: '#segundoApellido',
    calle: '#calle',
    urbanizacion: '#urbanizacion',
    edad: '#edad',
    fechaIngreso: '#fechaing3',
    ano: '#ano',
    meses: '#meses',
    dia: '#dia',
    civil: '#civil',
    sexo: '#sexo',
    vivienda: '#vivienda',
    academico: '#academico',
    formulario: '#formulario_registro',
    btnAceptar: '#aceptar',
    discapacidad: '.buttonDisca',
    contenedores: {
      formularioEmpleado: '.formulario_empleado',
      discapacidad: '#contenTipoDiscapacidad',
      partida: '#contentPartida',
      estadoDerecho: '#botonModalEstadoDerecho'
    }
  };

  // Constantes para mensajes y configuración
  const mensajes = {};

  // Configuración para el cálculo de edad
  const configEdad = {
    selectores
  };

  // Crear el manejador de edad
  
  const manejarCalculoEdad = crearManejadorEdad(configEdad);

  // cargar alerta del formulario
  const contenidoAlerta = `
    <div class="d-flex alert alert-warning alert-dismissible m-0 contentAlerta" role="alert" >
      <div class="d-flex align-items-center alert-icon me-3">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
      <div class="alert-text">
        <strong>Debes de llenar los campos </strong> con los datos necesarios, <strong class="text-success">cada campo debe de estar de color verde</strong>, si alguno esta de<strong class="text-danger"> color rojo</strong> no podra pasar a la otra página.
      </div>
    </div>
  `;

  // endpoints de API
  const endpoints = {
    obtenerDependencias: 'src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias',
    obtenerEstatus: 'src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus',
    obtenerCargo: 'src/ajax/registroPersonal.php?modulo_personal=obtenerCargo',
    obtenerDepartamento: 'src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento',
    obtenerEstados: 'src/ajax/registroPersonal.php?modulo_personal=obtenerEstados'
  };

  // Configuración de validaciones
  const validaciones = {
    nombres: [
      { selector: selectores.primerNombre, span: '.span_nombre' },
      { selector: selectores.segundoNombre, span: '.span_nombre2' },
      { selector: selectores.primerApellido, span: '.span_apellido' },
      { selector: selectores.segundoApellido, span: '.span_apellido2' }
    ],
    direccion: [
      { selector: selectores.calle, span: '.span_calle' },
      { selector: selectores.urbanizacion, span: '.span_urbanizacion' }
    ],
    selectores: [
      { selector: '#estatus', span: '.span_estatus' },
      { selector: '#cargo', span: '.span_cargo' },
      { selector: '#departamento', span: '.span_departamento' },
      { selector: '#dependencia', span: '.span_dependencia' }
    ]
  };

  // Configuración de Select2
  const select2Config = [
    'estatus', 'cargo', 'departamento', 'dependencia',
    'estado', 'municipio', 'parroquia', 'ano', 'meses',
    'dia', 'civil', 'sexo', 'vivienda', 'academico'
  ];

  /**
   * Inicializa los validadores del formulario
   */
  const inicializarValidadores = () => {
    // Validar nombres
    validaciones.nombres.forEach(({ selector, span }) =>
      validarNombre(selector, span));

    // Validar dirección
    validaciones.direccion.forEach(({ selector, span }) =>
      validarNombreConEspacios(selector, span));

    // Validar selectores
    validaciones.selectores.forEach(({ selector, span }) =>
      validarSelectoresSelec2(selector, span));

    // Otras validaciones específicas
    validarNumeros(selectores.cedula, '.span_cedula');
    validarNumeroNumber(selectores.edad, '.span_edad', 2);
    validarBusquedaCedula(selectores.cedula, ["#img-modals", "#img-contener"]);
    validarInputFecha(selectores.fechaIngreso, '.span_fechaing');
  };

  /**
   * Inicializa los componentes Select2
   */
  const inicializarSelect2 = () => {
    select2Config.forEach(selector => {
      incluirSelec2(`#${selector}`);
      validarSelectoresSelec2(`#${selector}`, `.span_${selector}`);
    });

    // Configuración inicial de fechas
    colocarYear(selectores.ano, "1900");
    colocarMeses(selectores.meses);
  };

  /**
   * Maneja el envío del formulario
   */
  const manejarEnvioFormulario = async (enviarFormulario) => {
    enviarFormulario.preventDefault();
    const formData = new FormData(enviarFormulario.target);
    const fechaIngreso = $(selectores.fechaIngreso).val().split("-").reverse().join("-");

    formData.append("fechaing", fechaIngreso);

    if ($("#btnEDInces").prop('checked')) {
      formData.append("FamiliarInces", "si");
    }

    $(selectores.btnAceptar).prop("disabled", true);

    try {
      const response = await enviarFormulario(
        endpoints.registrar,
        formData,
        async (parsedData) => {
          $(selectores.btnAceptar).prop("disabled", false);
          if (parsedData.exito) {
            await AlertDirection("success", parsedData.mensaje, "top", 7000);
          } else {
            await alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
          }
        },
        true
      );
    } catch (error) {
      console.error('Error en el envío:', error);
      $(selectores.btnAceptar).prop("disabled", false);
    }
  };

  /**
    * Maneja la visualización de los contenedores de discapacidad
    * @param {jQuery} $boton - Elemento botón que disparó el evento
  */
  const manejarDiscapacidad = (boton) => {
    const contenedor = $('#contentPartida');
    const tipoDiscapacidad = $('#contenTipoDiscapacidad');
    const tpDiscapacidad = $('#tpDiscapacidad');
    const archivoDis = $('#achivoDis');
    const duracionAnimacion = 500;

    const mostrarContenedores = () => {
      incluirSelec2('#tpDiscapacidad');
      tipoDiscapacidad.slideDown(duracionAnimacion);
      contenedor.slideDown(duracionAnimacion);

      boton
        .attr('id', 'cargaDiscaEliminar')
        .html('<i class="fa-solid fa-xmark me-2"></i> Eliminar Todo');
    };

    const ocultarContenedores = () => {
      tpDiscapacidad
        .addClass('ignore-validation')
        .select2('destroy')
        .val('');

      archivoDis
        .addClass('ignore-validation')
        .val('');

      tipoDiscapacidad.slideUp(duracionAnimacion);
      contenedor.slideUp(duracionAnimacion);

      boton
        .attr('id', 'asignarDisca')
        .html('<i class="fa-solid fa-plus me-2"></i> Asignar Discapacidad');
    };

    // Ejecutar acción según el ID del botón
    if (boton.attr('id') === 'asignarDisca') {
      mostrarContenedores();
    } else if (boton.attr('id') === 'cargaDiscaEliminar') {
      ocultarContenedores();
    }
  };

  /**
   * Configura los event listeners
   */
  const configurarEventListeners = () => {
    $(selectores.formulario).on('submit', manejarEnvioFormulario);
    // $(selectores.vivienda).on('change', manejarCambioVivienda);
    //$(selectores.civil).on('change', manejarCambioEstadoCivil);
    $(selectores.discapacidad).on('click', function () {
      manejarDiscapacidad($(this));
    });

    // calcular la edad por los días 
    // Evento para calcular edad con debounce
    const calcularEdadDebounced = manejarCalculoEdad;
    $(document).on('change', `${selectores.dia}, ${selectores.meses}, ${selectores.ano}`, calcularEdadDebounced);
  };

  /**
   * Carga los datos iniciales necesarios
   */
  const cargarDatosIniciales = async () => {
    try {
      const promesas = Object.values(endpoints).map(url =>
        fetch(url).then(res => res.json())
      );

      const resultados = await Promise.all(promesas);

      resultados.forEach((data, index) => {
        if (data.exito) {
          const selectores2 = ['dependencia', 'estatus', 'cargo', 'departamento', 'estado'];
          llenarSelect(data.data, selectores2[index], "Seleccione una opción");
        }
      });
    } catch (error) {
      console.error('Error al cargar datos iniciales:', error);
    }
  };

  /**
   * Inicializa el módulo
   */
  const inicializar = () => {
    // Ocultar elementos iniciales
    Object.values(selectores.contenedores).forEach(selector => $(selector).hide());

    inicializarValidadores();
    inicializarSelect2();
    configurarEventListeners();
    cargarDatosIniciales();

    // CARGAR VALIABLES DE HTML
    setCargarEstadoCivil("#civil"); // Carga los estados civiles
    setCargarSexo("#sexo"); // Carga los sexos
    setCargarNivelesAcademicos("#academico"); // Carga los niveles académicos
    setCargarTipoVivienda("#vivienda"); // Carga los tipos de vivienda
    setCargarDiscapacidad("#tpDiscapacidad")
    carculasDias("#meses", "#ano", "#dia", ".span_mes"); // funcion de calcular dias de los meses

    //cargar calendario 
    configurarFlatpickrSinFinesDeSemana("#fechaing3");


    // cargar el alert en el contenedor de la alerta del formulario multiple
    formulariomultiple('.f1 .btn-next', "#alert", contenidoAlerta);

    // Inicializar funcionalidades adicionales
    buscarMunicipioPorEstado('#estado', '#municipio');
    buscarParroquiaPorMunicipio('#municipio', '#parroquia');
    observarFormulario($(selectores.formulario)[0], $(selectores.btnAceptar));
  };

  // API pública
  return {
    inicializar
  };
})();

// Inicializar cuando el documento esté listo
$(function () {
  ModuloPersonal.inicializar();
});