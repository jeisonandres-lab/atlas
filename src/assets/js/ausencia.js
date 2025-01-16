$('#cedula').on('input', function () {
    const cedula = $(this).val();
    const imagePath = `./src/global/archives/photos/${cedula}.png`;

    // Verificar si la imagen existe
    $.ajax({
        url: imagePath,
        type: 'HEAD',
        processData: true,
        success: function () {
            // Si la imagen existe, crear la etiqueta de imagen y agregarla al div con la clase content
            const imgTag = `<img src="${imagePath}" class="img-fluid imFoto w-100 h-100" alt="Foto de ${cedula}">`;
            $('#img-contener').html(imgTag);
        },
        error: function () {
            // Si la imagen no existe, mostrar un mensaje de error o una imagen por defecto
            $('#img-contener').html('<p>No se consiguió la imagen</p>');
        }
    });
});