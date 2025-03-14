import { meses, niveles } from "./variablesArray.js";
// Funcion para vlaidar campos tipo text que tambien coloquen la primera letra en mayuscula
export async function validarNombre(input, cumplidospan) {
  $(document).on("input", input, function () {
    // Convertir todo a minúsculas y capitalizar la primera letra
    this.value = this.value.toLowerCase().replace(/\b\w/g, (char) => char.toUpperCase());
    this.value = this.value.replace(/[^a-zA-Z]/g, "");
    if (this.value.length < 3) {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    } else if (this.value.length >= 4 || this.value.length <= 12) {
      this.value = this.value.slice(0, 12);
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
      console.log("Okay, el valor es válido.");
    }
  });
}

// Funcion para validar campos tipo text que coloquen la primera letra de cada palabra en mayuscula y permitan espacios
export async function validarNombreConEspacios(input, cumplidospan) {
  $(document).on("input", input, function () {
    // Convertir la primera letra de cada palabra a mayúscula y mantener el resto en su estado original
    this.value = this.value.replace(/\b\w/g, (char) => char.toUpperCase());

    // Permitir solo letras y espacios
    this.value = this.value.replace(/[^a-zA-Z\s]/g, "");

    if (this.value.length < 3) {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    } else if (this.value.length >= 4) {
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
      console.log("Okay, el valor es válido.");
    }
  });
}

// Funcion para validar que se ocloquen solo numeros mayor a 7 menor a 9 (Cédula)
export async function validarNumeros(input, cumplidospan) {
  $(input).on("input", function (evenet) {
    this.value = this.value.replace(/[^0-9]/g, "");
    if (this.value.length < 7) {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    } else if (this.value.length >= 7 || this.value.length <= 9) {
      this.value = this.value.slice(0, 9);
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
    }
  });
}

// Funcion para validar que se coloque un número mayor a 1
export async function validarNumerosMenores(input, cumplidospan) {
  $(input).on("input", function (evenet) {
    this.value = this.value.replace(/[^0-9]/g, "");
    if (this.value.length < 1 || this.value == 0) {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    } else if (this.value.length >= 1 || this.value.length <= 9) {
      this.value = this.value.slice(0, 9);
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
    }
  });
}

// Funcion para validar los numeros de telefonos 
export async function validarTelefono(input, cumplidospan, cumplido_span2) {
  $(input).on("input", function () {
    // Eliminar cualquier cosa que no sea un número
    this.value = this.value.replace(/[^0-9]/g, "");
    console.log(this.value)
    // Limitar a 12 dígitos
    if (this.value.length > 7) {
      this.value = this.value.slice(0, 7);
    }
    // Aplicar clases según la longitud
    if (this.value.length == 7) {
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
      

      $(cumplido_span2).removeClass("error_span");
      $(cumplido_span2).addClass("cumplido_segundario");

    } else {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
      
      
      $(cumplido_span2).removeClass("cumplido");
      $(cumplido_span2).removeClass("cumplido_segundario");
      $(cumplido_span2).addClass("error_span");
    }
  });

}

// Funcion para validar los inputs de tipo number
export async function validarNumeroNumber(input, cumplidospan, limit, ceros) {
  $(document).on("keydown", input, function (event) {
      const key = event.key;
      const currentValue = $(this).val();

      // Permitir teclas de control
      if (event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 46) {
          return;
      }

      // Permitir solo números
      if (isNaN(parseInt(key))) {
          event.preventDefault();
          return;
      }

      // Limitar la longitud del valor
      if (currentValue.length >= limit) {
          event.preventDefault();
          return;
      }

      // Validación de ceros consecutivos
      if (!ceros && currentValue.endsWith("0") && key === "0") {
          event.preventDefault();
          return;
      }
  });

  $(document).on("input", input, function () {
      let value = $(this).val();

      // Limitar la longitud del valor en el evento input
      if (value.length > limit) {
          $(this).val(value.slice(0, limit));
          value = $(this).val();
      }

      // Validación de ceros consecutivos
      if (!ceros) {
          while (value.includes("00")) {
              value = value.replace("00", "0");
          }
          $(this).val(value);
      }

      // Validar si el input está vacío
      if (value === "") {
          $(this).removeClass("cumplido").addClass("error_input");
          $(cumplidospan).removeClass("cumplido_span").addClass("error_span");
          return;
      }

      // Verificar si el valor es un número válido
      const numericValue = parseInt(value);
      if (isNaN(numericValue)) {
          // No hacer nada si no es un número válido
          return;
      }

      // Validación de valor mínimo
      if (numericValue <= 0 && !ceros) {
          $(this).removeClass("cumplido").addClass("error_input");
          $(cumplidospan).removeClass("cumplido_span").addClass("error_span");
      } else {
          $(this).removeClass("error_input").addClass("cumplido");
          $(cumplidospan).removeClass("error_span").addClass("cumplido_span");
      }
  });
}
//SOLO NUMEROS 
export async function soloNumeros(input, cumplidospan) {
  $(input).on("input", function () {
    // Reemplazar cualquier carácter que no sea un número
    this.value = this.value.replace(/[^0-9]/g, "");

    // Verificar si el valor es válido
    if (this.value.length > 0) {
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
    } else {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    }
  });
}

