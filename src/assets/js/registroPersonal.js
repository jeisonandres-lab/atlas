

$(function () {
    $("#primerNombre").on('input', function(evenet) {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
        if (this.value.length < 3) {
          // evenet.preventDefault();
            console.log("Debe ingresar al menos 4 letras.");
            $(this).removeClass("cumplido");
            $(this).addClass("error_input");
            $(".span_nombre").removeClass("cumplido_span"); 
            $(".span_nombre").addClass("error_span"); 
          } else if (this.value.length >= 4 || this.value.length <= 12) {
            this.value = this.value.slice(0, 12);
            $(this).removeClass("error_input");
            $(this).addClass("cumplido"); 
            $(".span_nombre").removeClass("error_span"); 
            $(".span_nombre").addClass("cumplido_span"); 
            console.log("Okay, el valor es válido.");
          }
      });

      $("#segundoNombre").on('input', function(evenet) {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
        if (this.value.length < 3) {
          // evenet.preventDefault();
            console.log("Debe ingresar al menos 4 letras.");
            $(this).removeClass("cumplido");
            $(this).addClass("error_input");
            $(".span_nombre2").removeClass("cumplido_span"); 
            $(".span_nombre2").addClass("error_span"); 
          } else if (this.value.length >= 4 || this.value.length <= 12) {
            this.value = this.value.slice(0, 12);
            $(this).removeClass("error_input");
            $(this).addClass("cumplido");  
            $(".span_nombre2").removeClass("error_span"); 
            $(".span_nombre2").addClass("cumplido_span"); 
            console.log("Okay, el valor es válido.");
          }
      });

      $("#primerApellido").on('input', function(evenet) {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
        if (this.value.length < 4) {
          // evenet.preventDefault();
            console.log("Debe ingresar al menos 4 letras.");
            $(this).removeClass("cumplido");
            $(this).addClass("error_input");
            $(".span_apellido").removeClass("cumplido_span"); 
            $(".span_apellido").addClass("error_span"); 
          } else if (this.value.length >= 4 || this.value.length <= 12) {
            this.value = this.value.slice(0, 12);
            $(this).removeClass("error_input");
            $(this).addClass("cumplido"); 
            $(".span_apellido").removeClass("error_span"); 
            $(".span_apellido").addClass("cumplido_span"); 
            console.log("Okay, el valor es válido.");
          }
      });

      $("#segundoApellido").on('input', function(evenet) {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
        if (this.value.length < 4) {
          // evenet.preventDefault();
            console.log("Debe ingresar al menos 4 letras.");
            $(this).removeClass("cumplido");
            $(this).addClass("error_input");
            $(".span_apellido2").removeClass("cumplido_span"); 
            $(".span_apellido2").addClass("error_span"); 
          } else if (this.value.length >= 4 || this.value.length <= 12) {
            this.value = this.value.slice(0, 12);
            $(this).removeClass("error_input");
            $(this).addClass("cumplido"); 
            $(".span_apellido2").removeClass("error_span"); 
            $(".span_apellido2").addClass("cumplido_span"); 
            console.log("Okay, el valor es válido.");
          }
      });

      $("#cedula").on('input', function(evenet) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length < 6) {
          // evenet.preventDefault();
            console.log("Debe solo numeros en este campo con igual o mayor a 6 digitos");
            $(this).removeClass("cumplido");
            $(this).addClass("error_input");
            $(".span_cedula").removeClass("cumplido_span"); 
            $(".span_cedula").addClass("error_span"); 
          } else if (this.value.length >= 6 || this.value.length <= 9) {
            this.value = this.value.slice(0, 12);
            $(this).removeClass("error_input");
            $(this).addClass("cumplido"); 
            $(".span_cedula").removeClass("error_span"); 
            $(".span_cedula").addClass("cumplido_span"); 
            console.log("Okay, el valor es válido.");
          }
      });
    
      $('#civil').change(function() {
        // Obtener el valor de la opción seleccionada
        const opcionSeleccionada = $(this).val();
        // Redirigir a una página diferente según la opción
        if (opcionSeleccionada === '') {
          $(this).removeClass("cumplido");
          $(this).addClass("error_input");
          $(".span_etdc").removeClass("cumplido_span"); 
          $(".span_etdc").addClass("error_span"); 
        } else {
          $(this).removeClass("error_input");
            $(this).addClass("cumplido"); 
            $(".span_etdc").removeClass("error_span"); 
            $(".span_etdc").addClass("cumplido_span"); 
        }
      });

      $("#correo").on('input', function(evenet) {
        var correo = this.value;
        var regexHotmail = /@hotmail\.com$/i;
        var regexGmail = /@gmail\.com$/i;

        if (regexHotmail.test(correo) || regexGmail.test(correo)) {
          $(this).addClass("cumplido"); 
          $(this).removeClass("error_span"); 
          $(".span_correo").removeClass("error_span"); 
          $(".span_correo").addClass("cumplido_span"); 
          console.log("Okay, el valor es válido.");
        } else {
          $(this).removeClass("cumplido");
          $(this).addClass("error_span");
          $(".span_correo").removeClass("cumplido_span"); 
          $(".span_correo").addClass("error_span"); 
        }
    });

    $('#dia').change(function() {
      // Obtener el valor de la opción seleccionada
      const opcionSeleccionada = $(this).val();
      // Redirigir a una página diferente según la opción
      if (opcionSeleccionada === '') {
        $(this).removeClass("cumplido");
        $(this).addClass("error_input");
        $(".span_dia").removeClass("cumplido_span"); 
        $(".span_dia").addClass("error_span"); 
      } else {
        $(this).removeClass("error_input");
          $(this).addClass("cumplido"); 
          $(".span_dia").removeClass("error_span"); 
          $(".span_dia").addClass("cumplido_span"); 
      }
    });

    $('#meses').change(function() {
      // Obtener el valor de la opción seleccionada
      const opcionSeleccionada = $(this).val();
      // Redirigir a una página diferente según la opción
      if (opcionSeleccionada === '') {
        $(this).removeClass("cumplido");
        $(this).addClass("error_input");
        $(".span_mes").removeClass("cumplido_span"); 
        $(".span_mes").addClass("error_span"); 
      } else {
        $(this).removeClass("error_input");
          $(this).addClass("cumplido"); 
          $(".span_mes").removeClass("error_span"); 
          $(".span_mes").addClass("cumplido_span"); 
      }
    });

  
    $('#ano').change(function() {
      // Obtener el valor de la opción seleccionada
      const opcionSeleccionada = $(this).val();
      // Redirigir a una página diferente según la opción
      if (opcionSeleccionada === '') {
        $(this).removeClass("cumplido");
        $(this).addClass("error_input");
        $(".span_ano").removeClass("cumplido_span"); 
        $(".span_ano").addClass("error_span"); 
      } else {
        $(this).removeClass("error_input");
          $(this).addClass("cumplido"); 
          $(".span_ano").removeClass("error_span"); 
          $(".span_ano").addClass("cumplido_span"); 
      }
    });

    $("#meses").change(function(){
          
      const year = 2024; // Cambia el año si lo deseas
      const month = $("#meses").val();
      
      // Eliminar el cero inicial si existe
      const monthWithoutLeadingZero = month.replace(/^0+/, '');
      
      console.log("Mes sin cero inicial:", monthWithoutLeadingZero);
      
      // Obtener el número de días en el mes seleccionado
      const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate(); // Restamos 1 al mes porque JavaScript cuenta los meses desde 0
      
      console.log(`El mes ${monthWithoutLeadingZero} del año ${year} tiene ${daysInMonth} días.`);
      
      // Generar las opciones de los días
      $('#dia').empty(); // Limpiar las opciones anteriores
      for (let i = 1; i <= daysInMonth; i++) {
          const diaFormateado = i.toString().padStart(2, '0');
          $('#dia').append('<option value="' + diaFormateado + '">' + diaFormateado + '</option>');
      }
    })

    $('#cedula').on('input', function() {
      const cedula = $(this).val();
      const imageUrl = `src/assets/photos/${cedula}.png`;
      // Creamos una nueva imagen y la agregamos al DOM
      const img = new Image();
      img.src = imageUrl;
      img.classList.add('w-100');
      img.classList.add('h-100');
      // Escuchamos el evento 'load' para verificar si la imagen se cargó correctamente
      img.onload = function() {
        $('#img-contener').html(img);
      };
      // Escuchamos el evento 'error' para manejar el caso en que la imagen no se encuentre
      img.onerror = function() {
        $('#img-contener').html('Imagen no encontrada');
      };
    });
})
// años
var anioInicio = 1900;
var anioFin = new Date().getFullYear(); // Obtiene el año actual
console.log(anioFin)
for (var i = anioFin; i >= anioInicio; i--) {
    $('#ano').append('<option value="' + i + '">' + i + '</option>');
}

// Generar las opciones de los meses
const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
for (let i = 0; i < meses.length; i++) {
    // Sumamos 1 al índice para que los valores comiencen en 1
    const valorMes = i + 1;
    const valorMesFormateado = valorMes.toString().padStart(2, '0');
    $('#meses').append('<option value="' + valorMesFormateado + '">' + meses[i] + '</option>');
}



