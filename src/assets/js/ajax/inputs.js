export function validarInput(inputElement) {
    inputElement.on('input', function() {
        this.value = this.value.replace(/[^a-zA-Z]/g, ''); // Elimina cualquier carácter que no sea una letra
        if (this.value.length >= 4 && this.value.length <= 12) {
            this.value = this.value.slice(0, 12); // Limita a 12 caracteres
            $(this).addClass("cumplido"); 
            $(".span_contener").addClass("cumplido_span"); 
            $(".icon_icon").addClass("icon_check"); 
            console.log("Okay, el valor es válido.");
        } else {
            $(this).removeClass("cumplido"); 
            console.error("Por favor, ingresa entre 4 y 12 letras.");
        }
    });
}