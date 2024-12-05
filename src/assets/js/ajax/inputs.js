export function validarNombre(input, cumplidospan) {
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

export function validarNumeros(input, cumplidospan) {
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

export function validarTelefono(input, cumplidospan) {
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

export function validarNumeroNumber(input, cumplidospan,) {
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

export function validarSelectores(input, cumplidospan, tigger) {
  $(input).on("input", function () {
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

export function valdiarCorreos(input, cumplidospan) {
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

export function validarBusquedaCedula(input, divContens) {
  $(input).on("input", function () {
    const cedula = $(this).val();
    const imageUrl = `src/assets/photos/${cedula}.png`;

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

export function colocarMeses(input) {
  // Generar las opciones de los meses
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
  // Crear las opciones del select
  meses.forEach(mes => {
    $(input).append(`<option value="${mes.valor}">${mes.nombre}</option>`);
  });
}

export function colocarYear(input, desde) {
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

export function liberarInputs(input, cumplidospan, valor) {
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

export function limpiarFormulario(idFormulario, excluir) {
  $(idFormulario).find('*').not(excluir).each(function () {
    $(this).removeClass('cumplido error_span error_input cumplido_span');
    if ($(this).is('input[type="text"], input[type="email"], input[type="password"], textarea, select')) {
      $(this).val('');
    }
  });
}

