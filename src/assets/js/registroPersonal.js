

$(function () {
    $("#primerNombre").on('input', function(evenet) {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
        if (this.value.length < 4) {
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
        if (this.value.length < 4) {
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
    
})