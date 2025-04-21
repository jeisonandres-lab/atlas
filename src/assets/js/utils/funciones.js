import { alertaBasica, alertaNormalmix } from "./alerts.js";
import { enviarFormulario } from "./formularioAjax.js";
import { clasesInputs, clasesInputsError } from "./inputs.js";

//funcion para calcular la edad por medio del año 
/**
 * @param {string} fechaNacimiento - selectore de fecha que debe regresar en ingles 
 */
export function calcularEdad(fechaNacimiento) {
  const hoy = new Date();
  let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
  const mes = hoy.getMonth() - fechaNacimiento.getMonth();
  if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
    edad--;
  }
  return edad;
}

// validar inactividad de los pagina
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

/**
 * Calcula y actualiza los días disponibles en un select basado en el mes y año seleccionados
 * @param {string} meses - Selector del elemento select de meses
 * @param {string} ano - Selector del elemento select de año
 * @param {string} dia - Selector del elemento select de días a actualizar
 * @param {string} cumplidospanMeses - Selector del span de validación para meses
 */
export async function carculasDias(meses, ano, dia, cumplidospanMeses) {
  // Obtener referencias a los elementos jQuery una sola vez
  const mesesElement = $(meses);
  const anoElement = $(ano);
  const diaElement = $(dia);
  const cumplidoSpanMeses = $(cumplidospanMeses);

  // Agregar el evento change al selector de meses
  $(document).on("change", meses, function () {
    // Obtener los valores actuales
    const year = anoElement.val();
    const month = mesesElement.val();

    // Validar si el mes está seleccionado
    if (month === "") {
      // Marcar como error si no hay mes seleccionado
      mesesElement.addClass("error_input");
      cumplidoSpanMeses.addClass("error_span");
      mesesElement.removeClass("cumplido");
      cumplidoSpanMeses.removeClass("cumplido_span");
      return; // Salir de la función si no hay mes seleccionado
    }

    // Calcular los días en el mes seleccionado
    const daysInMonth = new Date(year, month, 0).getDate();

    // Limpiar y preparar el select de días
    diaElement.empty().append('<option value="">Seleccione un día</option>');

    // Generar las opciones para cada día del mes usando un bucle for (el más rápido)
    for (let i = 1; i <= daysInMonth; i++) {
      // Formatear el día con dos dígitos (01, 02, etc.)
      const diaFormateado = i.toString().padStart(2, "0");
      diaElement.append(`<option value="${diaFormateado}">${diaFormateado}</option>`);
    }

    // Marcar como válido si hay mes seleccionado
    mesesElement.removeClass("error_input");
    mesesElement.addClass("cumplido");
    cumplidoSpanMeses.removeClass("error_span");
    cumplidoSpanMeses.addClass("cumplido_span");
  });
}

/**
 * Limpia un input o select según su tipo y configuración
 * @param {string} idinput - Selector del elemento a limpiar
 * @param {string} span - Selector del span asociado al elemento
 * @param {boolean} ifselect2 - Indica si el elemento es un select2
 * @param {boolean} ifselect - Indica si el elemento es un select normal
 * @param {boolean} ifinput - Indica si el elemento es un input normal
 * @param {boolean} ifnumber - Indica si el elemento es un input numérico
 */
export async function limpiarInput(idinput, span, ifselect2, ifselect, ifinput, ifnumber) {
  // Obtener el elemento jQuery una sola vez para mejorar rendimiento
  const $elemento = $(idinput);
  const $span = $(span);

  // Si es un checkbox, no hacer nada y salir
  if ($elemento.attr('type') === 'checkbox') {
    return;
  }

  // Limpiar input normal
  if (ifinput) {
    $elemento.val("");
    $elemento.removeClass('cumplido');
    $span.removeClass("cumplido_span");
  }

  // Limpiar select2
  if (ifselect2) {
    const $select2Container = $elemento.next('.select2-container');
    $select2Container.removeClass('cumplido');
    $span.removeClass('cumplido_span');
    $elemento.find('option').not(':first').remove();
    $elemento.val("");
  }

  // Limpiar select normal
  if (ifselect) {
    const $select2Container = $elemento.next('.select2-container');
    $select2Container.removeClass('cumplido');
    $elemento.val('').trigger('change');
    $span.removeClass("error_span");
    $span.removeClass("cumplido_span");
  }

  // Limpiar input numérico
  if (ifnumber) {
    $elemento.val('0');
  }
}

