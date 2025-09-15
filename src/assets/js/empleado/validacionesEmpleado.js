import {
  validarNombre,
  validarNombreConEspacios,
  validarSelectoresSelec2,
  incluirSelec2,
  file,
  validarTelefono,
  validarNumeros,
  validarNumeroNumber,
  validarInputFecha,
  colocarYear,
  colocarMeses
} from "../utils/inputs.js";
import { validarBusquedaCedula } from "../utils/funciones.js";
import { selectores } from "../utils/objetos.js";

/**
 * Inicializa los validadores del formulario
 */
export function inicializarValidadores() {
  [
    { selector: selectores.primerNombre, span: '.span_nombre' },
    { selector: selectores.segundoNombre, span: '.span_nombre2' },
    { selector: selectores.primerApellido, span: '.span_apellido' },
    { selector: selectores.segundoApellido, span: '.span_apellido2' },
  ].forEach(({ selector, span }) => validarNombre(selector, span));

  [
    { selector: selectores.calle, span: '.span_calle' },
    { selector: selectores.urbanizacion, span: '.span_urbanizacion' }
  ].forEach(({ selector, span }) => validarNombreConEspacios(selector, span));

  [
    { selector: selectores.estatus, span: '.span_estatus' },
    { selector: selectores.cargos, span: '.span_cargo' },
    { selector: selectores.departamentos, span: '.span_departamento' },
    { selector: selectores.dependencias, span: '.span_dependencia' },
    { selector: selectores.tipoDiscapacidad, span: '.span_tpDiscapacidad' }
  ].forEach(({ selector, span }) => validarSelectoresSelec2(selector, span));

  [
    { selector: selectores.partidaDiscapacidad, span: '.span_docArchivoDis' },
    { selector: selectores.contrato, span: '.span_contrato' },
    { selector: selectores.notificacion, span: '.span_notificacion' },
  ].forEach(({ selector, span }) => file(selector, span));

  validarTelefono('#telefono', '.span_telefono', '#linea');
  validarNumeros(selectores.cedula, '.span_cedula');
  validarNumeroNumber(selectores.edad, '.span_edad', 2);
  validarBusquedaCedula(selectores.cedula, ["#img-modals", "#img-contener"]);
  validarInputFecha(selectores.fechaIngreso, '.span_fechaing');
}

/**
 * Inicializa los componentes Select2
 */
export function inicializarSelect2() {
  [
    'estatus', 'cargo', 'departamento', 'dependencia',
    'estado', 'municipio', 'parroquia', 'ano', 'meses',
    'dia', 'civil', 'sexo', 'vivienda', 'academico'
  ].forEach(selector => {
    incluirSelec2(`#${selector}`);
    validarSelectoresSelec2(`#${selector}`, `.span_${selector}`);
  });

  colocarYear(selectores.ano, "1900");
  colocarMeses(selectores.meses);
}