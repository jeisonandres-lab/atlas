import { obtenerDatos } from "./ajax/formularioAjax.js";


$(function () {
    // Configuración base para DataTables
    const baseConfig = {
        responsive: true,
        processing: false,
        serverSide: false, // Asegúrate de que esto esté configurado si estás usando procesamiento del lado del servidor
        info: false,
        paging: true,
        lengthMenu: [ 10, 25],
        pageLength: 10,
        pagingType: 'first_last_numbers',
        language: {
            url: "./IdiomaEspañol.json"
        }
    };
    let tableInic = $('#tabla-datos-usuario').DataTable(baseConfig);

    function recargarTabla(newConfig, nuevosTextos, data) {
        tableInic.clear().destroy(); // Limpiar y destruir la tabla existente
        const $thead = $('#tabla-datos-usuario thead');
        $thead.empty(); // Limpiar el contenido existente del thead
    
        // Crear una nueva fila para los encabezados
        const $fila = $('<tr>').addClass('tr-identity');
    
        // Crear y agregar las nuevas celdas a la fila
        nuevosTextos.forEach(texto => {
            const $celda = $('<th>').text(texto).addClass('bg-primary text-white');
            $fila.append($celda);
        });
    
        // Agregar la fila al thead
        $thead.append($fila);
    
        // Limpiar el contenido anterior de la tabla
        $('#tabla-datos-usuario tbody').empty();
    
        // Crear las filas de la tabla
        data.forEach(usuario => {
            let fila = `
                <tr>
                    <td>
                        <div class="container mt-2">
                            <div class="row">
                                <div class="card d-flex flex-row p-0" style="box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                                    <div class="col-1 contenedor-img rounded-start-2 d-flex justify-content-center align-items-center border-end">
                                        <div class="conten-img d-flex justify-content-center align-items-center">
                                            <img class="img-img" style="width: 70px; height: 70px; border-radius: 50%;" src="./src/global/photos/${usuario.cedula}.png" alt="Img del trabajador">
                                        </div>
                                    </div>
                                    <div class="col rounded-end-2 ms-2">
                                     
                                        <div class="content-info me-3 mt-1 mb-2">
                                            <div class="content-datos d-flex justify-content-between">
                                                <span class="user-nombre fw-bolder">
                                                    <i class="fa-regular fa-circle-user text-primary"></i>
                                                    <a class="icon-link" href="#" style="cursor: default;">
                                                        ${usuario.primerNombre} ${usuario.primerApellido} ${usuario.cargo}
                                                    </a>
                                                </span>
                                                <p class="user-ip fs-6 text-secondary mb-0"><small>${usuario.fechaCreada} ${usuario.hora}</small><span class="text-success fw-bolder ms-3">${usuario.ip}</span></p>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-primary">${usuario.tipo_evento}</span>
                                                <div class="content-descripcion">
                                                <p class="mb-0" style="white-space: pre-line;">${usuario.descripcion}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
            // Agregar la fila a la tabla
            $('#tabla-datos-usuario tbody').append(fila);
        });
    
        // Inicializar una nueva instancia con la nueva configuración
        tableInic = $('#tabla-datos-usuario').DataTable(newConfig);
    }
    
    $(document).on('click', '#butonUsuario', async function () {
        let datoBuscar = $("#buscadorUsuario").val();
        let url = './src/ajax/administrador.php?modulo_datos=datosUsuario';
        let formData = new FormData();
        formData.append('usuario', datoBuscar);
    
        try {
            let response = await fetch(url, {
                method: 'POST',
                body: formData
            });
    
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
    
            let data = await response.json();
    
            if (data.exito && data.data.length > 0) {
                    
                // Configuración para DataTables
                const newConfig = {
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    info: false,
                    paging: true,
                    lengthMenu: [10, 25],
                    pageLength: 10,
                    order: [[1, 'desc']],
                    scrollX: true,
                    pagingType: 'first_last_numbers',
                    scrollbars: true, 
                    language: {
                        url: "./IdiomaEspañol.json"
                    }
                };
    
                // Nuevos textos para los encabezados
                const nuevosTextos = ['Registros'];
    
                // Recargar la tabla con los nuevos datos
                recargarTabla(newConfig, nuevosTextos, data.data);
            } else if (data.exito && data.data.length === 0) {
                // $('#contenedor-datos-usuario').append('<p>No se encontraron resultados para este usuario.</p>');
            } else {
                // $('#contenedor-datos-usuario').append(`<p>Error: ${data.messenger}</p>`);
            }
    
        } catch (error) {
            console.error('Error:', error);
            // $('#contenedor-datos-usuario').append('<p>Ocurrió un error al obtener los datos.</p>');
        }
    });


    let botones = document.querySelectorAll('.first'); // Selecciona todos los botones con la clase "tu-clase"

    
    setTimeout(function() {
        $(".firs").text("<<");
      }, 3000); // Retraso de 100 milisegundos

});

const anioInput = document.getElementById('anio');

anioInput.addEventListener('input', function() {
  if (this.value < 1900 || this.value > 2100) {
    this.setCustomValidity('Por favor, ingresa un año entre 1900 y 2100.');
  } else {
    this.setCustomValidity('');
  }
});