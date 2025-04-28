// IMPORT DE VALIDACION DE INPUTS 
import {
  alertaNormalmix
} from "./utils/alerts.js";

import {
  enviarFormulario,
  observarFormulario
} from "./utils/formularioAjax.js";

import {
  carculasDias,
  crearManejadorEdad,
  validarBusquedaCedula
} from "./utils/funciones.js";

import {
  configurarFlatpickrSinFinesDeSemana
} from "./utils/inputCalendar.js";

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
  file,
  validarTelefono,
} from "./utils/inputs.js";

import {
  formulariomultiple
} from "./utils/multiForm.js";

import {
  buscarMunicipioPorEstado,
  buscarParroquiaPorMunicipio
} from "./utils/peticiones.js";

import {
  setCargarDiscapacidad,
  setCargarEstadoCivil,
  setCargarNivelesAcademicos,
  setCargarSexo,
  setCargarTipoVivienda
} from "./utils/manejadoresObjetos.js";

import { endpoints } from "./utils/endpoints.js";

import { selectores } from "./utils/objetos.js";

import { setContenedorNombreDepa, setContenedorNumDepa, setContenedorPiso, setVariableNumVivienda } from "./utils/variablesContenido.js"
/**
 * Módulo Personal: gestiona todas las funciones relacionadas con el registro de personal
 */
