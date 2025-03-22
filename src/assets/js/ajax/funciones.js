import { alertaNormalmix } from "./alerts";

//funcion para calcular la edad por medio del año 
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

//calcular los dias mediante los años y meses
export async function carculasDias(meses, ano, dia, cumplidospanMeses) {
  $(document).on("change", meses, function () {
    const year = $(ano).val();
    const month = $(this).val();

    if (!month) {
      $(this).toggleClass("cumplido error_input");
      $(cumplidospanMeses).toggleClass("cumplido_span error_span");
    } else {
      const daysInMonth = new Date(year, month, 0).getDate();
      const $dia = $(dia).empty().append('<option value="">Seleccione un día</option>');

      for (let i = 1; i <= daysInMonth; i++) {
        const diaFormateado = i.toString().padStart(2, "0");
        $dia.append(`<option value="${diaFormateado}">${diaFormateado}</option>`);
      }
      $(this).toggleClass("error_input cumplido");
      $(cumplidospanMeses).toggleClass("error_span cumplido_span");
    }
  });
}

// limpiar inputs y select2 
export async function limpiarInput(idinput, span, ifselect2, ifselect, ifinput, ifnumber) {
  if ($(idinput).attr('type') === 'checkbox') {
    return;
  }

  if (ifinput) {
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

  if (ifselect) {
    let select2Container = $(idinput).next('.select2-container');
    select2Container.removeClass('cumplido');
    $(idinput).val('').trigger('change');
    $(span).removeClass("error_span");
    $(span).removeClass("cumplido_span");
  }

  if (ifnumber) {
    $(idinput).val('0');
  }
}

//limpiar totalmente el formulario
export function limpiarFormulario(formulario) {
  $(formulario).find('input, select, textarea').each(function () {
    switch (this.type) {
      case 'password':
      case 'text':
      case 'textarea':
      case 'hidden':
      case 'number':
      case 'file':
        $(this).val('');
        break;
      case 'checkbox':
      case 'radio':
        this.checked = false;
        break;
      case 'select-one':
      case 'select-multiple':
        $(this).val(null).trigger('change'); // Limpia y dispara el evento change (para Select2)
        break;
      default:
        break;
    }
  });
}
