// objeto de niveles academicos 
export const niveles = [
    { valor: 'Bachiller', nombre: "Bachiller" },
    { valor: 'Tecnico', nombre: "Técnico" },
    { valor: 'Tecnologo', nombre: "Tecnólogo" },
    { valor: 'Pregrado', nombre: "Pregrado" },
    { valor: 'Ingeniero', nombre: "Ingeniero" },
    { valor: 'Especialista', nombre: "Especialista" },
    { valor: 'Maestria', nombre: "Maestría" },
    { valor: 'Doctorado', nombre: "Doctorado" },
];

// objeto de niveles academicos 
export const VARIABLE_NIVEL_ACADEMICO = [
    { valor: 'Bachiller', nombre: "Bachiller" },
    { valor: 'Tecnico', nombre: "Técnico" },
    { valor: 'Tecnologo', nombre: "Tecnólogo" },
    { valor: 'Pregrado', nombre: "Pregrado" },
    { valor: 'Ingeniero', nombre: "Ingeniero" },
    { valor: 'Especialista', nombre: "Especialista" },
    { valor: 'Maestria', nombre: "Maestría" },
    { valor: 'Doctorado', nombre: "Doctorado" },
];

// objeto de meses
export const ARRAYMESES = [
    { valor: '', nombre: "Meses" },
    { valor: '01', nombre: "Enero" },
    { valor: '02', nombre: "Febrero" },
    { valor: '03', nombre: "Marzo" },
    { valor: '04', nombre: "Abril" },
    { valor: '05', nombre: "Mayo" },
    { valor: '06', nombre: "Junio" },
    { valor: '07', nombre: "Julio" },
    { valor: '08', nombre: "Agosto" },
    { valor: '09', nombre: "Septiembre" },
    { valor: '10', nombre: "Octubre" },
    { valor: '11', nombre: "Noviembre" },
    { valor: '12', nombre: "Diciembre" },
];

// objeto de parentesco
export const ARRAYPARENTESCO = [
    { valor: '', nombre: "Seleccione un parentesco" },
    { valor: 'Hijo', nombre: "Hijo" },
    { valor: 'Hija', nombre: "Hija" },
    { valor: 'Padre', nombre: "Padre" },
    { valor: 'Madre', nombre: "Madre" },
    { valor: 'Hermano', nombre: "Hermano" },
    { valor: 'Estado De Derecho', nombre: "Estado De Derecho" }
];

// objeto de discapacidades
export const DISCAPACIDADES = [
    { valor: '', nombre: "Seleccione una discapacidad" },
    { valor: 'Visual', nombre: "Discapacidad visual" },
    { valor: 'Auditiva', nombre: "Discapacidad auditiva" },
    { valor: 'Motriz', nombre: "Discapacidad motriz" },
    { valor: 'Intelectual', nombre: "Discapacidad intelectual" },
    { valor: 'Psicosocial', nombre: "Discapacidad psicosocial" },
    { valor: 'Visceral', nombre: "Discapacidad visceral" },
    { valor: 'Multiples', nombre: "Discapacidades múltiples" },
    { valor: 'Otra', nombre: "Otra discapacidad" }
];

// objeto de tipo de vivienda
const TIPO_VIVIENDA = [
    { valor: "", nombre: "Seleccione una vivienda" },
    { valor: "Casa", nombre: "Casa" },
    { valor: "Departamento", nombre: "Departamento" },
];

// objeto de sexo
export const sexo = [
    { valor: '', nombre: "Seleccione sexo" },
    { valor: 'Masculino', nombre: "Masculino" },
    { valor: 'Femenino', nombre: "Femenino" }
];

// objeto de estado civil
const ESTADO_CIVIL = [
    { valor: "", nombre: "Estado civil" },
    { valor: "Soltero", nombre: "Soltero" },
    { valor: "Casado", nombre: "Casado" },
    { valor: "Viudo", nombre: "Viudo" },
    { valor: "Divorciado", nombre: "Divorciado" },
    { valor: "EstadoDerecho", nombre: "Estado de derecho" },
];

// exportar la funcion de parentesco 
export async function setCargarParentesco(input) {
    const Select = $(input);
    Select.empty();

    ARRAYPARENTESCO.forEach(parentesco => {
        Select.append($("<option>", {
            value: parentesco.valor,
            text: parentesco.nombre
        }));
    });
}

// exportar la funcion de discapacidad
export function setCargarDiscapacidad(selectId) {
    const select = $(selectId);
    select.empty();

    DISCAPACIDADES.forEach(discapacidad => {
        select.append($("<option>", {
            value: discapacidad.valor,
            text: discapacidad.nombre
        }));
    });
}

// exportar la funcion de sexo
export async function setCargarSexo(selectId) {
    const select = $(selectId);
    select.empty();

    sexo.forEach(sexo => {
        select.append($("<option>", {
            value: sexo.valor,
            text: sexo.nombre
        }));
    });
}

// exportar la funcion de estado civil
export async function setCargarEstadoCivil(input) {
    const Select = $(input);
    Select.empty();
  
    ESTADO_CIVIL.forEach(estadoCivil => {
      Select.append($("<option>", {
        value: estadoCivil.valor,
        text: estadoCivil.nombre,
      }));
    });
}

// exportar la funcion de tipo de vivienda
export async function setCargarTipoVivienda(input) {
  const Select = $(input);
  Select.empty();

  TIPO_VIVIENDA.forEach(vivienda => {
    Select.append($("<option>", {
      value: vivienda.valor,
      text: vivienda.nombre,
    }));
  });
}

// exportar la funcion de niveles academicos
export async function setCargarNivelesAcademicos(input) {
    const Select = $(input);
    Select.empty();
  
    VARIABLE_NIVEL_ACADEMICO.forEach(nivel => {
      Select.append($("<option>", {
        value: nivel.valor,
        text: nivel.nombre,
      }));
    });
  }