const ModuloPersonal = (() => {


  const endpoints = {
    registrar: 'src/ajax/registroPersonal.php?modulo_personal=registrar',
    obtenerDependencias: 'src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias',
    obtenerEstatus: 'src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus',
    obtenerCargo: 'src/ajax/registroPersonal.php?modulo_personal=obtenerCargo',
    obtenerDepartamento: 'src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento',
    obtenerEstados: 'src/ajax/registroPersonal.php?modulo_personal=obtenerEstados',
  };

  // Constantes para mensajes y configuración
  const mensajes = {};

  // Configuración para el cálculo de edad
  const configEdad = {
    selectores
  };

  // Crear el manejador de edad
  /**
   * @param {object} $configEdad - input donde se coloca la edad
   */
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

  // Configuración de validaciones
  const validaciones = {
    nombres: [
      { selector: selectores.primerNombre, span: '.span_nombre' },
      { selector: selectores.segundoNombre, span: '.span_nombre2' },
      { selector: selectores.primerApellido, span: '.span_apellido' },
      { selector: selectores.segundoApellido, span: '.span_apellido2' },
    ],
    direccion: [
      { selector: selectores.calle, span: '.span_calle' },
      { selector: selectores.urbanizacion, span: '.span_urbanizacion' }
    ],
    selectores: [
      { selector: selectores.estatus, span: '.span_estatus' },
      { selector: selectores.cargos, span: '.span_cargo' },
      { selector: selectores.departamentos, span: '.span_departamento' },
      { selector: selectores.dependencias, span: '.span_dependencia' },
      { selector: selectores.tipoDiscapacidad, span: '.span_tpDiscapacidad' }
    ],
    archivos: [
      { selector: selectores.partidaDiscapacidad, span: '.span_docArchivoDis' },
      { selector: selectores.contrato, span: '.span_contrato' },
      { selector: selectores.notificacion, span: '.span_notificacion' },
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

    validaciones.archivos.forEach(({ selector, span }) =>
      file(selector, span));

    // Otras validaciones específicas
    validarTelefono('#telefono', '.span_telefono', '#linea')
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
  const manejarEnvioFormulario = async (evento) => {
    evento.preventDefault(); // Detener el comportamiento predeterminado del formulario
    const formData = new FormData(evento.target); // Obtener los datos del formulario
    const fechaIngreso = $(selectores.fechaIngreso).val().split("-").reverse().join("-");

    formData.append("fechaing", fechaIngreso);

    if ($("#btnEDInces").prop('checked')) {
      formData.append("FamiliarInces", "si");
    }

    $(selectores.btnAceptar).prop("disabled", true);

    try {
      // Asegúrate de que `enviarFormulario` sea una función válida importada o definida
      const response = await enviarFormulario(endpoints.registrar, formData,);

      $(selectores.btnAceptar).prop("disabled", false);
      if (data.exito) {
        await AlertDirection("success", data.mensaje, "top", 7000);
      } else {
        await alertaNormalmix(data.mensaje, 4000, "error", "top-end");
      }

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
    const duracionAnimacion = 500;

    const mostrarContenedores = () => {
      incluirSelec2(selectores.tipoDiscapacidad);
      tipoDiscapacidad.slideDown(duracionAnimacion);
      contenedor.slideDown(duracionAnimacion);

      boton
        .attr('id', 'cargaDiscaEliminar')
        .html('<i class="fa-solid fa-xmark me-2"></i> Eliminar Todo');
    };

    const ocultarContenedores = () => {
      selectores.tipoDiscapacidad
        .addClass('ignore-validation')
        .select2('destroy')
        .val('');

      selectores.partidaDiscapacidad
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
   * Configura el manejo de cambios en el tipo de vivienda y muestra/oculta los contenedores correspondientes
   * según el tipo seleccionado (Departamento o Casa)
   */
  const cargarVivienda = () => {
    // Configurar el evento para detectar cambios en el selector de vivienda
    $(document).on("change", selectores.vivienda, function() {
      const tipoVivienda = $(this).val();
      
      // Eliminar contenedores existentes para evitar duplicados
      $("#contenPiso, #contenNombreDepa, #contenNumDepa, #contenNVivienda").remove();
      
      if (tipoVivienda === 'Departamento') {
        // Crear contenedores para departamento
        const pisoContenedor = setContenedorPiso('piso', 'piso');
        const nombreDepaContenedor = setContenedorNombreDepa('urbanizacion', 'urbanizacion');
        const numDepaContenedor = setContenedorNumDepa('numeroDepa', 'numeroDepa');
        
        // Usar template literals para una concatenación más eficiente
        const nuevoHTML = `${pisoContenedor}${nombreDepaContenedor}${numDepaContenedor}`;
        
        // Insertar los contenedores después del elemento con ID "contenCalle"
        $("#contenCalle").after(nuevoHTML);
      } else if (tipoVivienda === 'Casa') {
        // Crear contenedor para número de vivienda
        const viviendaContenedor = setVariableNumVivienda('numeroVivienda', 'numeroVivienda');
        
        // Insertar el contenedor después del elemento con ID "contenCalle"
        $("#contenCalle").after(viviendaContenedor);
      }
    });
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
      // Filtrar los endpoints excluyendo 'registros'
      const endpointsFiltrados = Object.values(endpoints).filter(url => !url.includes('registrar'));

      // Realizar las solicitudes a los endpoints filtrados
      const resultados = await Promise.all(
        endpointsFiltrados.map(url => fetch(url).then(res => res.json()))
      );

      // Procesar los resultados
      const selectores2 = ['dependencia', 'estatus', 'cargo', 'departamento', 'estado'];
      resultados.forEach((data, index) => {
        if (data.exito) {
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

    inicializarValidadores(); // Inicializar validadores
    inicializarSelect2(); // Inicializar Select2
    configurarEventListeners(); // Configurar event listeners
    cargarDatosIniciales(); // Cargar datos iniciales
    cargarVivienda(); // Inicializar manejador de vivienda

    // CARGAR VALIABLES DE HTML
    setCargarEstadoCivil(selectores.civil); // Carga los estados civiles
    setCargarSexo(selectores.sexo); // Carga los sexos
    setCargarNivelesAcademicos(selectores.academico); // Carga los niveles académicos
    setCargarTipoVivienda(selectores.vivienda); // Carga los tipos de vivienda
    setCargarDiscapacidad(selectores.tipoDiscapacidad) // cargar las discapacidades
    carculasDias(selectores.meses, selectores.ano, selectores.dia, ".span_mes"); // funcion de calcular dias de los meses

    //cargar calendario 
    configurarFlatpickrSinFinesDeSemana("#fechaing3");


    // cargar el alert en el contenedor de la alerta del formulario multiple
    formulariomultiple('.f1 .btn-next', "#alert", contenidoAlerta);

    // Inicializar funcionalidades adicionales
    buscarMunicipioPorEstado(selectores.estado, selectores.municipio);
    buscarParroquiaPorMunicipio(selectores.municipio, selectores.parroquia);
    observarFormulario($(selectores.formulario)[0], $(selectores.btnAceptar));
  };

  // retornar datos
  return {
    inicializar
  };
})();

// Inicializar cuando el documento esté listo
$(function () {
  ModuloPersonal.inicializar();
});