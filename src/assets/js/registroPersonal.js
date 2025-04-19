// IMPORT DE VALIDACION DE INPUTS 
import { alertaBasica, alertaNormalmix } from "./utils/alerts.js";
import { enviarFormulario, observarFormulario } from "./utils/formularioAjax.js";
import { calcularEdad, carculasDias } from "./utils/funciones.js";
import { configurarFlatpickrSinFinesDeSemana } from "./utils/inputCalendar.js";
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
  buscarDataEmpledoSelect2,
} from "./utils/inputs.js";
import { formulariomultiple } from "./utils/multiForm.js";
import { buscarMunicipioPorEstado, buscarParroquiaPorMunicipio } from "./utils/peticiones.js";
import { setCargarDiscapacidad, setCargarEstadoCivil, setCargarNivelesAcademicos, setCargarSexo, setCargarTipoVivienda } from "./utils/variablesArray.js";

// Mantener otros imports...

/**
 * Módulo Personal: gestiona todas las funciones relacionadas con el registro de personal
 */
const ModuloPersonal = (() => {
  // Selectores del DOM
  const SELECTORES = {
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
  const MENSAJES = {
    FALTA_ANO: "Seleccione un año.",
    FALTA_MES: "Seleccione un mes.",
    FALTA_DIA: "Seleccione un día.",
    EDAD_ALTA: (edad) => `¡Wow! Tienes ${edad} años de edad, ¡felicitaciones! al empleado`,
    EDAD_BAJA: (edad) => `Lamentablemente, no podemos permitir el acceso a esta persona. La edad mínima requerida es de 18 años, y esta persona tiene ${edad} años`
  };

  /**
   * Maneja el cálculo de edad cuando cambian los campos de fecha
   */
  const manejarCalculoEdad = () => {
    const dia = $(SELECTORES.dia).val();
    const mes = $(SELECTORES.meses).val();
    const ano = $(SELECTORES.ano).val();
    const $edad = $(SELECTORES.edad);

    // Validar campos requeridos
    if (!ano) {
      alertaNormalmix(MENSAJES.FALTA_ANO, 2000, "warning", "top");
      return;
    }

    if (!mes) {
      alertaNormalmix(MENSAJES.FALTA_MES, 2000, "warning", "top");
      return;
    }

    if (!dia) {
      alertaNormalmix(MENSAJES.FALTA_DIA, 2000, "warning", "top");
      return;
    }

    // Calcular edad
    const fechaNacimiento = new Date(ano, mes - 1, dia);
    if (isNaN(fechaNacimiento.getTime())) return;

    const edadCalculada = calcularEdad(fechaNacimiento);

    // Actualizar campo de edad
    $edad.val(edadCalculada);
    clasesInputs(SELECTORES.edad, ".span_edad");

    // Validar edad
    if (edadCalculada >= 100) {
      alertaNormalmix(
        MENSAJES.EDAD_ALTA(edadCalculada),
        4000,
        "info",
        "top"
      );
    }

    if (edadCalculada < 18) {
      alertaBasica(
        MENSAJES.EDAD_BAJA(edadCalculada),
        7000,
        "info",
        "top-center",
        "Edad no requerida"
      );
      clasesInputsError(SELECTORES.edad, ".span_edad");
    }
  };


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

  // Endpoints de API
  const ENDPOINTS = {
    //registrar: 'src/ajax/registroPersonal.php?modulo_personal=registrar',
    obtenerDependencias: 'src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias',
    obtenerEstatus: 'src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus',
    obtenerCargo: 'src/ajax/registroPersonal.php?modulo_personal=obtenerCargo',
    obtenerDepartamento: 'src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento',
    obtenerEstados: 'src/ajax/registroPersonal.php?modulo_personal=obtenerEstados'
  };

  // Configuración de validaciones
  const VALIDACIONES = {
    nombres: [
      { selector: SELECTORES.primerNombre, span: '.span_nombre' },
      { selector: SELECTORES.segundoNombre, span: '.span_nombre2' },
      { selector: SELECTORES.primerApellido, span: '.span_apellido' },
      { selector: SELECTORES.segundoApellido, span: '.span_apellido2' }
    ],
    direccion: [
      { selector: SELECTORES.calle, span: '.span_calle' },
      { selector: SELECTORES.urbanizacion, span: '.span_urbanizacion' }
    ],
    selectores: [
      { selector: '#estatus', span: '.span_estatus' },
      { selector: '#cargo', span: '.span_cargo' },
      { selector: '#departamento', span: '.span_departamento' },
      { selector: '#dependencia', span: '.span_dependencia' }
    ]
  };

  // Configuración de Select2
  const SELECT2_CONFIG = [
    'estatus', 'cargo', 'departamento', 'dependencia',
    'estado', 'municipio', 'parroquia', 'ano', 'meses',
    'dia', 'civil', 'sexo', 'vivienda', 'academico'
  ];

  /**
   * Inicializa los validadores del formulario
   */
  const inicializarValidadores = () => {
    // Validar nombres
    VALIDACIONES.nombres.forEach(({ selector, span }) =>
      validarNombre(selector, span));

    // Validar dirección
    VALIDACIONES.direccion.forEach(({ selector, span }) =>
      validarNombreConEspacios(selector, span));

    // Validar selectores
    VALIDACIONES.selectores.forEach(({ selector, span }) =>
      validarSelectoresSelec2(selector, span));

    // Otras validaciones específicas
    validarNumeros(SELECTORES.cedula, '.span_cedula');
    validarNumeroNumber(SELECTORES.edad, '.span_edad', 2);
    validarBusquedaCedula(SELECTORES.cedula, ["#img-modals", "#img-contener"]);
    validarInputFecha(SELECTORES.fechaIngreso, '.span_fechaing');
  };

  /**
   * Inicializa los componentes Select2
   */
  const inicializarSelect2 = () => {
    SELECT2_CONFIG.forEach(selector => {
      incluirSelec2(`#${selector}`);
      validarSelectoresSelec2(`#${selector}`, `.span_${selector}`);
    });

    // Configuración inicial de fechas
    colocarYear(SELECTORES.ano, "1900");
    colocarMeses(SELECTORES.meses);
  };

  /**
   * Maneja el envío del formulario
   */
  const manejarEnvioFormulario = async (enviarFormulario) => {
    enviarFormulario.preventDefault();
    const formData = new FormData(enviarFormulario.target);
    const fechaIngreso = $(SELECTORES.fechaIngreso).val().split("-").reverse().join("-");

    formData.append("fechaing", fechaIngreso);

    if ($("#btnEDInces").prop('checked')) {
      formData.append("FamiliarInces", "si");
    }

    $(SELECTORES.btnAceptar).prop("disabled", true);

    try {
      const response = await enviarFormulario(
        ENDPOINTS.registrar,
        formData,
        async (parsedData) => {
          $(SELECTORES.btnAceptar).prop("disabled", false);
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
      $(SELECTORES.btnAceptar).prop("disabled", false);
    }
  };

  /**
     * Maneja la visualización de los contenedores de discapacidad
     * @param {jQuery} $boton - Elemento botón que disparó el evento
     */
  const manejarDiscapacidad = ($boton) => {
    const contenedor = $('#contentPartida');
    const tipoDiscapacidad = $('#contenTipoDiscapacidad');
    const tpDiscapacidad = $('#tpDiscapacidad');
    const archivoDis = $('#achivoDis');
    const DURACION_ANIMACION = 500;

    const mostrarContenedores = () => {
        incluirSelec2('#tpDiscapacidad');
        tipoDiscapacidad.slideDown(DURACION_ANIMACION);
        contenedor.slideDown(DURACION_ANIMACION);
        
        $boton
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

        tipoDiscapacidad.slideUp(DURACION_ANIMACION);
        contenedor.slideUp(DURACION_ANIMACION);
        
        $boton
            .attr('id', 'asignarDisca')
            .html('<i class="fa-solid fa-plus me-2"></i> Asignar Discapacidad');
    };

    // Ejecutar acción según el ID del botón
    if ($boton.attr('id') === 'asignarDisca') {
        mostrarContenedores();
    } else if ($boton.attr('id') === 'cargaDiscaEliminar') {
        ocultarContenedores();
    }
};
  /**
   * Configura los event listeners
   */
  const configurarEventListeners = () => {
    $(SELECTORES.formulario).on('submit', manejarEnvioFormulario);
    // $(SELECTORES.vivienda).on('change', manejarCambioVivienda);
    //$(SELECTORES.civil).on('change', manejarCambioEstadoCivil);
    $(SELECTORES.discapacidad).on('click', function() {
      manejarDiscapacidad($(this));
    }); 

    // calcular la edad por los días 
    // Evento para calcular edad con debounce
    const calcularEdadDebounced = manejarCalculoEdad;
    $(document).on('change', `${SELECTORES.dia}, ${SELECTORES.meses}, ${SELECTORES.ano}`, calcularEdadDebounced);
  };

  /**
   * Carga los datos iniciales necesarios
   */
  const cargarDatosIniciales = async () => {
    try {
      const promesas = Object.values(ENDPOINTS).map(url =>
        fetch(url).then(res => res.json())
      );

      const resultados = await Promise.all(promesas);

      resultados.forEach((data, index) => {
        if (data.exito) {
          const selectores = ['dependencia', 'estatus', 'cargo', 'departamento', 'estado'];
          llenarSelect(data.data, selectores[index], "Seleccione una opción");
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
    Object.values(SELECTORES.contenedores).forEach(selector => $(selector).hide());

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
    observarFormulario($(SELECTORES.formulario)[0], $(SELECTORES.btnAceptar));
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