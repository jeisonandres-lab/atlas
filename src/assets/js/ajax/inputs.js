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
    if (this.value.length < 6) {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    } else if (this.value.length >= 6 || this.value.length <= 9) {
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

export function validarNumeroNumber(input,cumplidospan,) {
  $(input).on("input", function () {
    // Si el valor es menor a 0, lo reemplazamos por 0
    if (this.value <= 0) {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(cumplidospan).removeClass("cumplido_span");
      $(cumplidospan).addClass("error_span");
    }else{
     
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

export function validarBusquedaCedula(input, divConten) {
  $(input).on("input", function () {
    const cedula = $(this).val();
    const imageUrl = `src/assets/photos/${cedula}.png`;
    // Creamos una nueva imagen y la agregamos al DOM
    const img = new Image();
    img.src = imageUrl;
    img.classList.add("img-fluid");
    img.classList.add("imgFoto");
    img.classList.add("w-100");
    img.classList.add("h-100");
    // Escuchamos el evento 'load' para verificar si la imagen se cargó correctamente
    img.onload = () => {
      $(divConten).html(img);
    };

    // Escuchamos el evento 'error' para manejar el caso en que la imagen no se encuentre
    img.onerror = function () {
      $(divConten).html("Imagen no encontrada");
    };
  });
}

export function colocarMeses(input) {
  // Generar las opciones de los meses
  const meses = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ];
  for (let i = 0; i < meses.length; i++) {
    // Sumamos 1 al índice para que los valores comiencen en 1
    const valorMes = i + 1;
    const valorMesFormateado = valorMes.toString().padStart(2, "0");
    $(input).append(
      '<option value="' + valorMesFormateado + '">' + meses[i] + "</option>"
    );
  }
}

export function colocarYear(input, desde) {
  var anioInicio = desde;
  var anioFin = new Date().getFullYear(); // Obtiene el año actual
  for (var i = anioFin; i >= anioInicio; i--) {
    $(input).append('<option value="' + i + '">' + i + "</option>");
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