/** 
 * Limpiar todos los input de formulario selccionado
 * @param {string} formulario - selector del formulario
 */
export function limpiarFormulario(formulario) {
  const elementos = formulario.querySelectorAll('input, select, textarea');

  elementos.forEach(elemento => {
    // Manejar checkboxes y radio buttons
    if (elemento.type === 'checkbox' || elemento.type === 'radio') {
      elemento.checked = false;
    }
    // Manejar selects (incluyendo select2)
    else if (elemento.tagName === 'SELECT') {
      // Verificar si es un select2
      if ($(elemento).hasClass('select2-hidden-accessible')) {
        $(elemento).val(null).trigger('change');
      } else {
        // Para selects normales
        if (elemento.multiple) {
          // Para select-multiple
          Array.from(elemento.options).forEach(option => option.selected = false);
        } else {
          // Para select-one
          elemento.value = '';
        }
        elemento.dispatchEvent(new Event('change'));
      }
    }
    // Manejar inputs y textareas
    else {
      // Limpiar el valor
      elemento.value = '';

      // Disparar eventos para mantener la consistencia
      elemento.dispatchEvent(new Event('input'));
      elemento.dispatchEvent(new Event('change'));
    }
  });
}

/**
 * Verifica si existe un empleado por su cédula
 * @param {string} input - Selector del input de cédula
 * @param {string} cumplido_span - Selector del span de validación
 * @param {string} text - Mensaje de error a mostrar
 */
export async function cedulaExisteEmpleado(input, cumplido_span, text) {
  let timeoutId;
  const losgitudMinima = 7;
  const timeRebote = 300; // ms para evitar múltiples llamadas

  $(document).on("input", input, async function () {
    const $input = $(this);

    // Solo proceder si tiene la clase busquedaCedula
    if (!$input.hasClass("busquedaCedula")) return;

    // Limpiar el timeout anterior
    clearTimeout(timeoutId);

    // Usar debounce para evitar múltiples llamadas
    timeoutId = setTimeout(async () => {
      const cedula = $input.val().trim();

      // Validar longitud mínima
      if (cedula.length < losgitudMinima) return;

      try {
        const formData = new FormData();
        formData.append('cedulaEmpleado', cedula);

        async function callbackExito(parsedData) {
          if (parsedData.exito === true) {
            clasesInputsError(input, cumplido_span);
            await alertaNormalmix(text, 4000, "error", "top-end");
          }
        }

        await enviarFormulario(
          "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal",
          formData,
          callbackExito,
          true
        );
      } catch (error) {
        console.error('Error al verificar cédula:', error);
        await alertaNormalmix('Error al verificar la cédula', 4000, "error", "top-end");
      }
    }, timeRebote);
  });
}

// funcion de retotrno de imagens de select2
export function formatState(state) {
  if (!state.id) {
    return state.text;
  }
  if (state.img) { // Usar state.img en lugar de state.cedula
    console.log(state);
    var $state = $(
      '<span><img src="src/global/photos/' + state.img + '.png" class="img-flag rounded-circle" style="width: 30px; height: 30px; margin-right: 5px;" /> ' + state.text + '</span>'
    );
    return $state;
  }
  return state.text;
}

/**
 * Maneja el cálculo de edad con validaciones configurables
 * @param {Object} config - Configuración para el cálculo de edad
 * @param {Object} config.mensajes - Mensajes de validación
 * @param {Function} config.mensajes.edadAlta - Función para mensaje de edad alta
 * @param {Function} config.mensajes.edadBaja - Función para mensaje de edad baja
 * @param {number} config.edadMinima - Edad mínima requerida (default: 18)
 * @param {number} config.edadMaxima - Edad máxima permitida (default: 100)
 * @returns {Function} Función para manejar el cálculo de edad
 */