//validar numero de departamento con solo 2 datos´
export async function validarDosDatos(input, cumplidospan) {
  $(document).on('input', input, function () {
    let inputValue = $(this).val();

    // Limita la longitud a 2 caracteres
    if (inputValue.length >= 2) {
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
      $(this).val(inputValue.slice(0, 2));
      inputValue = $(this).val();
    } else {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    }

    // Convierte letras a mayúsculas
    $(this).val(inputValue.toUpperCase());
  });
}

// Funcion para validar los selectores de tipo select 
export async function validarSelectores(input, cumplidospan, tigger) {
  $(input).on("input", function () {
    // console.log("hola");
    const opcionSeleccionada = $(this).val();
    if (opcionSeleccionada === "") {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    } else {
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
    }
  });
  if (tigger == "1") {
    $(input).trigger("change");
  } else { }
}

// VALIDAR INPUTS TYPE FECHA
// Función para validar un input de tipo date
export async function validarInputFecha(input, cumplidospan) {
  $(document).on("change", input, function() {
    const fechaSeleccionada = $(this).val();
    if (fechaSeleccionada === "") {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    } else {
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
    }
  });
}

export function incluirSelec2(selector) {
  // 1. Inicialización inicial
  $(selector).each(function() {
    $(this).select2({
      theme: "bootstrap-5",
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
    });
  });

  // 2. MutationObserver para cambios dinámicos
  const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
      mutation.addedNodes.forEach(node => {
        if (node.matches && node.matches(selector)) {
          $(node).select2({
            theme: "bootstrap-5",
            width: $(node).data('width') ? $(node).data('width') : $(node).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(node).data('placeholder'),
          });
        }
      });
    });
  });

  observer.observe(document.body, { childList: true, subtree: true });
}

export async function validarSelectoresSelec2(input, cumplidospan) {
  // Maneja el evento select2:select y change
  $(document).on('select2:select change', input, function (e) {
    const select2Container = $(this).next('.select2-container');
    const selectedValue = $(this).val();
    const select = $(input);
    const span = $(cumplidospan);
    if (select.val() == "") {
      select2Container.removeClass('cumplido');
      select2Container.addClass('error_input');
      select.removeClass('cumplido');
      $(span).removeClass('cumplido_span');
    } else {
      if (selectedValue && selectedValue !== "") {
        select2Container.addClass('cumplido');
        select.addClass('cumplido');
        span.addClass('cumplido_span');
        select2Container.removeClass('error_input');
      } else {
        select.removeClass('cumplido');
        span.removeClass('cumplido_span');

        select2Container.removeClass('cumplido');
        select2Container.addClass('error_input');
      }
    }

  });
}

// Funcion para validar los inputs de tipo correo
export async function valdiarCorreos(input, cumplidospan) {
  $(input).on("input", function (evenet) {
    var correo = this.value;
    var regexHotmail = /@hotmail\.com$/i;
    var regexGmail = /@gmail\.com$/i;
    if (regexHotmail.test(correo) || regexGmail.test(correo)) {
      $(this).addClass("cumplido");
      $(this).removeClass("error_span");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
    } else {
      $(this).removeClass("cumplido");
      $(this).addClass("error_span");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    }
  });
}

