

$(function () {
    $("#primerNombre").on('input', function() {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
        if (this.value.length < 4) {
            console.log("Debe ingresar al menos 4 letras.");
            $(this).removeClass("cumplido");
            $(".span_contener").removeClass("cumplido_span"); 
            $(".icon_icon").removeClass("icon_check"); 
          } else if (this.value.length >= 4 || this.value.length <= 12) {
            this.value = this.value.slice(0, 12);
            $(this).addClass("cumplido"); 
            $(".span_contener").addClass("cumplido_span"); 
            $(".icon_icon").addClass("icon_check"); 
            console.log("Okay, el valor es válido.");
          }
      });
    
})