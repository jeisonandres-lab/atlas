import { manejarDiscapacidad, cargarVivienda } from "./inputsEmpleado.js";
import { manejarEnvioFormulario } from "./formularioEmpleado.js";
import { inicializarValidadores, inicializarSelect2 } from "./validacionesEmpleado.js";
import { selectores } from "../utils/objetos.js";
import { llenarSelect } from "../utils/inputs.js";

import {
  setCargarDiscapacidad,
  setCargarEstadoCivil,
  setCargarNivelesAcademicos,
  setCargarSexo,
  setCargarTipoVivienda
} from "../utils/manejadoresObjetos.js";

const registroEmpleado = (() => {

  const endpoints = {
    registrar: 'src/routers/registroPersonal.php?modulo_personal=registrar',
    obtenerDependencias: 'src/routers/RouterUnidadOrganizacional.php?modulo_datos=obtenerDependenciaGeneral',
    obtenerEstatus: 'src/routers/RouterUnidadOrganizacional.php?modulo_datos=obtenerEstatusGeneral',
    obtenerCargo: 'src/routers/RouterUnidadOrganizacional.php?modulo_datos=obtenerCargoGeneral',
    obtenerDepartamento: 'src/routers/RouterUnidadOrganizacional.php?modulo_datos=obtenerDepartamentoGeneral',
    obtenerEstados: 'src/routers/registroPersonal.php?modulo_personal=obtenerEstados',
  };

  const cargarDatosIniciales = async () => {
    try {
      console.log('Cargando datos iniciales...');
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
          console.table(data.data);
          llenarSelect(data.data, selectores2[index], "Seleccione una opción");
        }
      });
    } catch (error) {
      console.error('Error al cargar datos iniciales:', error);
    }
  };

  const configurarEventListeners = () => {
    $(selectores.formulario).on('submit', manejarEnvioFormulario);
    $(selectores.discapacidad).on('click', function () {
      manejarDiscapacidad($(this));
    });
  };

  const inicializar = () => {
    // Ocultar elementos iniciales
    Object.values(selectores.contenedores).forEach(selector => $(selector).hide());

    inicializarValidadores();
    inicializarSelect2();
    configurarEventListeners();
    cargarDatosIniciales();
    cargarVivienda();

    // CARGAR VALIABLES DE HTML
    setCargarEstadoCivil(selectores.civil); // Carga los estados civiles
    setCargarSexo(selectores.sexo); // Carga los sexos
    setCargarNivelesAcademicos(selectores.academico); // Carga los niveles académicos
    setCargarTipoVivienda(selectores.vivienda); // Carga los tipos de vivienda
    setCargarDiscapacidad(selectores.tipoDiscapacidad) // cargar las discapacidades
    carculasDias(selectores.meses, selectores.ano, selectores.dia, ".span_mes"); // funcion de calcular dias de los meses

  };

  return { inicializar };
})();

$(function () {
  registroEmpleado.inicializar();
});