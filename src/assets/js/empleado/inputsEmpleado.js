import { incluirSelec2 } from "../utils/inputs.js";
import { selectores } from "../utils/objetos.js";
import { 
  setContenedorNombreDepa, 
  setContenedorNumDepa, 
  setContenedorPiso, 
  setVariableNumVivienda 
} from "../utils/variablesContenido.js";

/**
 * Maneja la visualización de los contenedores de discapacidad
 */
export function manejarDiscapacidad(boton) {
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

  if (boton.attr('id') === 'asignarDisca') {
    mostrarContenedores();
  } else if (boton.attr('id') === 'cargaDiscaEliminar') {
    ocultarContenedores();
  }
}

/**
 * Configura el manejo de cambios en el tipo de vivienda y muestra/oculta los contenedores correspondientes
 */
export function cargarVivienda() {
  $(document).on("change", selectores.vivienda, function() {
    const tipoVivienda = $(this).val();
    $("#contenPiso, #contenNombreDepa, #contenNumDepa, #contenNVivienda").remove();

    if (tipoVivienda === 'Departamento') {
      const pisoContenedor = setContenedorPiso('piso', 'piso');
      const nombreDepaContenedor = setContenedorNombreDepa('urbanizacion', 'urbanizacion');
      const numDepaContenedor = setContenedorNumDepa('numeroDepa', 'numeroDepa');
      const nuevoHTML = `${pisoContenedor}${nombreDepaContenedor}${numDepaContenedor}`;
      $("#contenCalle").after(nuevoHTML);
    } else if (tipoVivienda === 'Casa') {
      const viviendaContenedor = setVariableNumVivienda('numeroVivienda', 'numeroVivienda');
      $("#contenCalle").after(viviendaContenedor);
    }
  });
}