// Funcion para buscar las fotos de los empleados mediante la cédula de identidad
export async function validarBusquedaCedula(input, divContens) {
  $(input).on("input", function () {
    const cedula = $(this).val();
    const imageUrl = `./src/global/archives/photos/${cedula}.png`;

    // Creamos una nueva imagen y la agregamos a cada div
    const img = new Image();
    img.src = imageUrl;
    img.classList.add("img-fluid", "imgFoto", "w-100", "h-100");

    img.onload = () => {
      divContens.forEach(div => {
        $(div).html(img.cloneNode(true));
      });
    };

    img.onerror = function () {
      divContens.forEach(div => {
        $(div).html("Imagen no encontrada");
      });
    };
  });
}

// Objeto para colocar los meses
export async function colocarMeses(input) {
  try {
    // Limpiar el select antes de agregar nuevas opciones
    $(input).empty();

    $(input).append(`<option value="">Seleccione un mes</option>`);
  
    meses.forEach(mes => {
      $(input).append(`<option value="${mes.valor}">${mes.nombre}</option>`);
    });
  } catch (error) {
    console.error("Error al cargar niveles educativos:", error);
  }
  // Crear las opciones del select
  
}

// Objeto para colocar los años
export async function colocarYear(input, desde) {
  // Crear un array de objetos para representar los años
  const años = [];
  // Agregar la opción "Selecciona un año" al inicio
  años.push({ valor: "", nombre: "Selecciona un año" });
  for (let año = new Date().getFullYear(); año >= desde; año--) {
    años.push({ valor: año, nombre: año });
  }

  // Crear las opciones del select
  años.forEach(año => {
    $(input).append(`<option value="${año.valor}">${año.nombre}</option>`);
  });
}

// Objeto para colocar niveles de estudio de los empleados
export async function colocarNivelesEducativos(input) {
  // Simplemente usa la variable importada 'niveles'
  try {
    // Limpiar el select antes de agregar nuevas opciones
    $(input).empty();

    
    $(input).append(`<option value="">Seleccione un nivel academico</option>`);
    
    niveles.forEach(nivel => {
      $(input).append(`<option value="${nivel.valor}">${nivel.nombre}</option>`);
    });
  } catch (error) {
    console.error("Error al cargar niveles educativos:", error);
  }
}

// Validar documentos subidos
export async function file(input, cumplidospan) {
  $(input).on("change", function () {
    if (this.files && this.files[0]) {
      // Se ha seleccionado un archivo
      $(this).addClass('cumplido');
      $(this).removeClass('error_input');

      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
    } else {
      // No se ha seleccionado ningún archivo
      $(this).removeClass('cumplido');
      $(this).addClass('error_input');

      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    }
  })
}

export async function liberarInputs(input, cumplidospan, valor) {
  // inputs
  if (valor == 1) {
    $(input).addClass("cumplido");
    $(input).removeClass("error_input");
    // spans
    $(cumplidospan).addClass("cumplido_span");
    $(cumplidospan).removeClass("error_span");
  } else {
    $(input).val("");
    $(input).removeClass("cumplido");
    $(input).addClass("error_input");
    // spans
    $(cumplidospan).removeClass("cumplido_span");
    $(cumplidospan).addClass("error_span");
  }
}

export async function limpiarFormulario(idinput, span) {
  if ($(idinput).attr('type') === 'checkbox') {
    return;
  }

  $(idinput).val("");
  $(idinput).removeClass("cumplido");
  $(idinput).addClass("error_input");

  if (span) {
    $(span).removeClass("cumplido_span");
    $(span).addClass("error_span");
  }
}

export async function limpiarInput(idinput, span, ifselect2, ifselect, ifinput, ifnumber) {
  if ($(idinput).attr('type') === 'checkbox') {
    return;
  }

  if(ifinput){
    $(idinput).val("");
    $(idinput).removeClass('cumplido');
    $(span).removeClass("cumplido_span");
  }


  if (ifselect2) {
    const select2Container = $(idinput).next('.select2-container');
    select2Container.removeClass('cumplido');
    $(span).removeClass('cumplido_span');
    $(idinput).find('option').not(':first').remove();
    $(idinput).val("");
  }

  if(ifselect){
    let select2Container = $(idinput).next('.select2-container');
    select2Container.removeClass('cumplido');
    $(idinput).val('').trigger('change');
    $(span).removeClass("error_span");
    $(span).removeClass("cumplido_span");
  }

  if(ifnumber){
    $(idinput).val('0');
  }
}

