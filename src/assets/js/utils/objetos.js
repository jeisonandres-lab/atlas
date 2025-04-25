
// objeto de niveles academicos 
export const nivelAcamedico = [
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
export const meses = [
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
export const parentesco = [
    { valor: '', nombre: "Seleccione un parentesco" },
    { valor: 'Hijo', nombre: "Hijo" },
    { valor: 'Hija', nombre: "Hija" },
    { valor: 'Padre', nombre: "Padre" },
    { valor: 'Madre', nombre: "Madre" },
    { valor: 'Hermano', nombre: "Hermano" },
    { valor: 'Estado De Derecho', nombre: "Estado De Derecho" }
];

// objeto de discapacidades
export const discapacidades = [
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
export const tipoVivienda = [
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
export const estadoCivil = [
    { valor: "", nombre: "Estado civil" },
    { valor: "Soltero", nombre: "Soltero" },
    { valor: "Casado", nombre: "Casado" },
    { valor: "Viudo", nombre: "Viudo" },
    { valor: "Divorciado", nombre: "Divorciado" },
    { valor: "EstadoDerecho", nombre: "Estado de derecho" },
];

// Objeto de selectores
// Selectores del DOM
export const selectores = {
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
    tipoDiscapacidad: '#tpDiscapacidad',

    partidaDiscapacidad: '#achivoDis',
    contrato: '#contrato',
    notificacion: '#notificacion',
    
    estatus: '#estatus',
    cargos: '#cargo',
    departamentos: '#departamento',
    dependencias: '#dependencia',
    estado: '#estado',
    municipio: '#municipio',
    parroquia: '#parroquia',
    contenedores: {
        formularioEmpleado: '.formulario_empleado',
        discapacidad: '#contenTipoDiscapacidad',
        partida: '#contentPartida',
        estadoDerecho: '#botonModalEstadoDerecho'
    }
};