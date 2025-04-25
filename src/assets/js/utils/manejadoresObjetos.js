import { discapacidades, estadoCivil, nivelAcamedico, parentesco, sexo, tipoVivienda } from "./objetos.js";


// exportar la funcion de parentesco 
export async function setCargarParentesco(input) {
    const Select = $(input);
    Select.empty();

    parentesco.forEach(parentesco => {
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

    discapacidades.forEach(discapacidad => {
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
  
    estadoCivil.forEach(estadoCivil => {
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

  tipoVivienda.forEach(vivienda => {
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
  
    nivelAcamedico.forEach(nivel => {
      Select.append($("<option>", {
        value: nivel.valor,
        text: nivel.nombre,
      }));
    });
}