// Funcion para colocar las clases cumplido en los input y span 
export async function clasesInputs(input, span) {
  $(input).addClass("cumplido");
  $(input).removeClass("error_input");
  $(span).addClass("cumplido_span");
  $(span).removeClass("error_span");
}

// Funcion para colocar las clases error en los input y span
export async function clasesInputsError(input, span) {
  $(input).removeClass("cumplido");
  $(input).addClass("error_input");
  $(span).removeClass("cumplido_span");
  $(span).addClass("error_span");
}

//FUNCION PARA CARGAR LOS MESES POR CADA DIA QUE LE PERTENEZCA
export async function mesesDias(input, span_mes, inputdia, span_dia) {
  $(document).on("change", input, function () {
    const year = 2024; // Cambia el año si lo deseas
    const month = $(input).val();
    if (month == "") {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(span_mes).removeClass("cumplido_span");
      $(span_mes).addClass("error_span");
  
      $(inputdia).removeClass("cumplido");
      $(inputdia).addClass("error_input");
      $(span_dia).removeClass("cumplido_span");
      $(span_dia).addClass("error_span");
      $(inputdia).empty();
    } else {
      // Verificar si month no es null o undefined
      if (month) {
        // Eliminar el cero inicial si existe
        const monthWithoutLeadingZero = month.replace(/^0+/, "");
        // Obtener el número de días en el mes seleccionado
        const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate(); // Restamos 1 al mes porque JavaScript cuenta los meses desde 0
        // Generar las opciones de los días
        $(inputdia).empty(); // Limpiar las opciones anterior
        $(inputdia).removeClass("error_input");
        $(inputdia).addClass("cumplido");
        $(span_dia).removeClass("error_span");
        $(span_dia).addClass("cumplido_span");
        for (let i = 1; i <= daysInMonth; i++) {
          const diaFormateado = i.toString().padStart(2, "0");
          $(inputdia).append(
            '<option value="' + diaFormateado + '">' + diaFormateado + "</option>"
          );
        }
        $(this).removeClass("error_input");
        $(this).addClass("cumplido");
        $(span_mes).removeClass("error_span");
        $(span_mes).addClass("cumplido_span");
      } else {
        console.error("El valor de month es null o undefined");
      }
    }
  });
}

// export async function mesesDias(input, span_mes, inputdia, span_dia, ano) {
//   $(document).on("change", input, function () {
//     const year = $(ano).val();
//     const month = $(input).val();
//     if (month == "") {
//       $(input).removeClass("cumplido");
//       $(input).addClass("error_input");
//       $(span_mes).removeClass("cumplido_span");
//       $(span_mes).addClass("error_span");
//     } else {
//       // Eliminar el cero inicial si existe
//       const monthWithoutLeadingZero = month.replace(/^0+/, "");
//       // Obtener el número de días en el mes seleccionado
//       const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate(); // Restamos 1 al mes porque JavaScript cuenta los meses desde 0
//       // Generar las opciones de los días
//       $(inputdia).empty(); // Limpiar las opciones anteriores
//       $(inputdia).append(
//         '<option value="">Seleccione un día</option>'
//       );

//       $(span_dia).removeClass("cumplido_span");
//       $("#contentDia .select2").removeClass("cumplido");
//       for (let i = 1; i <= daysInMonth; i++) {
//         const diaFormateado = i.toString().padStart(2, "0");
//         $(inputdia).append(
//           '<option value="' + diaFormateado + '">' + diaFormateado + "</option>"
//         );
//       }
//       $(input).removeClass("error_input");
//       $(input).addClass("cumplido");
//       $(span_mes).removeClass("error_span");
//       $(span_mes).addClass("cumplido_span");
//     }
//   });
// }

export async function configurarInactividad(selector, tiempoInactividad) {
  let timeoutId;
  const elemento = $(selector);

  function iniciarTemporizador() {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(function () {
          elemento.hide();
      }, tiempoInactividad);
  }

  elemento.on("mousemove keydown click", function () {
      iniciarTemporizador();
      if (elemento.is(":hidden")) {
          elemento.show();
      }
  });

  // Inicializar el temporizador al cargar la página
  iniciarTemporizador();
}