export function crearManejadorEdad(config) {
  const {
    selectores,
    mensajes = {
      faltaAno: "Seleccione un año.",
      faltaMes: "Seleccione un mes.",
      faltaDia: "Seleccione un día.",
      edadAlta: (edad) => `¡Wow! Tienes ${edad} años de edad, ¡felicitaciones! al empleado`,
      edadBaja: (edad) => `Lamentablemente, no podemos permitir el acceso a esta persona. La edad mínima requerida es de 18 años, y esta persona tiene ${edad} años`
    },
    edadMinima = 18,
    edadMaxima = 100
  } = config;

  return () => {
    const dia = $(selectores.dia).val();
    const mes = $(selectores.meses).val();
    const ano = $(selectores.ano).val();
    const edad = $(selectores.edad);

    // Validar campos requeridos
    if (!ano) {
      alertaNormalmix(mensajes.faltaAno, 2000, "warning", "top");
      return;
    }

    if (!mes) {
      alertaNormalmix(mensajes.faltaMes, 2000, "warning", "top");
      return;
    }

    if (!dia) {
      alertaNormalmix(mensajes.faltaDia, 2000, "warning", "top");
      return;
    }

    // Calcular edad
    const fechaNacimiento = new Date(ano, mes - 1, dia);
    if (isNaN(fechaNacimiento.getTime())) {
      alertaNormalmix("Fecha de nacimiento inválida", 2000, "error", "top");
      return;
    }

    const edadCalculada = calcularEdad(fechaNacimiento);

    // Actualizar campo de edad
    edad.val(edadCalculada);
    clasesInputs(selectores.edad, ".span_edad");

    // Validar edad máxima
    if (edadCalculada >= edadMaxima) {
      alertaNormalmix(
        mensajes.edadAlta(edadCalculada),
        4000,
        "info",
        "top"
      );
    }

    // Validar edad mínima
    if (edadCalculada < edadMinima) {
      alertaBasica(
        mensajes.edadBaja(edadCalculada),
        7000,
        "info",
        "top-center",
        "Edad no requerida"
      );
      clasesInputsError(selectores.edad, ".span_edad");
    }

    return edadCalculada;
  };
}


// Funcion para buscar las fotos de los empleados mediante la cédula de identidad
/**
 * 
 * @param {string} input - Selector del input  
 * @param {string} divContens - Selector del contenedor de la imagen  
 */
export async function validarBusquedaCedula(input, divContens) {
  let temporizador;

  $(input).on("input", function () {
    clearTimeout(temporizador); // Cancela el temporizador anterior
    const cedula = $(this).val();

    if (cedula.length >= 7) {
      temporizador = setTimeout(() => {
        realizarBusqueda(cedula, divContens); // Realiza la búsqueda después del temporizador
      }, 300); // Espera 500 milisegundos (0.5 segundos)
    } 
  });

  async function realizarBusqueda(cedula, divContens) {
    const imageUrl = `./src/global/photos/${cedula}.png`;

    try {
      // Crear una promesa para cargar la imagen
      const loadImage = () => {
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.src = imageUrl;
          img.classList.add("img-fluid", "imgFoto", "w-100", "h-100");
          
          img.onload = () => resolve(img);
          img.onerror = () => reject(new Error('Imagen no encontrada'));
        });
      };

      // Esperar a que la imagen se cargue
      const img = await loadImage();

      // Actualizar todos los contenedores
      divContens.forEach(div => {
        $(div).empty();
        const imgElement = $(img.cloneNode(true));
        $(div).append(imgElement.hide().slideDown("slow"));
      });

    } catch (error) {
      // Manejar el error de carga
      divContens.forEach(div => {
        $(div).empty();
        const mensaje = $('<div>Imagen no encontrada</div>');
        $(div).append(mensaje.hide().slideDown("slow"));
      });
    }
  }
}