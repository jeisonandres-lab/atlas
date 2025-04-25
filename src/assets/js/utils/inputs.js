import { formatState } from "./funciones.js";
import { meses, nivelAcamedico } from "./objetos.js";
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
    }
  });
}

//validar texto plano que cumpla con 8 caracteres
// Función para validar contraseñas con al menos 8 caracteres
export async function validarTexto(input, cumplidospan) {
  $(document).on("input", input, function () {
    const password = $(this).val();

    // Verificar si la contraseña tiene al menos 8 caracteres
    if (password.length >= 8) {
      $(this).removeClass("error_input").addClass("cumplido");
      $(cumplidospan).removeClass("error_span").addClass("cumplido_span");
    } else {
      $(this).removeClass("cumplido").addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span").addClass("error_span");
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
      $(cumplido_span2).addClass("cumplido");

    } else {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");


      $(cumplido_span2).removeClass("cumplido");
      $(cumplido_span2).removeClass("cumplido");
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
  });

  $(document).on("input", input, function () {
    let value = $(this).val();

    // Limitar la longitud del valor en el evento input
    if (value.length > limit) {
      $(this).val(value.slice(0, limit));
      value = $(this).val();
    }

    // Validar si el input está vacío
    if (value === "") {
      $(this).removeClass("cumplido").addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span").addClass("error_span");
      return;
    }

    // Verificar si el valor es un número válido
    const numericValue = parseInt(value);
    if (isNaN(numericValue) && value !== "0") {
      // No hacer nada si no es un número válido
      return;
    }

    // Validación de valor mínimo
    if (numericValue <= 0 && !ceros && value !== "0") {
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
    if (inputValue.length >= 5) {
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(cumplidospan).removeClass("error_span");
      $(cumplidospan).addClass("cumplido_span");
      $(this).val(inputValue.slice(0, 5));
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
  $(document).on("change", input, function () {
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

// tranformal el select a select2
export function incluirSelec2(selector, contexto, options = {}) {
  // 1. Inicialización inicial
  $(selector).each(function () {
    const select2Options = {
      dropdownParent: contexto,
      language: "es",
      theme: "bootstrap-5",
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
    };

    // Si se proporciona una URL en las opciones, configurar ajax
    if (options.url) {
      select2Options.ajax = {
        url: options.url,
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term,
            page: params.page
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;
          return {
            results: data.items,
            pagination: {
              more: (params.page * 30) < data.total_count
            }
          };
        },
        cache: true
      };
      select2Options.minimumInputLength = 1;
    }

    $(this).select2(select2Options);
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

// validar selectores de select2
export async function validarSelectoresSelec2(input, cumplidospan) {
  $(document).on('select2:select change', input, function (e) {
    const select2Container = $(this).next('.select2-container');
    const select2Rendered = select2Container.find('.select2-selection__rendered'); // Encuentra el elemento select2-selection__rendered
    const selectedValue = $(this).val();
    const select = $(input);
    const span = $(cumplidospan);

    if (select.val() === "") {
      select2Container.removeClass('cumplido');
      select2Container.addClass('error_input');
      select2Rendered.addClass('input_error'); // Agrega input_error al select2-selection__rendered
      select.removeClass('cumplido');
      $(span).removeClass('cumplido_span');
    } else {
      if (selectedValue && selectedValue !== "") {
        select2Container.addClass('cumplido');
        select.addClass('cumplido');
        span.addClass('cumplido_span');
        select2Container.removeClass('error_input');
        select2Rendered.removeClass('input_error'); // Elimina input_error al select2-selection__rendered
      } else {
        select.removeClass('cumplido');
        span.removeClass('cumplido_span');
        select2Container.removeClass('cumplido');
        select2Container.addClass('error_input');
        select2Rendered.addClass('input_error'); // Agrega input_error al select2-selection__rendered
      }
    }
  });
}

// buscar datos de empleados pro select 2
export function buscarDataEmpledoSelect2(input) {
  $(input).select2({
    dropdownParent: $("#estadoDerecho"),
    language: "es",
    theme: "bootstrap-5",
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: 'Coloque la cédula',
    ajax: {
      url: 'src/ajax/registroPersonal.php?modulo_personal=obtenerDataEmpleados',
      dataType: 'json',
      type: 'POST',
      delay: 250,
      data: function (params) {
        return {
          cedulaFamiliar: params.term
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        if (data && data.datos && Array.isArray(data.datos)) {
          const results = data.datos.map(item => {
            return {
              id: item.cedula,
              text: item.primerNombre + ' ' + item.primerApellido,
              img: item.cedula // Asegúrate de que este campo exista y sea el nombre del archivo de la imagen
            };
          });

          return {
            results: results,
            pagination: {
              more: (params.page * 30) < data.total_count
            }
          };
        } else {
          console.error("Error: 'data.datos' no es un array válido.", data);
          return {
            results: []
          };
        }
      },
      cache: true
    },
    minimumInputLength: 1,
    templateResult: formatState, // Usar formatState para mostrar las opciones
    templateSelection: formatState // Usar formatState para mostrar la selección
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

// Objeto para colocar los meses
export async function colocarMeses(input) {
  try {
    // Limpiar el select antes de agregar nuevas opciones
    $(input).empty();

    // $(input).append(`<option value="">Seleccione un mes</option>`);

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
    nivelAcamedico.forEach(nivel => {
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

// llenar datos mediante un select
export async function llenarSelect(data, selectId, placeholderText) {
  const select = document.getElementById(selectId);
  // Asegúrate de que el ID del select sea correcto
  if (!select) {
    console.error(`El elemento select con el ID "${selectId}" no se encontró en el DOM.`);
    return;
  }

  // Crear un fragmento de documento para minimizar las manipulaciones del DOM
  const fragment = document.createDocumentFragment();

  // Añadir la opción con valor vacío y el texto de placeholder
  const placeholderOption = document.createElement('option');
  placeholderOption.value = '';
  placeholderOption.text = placeholderText;
  fragment.appendChild(placeholderOption);

  data.forEach(item => {
    const option = document.createElement('option');
    option.value = item.id;
    option.text = item.value;
    fragment.appendChild(option);
  });

  // Vaciar el select y agregar las nuevas opciones
  select.innerHTML = '';
  select.appendChild(fragment);
}



