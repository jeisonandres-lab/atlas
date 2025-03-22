// 1. Función para deshabilitar fines de semana
export function configurarFlatpickrSinFinesDeSemana(input) {
    return flatpickr(input, {
      disable: [
        function(date) {
          return date.getDay() === 0 || date.getDay() === 6;
        }
      ],
       locale: "es",
      maxDate: "today",
      dateFormat: "d-m-Y"
    });
  }
  
  // 2. Función para permitir todas las fechas (configuración por defecto)
  export function configurarFlatpickrConTodasLasFechas(input) {
    return flatpickr(input, {
       locale: "es",
      maxDate: "today",
      dateFormat: "d-m-Y"
    });
  }
  
  // 3. Función para deshabilitar un array de fechas específico
  export function configurarFlatpickrConFechasDeshabilitadas(input, fechasDeshabilitadas) {
    return flatpickr(input, {
      disable: fechasDeshabilitadas.map(fecha => new Date(fecha)),
       locale: "es",
      maxDate: "today",
      dateFormat: "d-m-Y"
    });
  }
  
  // 4. Función personalizada: deshabilitar fines de semana y un array de fechas
  export function configurarFlatpickrPersonalizado(input, fechasDeshabilitadas) {
    return flatpickr(input, {
      disable: [
        function(date) {
          return date.getDay() === 0 || date.getDay() === 6;
        },
        ...fechasDeshabilitadas.map(fecha => new Date(fecha))
      ],
       locale: "es",
      maxDate: "today",
      dateFormat: "d-m-Y"
    });
  }