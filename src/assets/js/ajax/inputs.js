// Funcion para vlaidar campos tipo text que tambien coloquen la primera letra en mayuscula
export async function validarNombre(input, cumplidospan) {
  $(input).on("input", function () {
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
export async function validarTelefono(input, cumplidospan) {
  $(input).on("input", function () {
    // Eliminar cualquier cosa que no sea un número
    this.value = this.value.replace(/[^0-9]/g, "");
    console.log(this.value)
    // Limitar a 12 dígitos
    if (this.value.length > 11) {
      this.value = this.value.slice(0, 11);
    }
    // Aplicar clases según la longitud
    if (this.value.length == 11) {
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

// Funcion para validar los inputs de tipo number
export async function validarNumeroNumber(input, cumplidospan,) {
  $(input).on("input", function () {
    // Si el valor es menor a 0, lo reemplazamos por 0
    if (this.value <= 0) {
      $(this).val("0");
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
  })

}

// Funcion para validar los selectores de tipo select 
export async function validarSelectores(input, cumplidospan, tigger) {
  $(input).on("input", function () {
    console.log("hola");
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

export async function validarSelectoresSelec2(input, cumplidospan) {
  // Maneja el evento select2:select y change
    $("#dependencia").on('select2:select change', function (e) {
      const select2Container = $(this).next('.select2-container');
      const selectedValue = $(this).val();
      const select = $("#dependencia");
      const span = $(".span_dependencia");
      if (select.val() == "") {
        select2Container.removeClass('cumplido');
        select2Container.addClass('error_input');
        select.removeClass('cumplido');
        span.removeClass('cumplido_span');
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
  // Simular una operación asincrónica con Promise y setTimeout
  const obtenerMeses = () => {
    return new Promise((resolve) => {
      setTimeout(() => {
        const meses = [
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
        resolve(meses);
      }, 1000); // Simular un retraso de 1 segundo
    });
  };

  // Obtener los meses de forma asincrónica
  const meses = await obtenerMeses();

  // Crear las opciones del select
  meses.forEach(mes => {
    $(input).append(`<option value="${mes.valor}">${mes.nombre}</option>`);
  });
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
  // Simular una operación asincrónica con Promise y setTimeout
  const obtenerNivelesEducativos = () => {
    return new Promise((resolve) => {
      setTimeout(() => {
        const niveles = [
          { valor: 'bachiller', nombre: "Bachiller" },
          { valor: 'tecnico', nombre: "Técnico" },
          { valor: 'tecnologo', nombre: "Tecnólogo" },
          { valor: 'pregrado', nombre: "Pregrado" },
          { valor: 'ingeniero', nombre: "Ingeniero" },
          { valor: 'especialista', nombre: "Especialista" },
          { valor: 'maestria', nombre: "Maestría" },
          { valor: 'doctorado', nombre: "Doctorado" },
        ];
        resolve(niveles);
      }, 1000); // Simular un retraso de 1 segundo
    });
  };

  // Obtener los niveles educativos de forma asincrónica
  const niveles = await obtenerNivelesEducativos();

  // Crear las opciones del select
  niveles.forEach(nivel => {
    $(input).append(`<option value="${nivel.valor}">${nivel.nombre}</option>`);
  });
}

// Validar documentos subidos
export async function file(input, cumplidospan){
  $(input).on("change", function(){
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

export async function limpiarInput(idinput, span) {
  if ($(idinput).attr('type') === 'checkbox') {
    return;
  }

  $(idinput).find('option').not(':first').remove();
  $(idinput).val("");


  $(idinput).removeClass("cumplido");
  if (span) {
    $(span).removeClass("cumplido_span");
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