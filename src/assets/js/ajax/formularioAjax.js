export async function enviarFormulario(url, datos, callbackExito, ejecutarCallback = false, metodo = 'POST') {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: metodo,
            data: datos,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                cargando.style.display = 'flex';
            },
            success: function (data, status, response) {
                try {
                    // Intenta parsear los datos como JSON
                    const parsedData = data;
                    // console.table(parsedData)

                    if (ejecutarCallback) {
                        callbackExito(parsedData);
                    }
                    cargando.style.display = 'none';
                } catch (error) {
                    console.error('Error al parsear los datos JSON:', error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    });
}

export async function enviarDatos(url, datos, metodo = 'POST') {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: metodo,
            data: datos,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data, status, response) {
                const parsedData2 = data;
                console.log("Enviado");
                console.table(parsedData2)
                cargando.style.display = 'none';
                if (data.url) {
                    window.location.href = data.url;
                } else {
                    console.log("no se puede redireccionar");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    });
}

export function enviarDatosPersonalizados(url, datos, metodo = 'POST') {
    $.ajax({
        url: url,
        type: metodo,
        data: datos,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        success: function (data, status, response) {
            const parsedData2 = data;
            console.log("Enviado");
            console.table(parsedData2)
            cargando.style.display = 'none';
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

export async function obtenerDatos(url, metodo = 'POST') {
    return new Promise((resolve, reject) => {
        $.ajax({
            url,
            type: metodo,
            success: (data) => {
                // console.log("Datos obtenidos:", data);
                resolve({
                    exito: data.exito,
                    response: data
                }); // Resuelve la promesa con los datos
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('Error al obtener los datos:', errorThrown);
                reject(errorThrown);
            }
        });
    });
}

export async function obtenerDatosPromise(url, data = {}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        method: 'POST', // O 'POST', según tu necesidad
        data: data,
        dataType: 'json', // Asegúrate de que el servidor responde con JSON
        success: function(response) {
          resolve(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          reject({ status: textStatus, error: errorThrown });
        }
      });
    });
}
  
export async function obtenerDatosJQuery(url, options = {}) {
    let formData = new FormData();
    for (let key in options) {
        formData.append(key, options[key]);
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error al obtener los datos:', error);
        throw error;
    }
}

// export async function obtenerDatosJQuery(url, options = {}) {
//     let formData = new FormData();
//     for (let key in options) {
//         formData.append(key, options[key]);
//     }

//     return $.ajax({
//         url: url,
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         dataType: 'json'
//     });
// }
// Función para generar un hash seguro con sal

export function generarHashContrasena(contrasena) {
    // Generar una sal aleatoria de 16 bytes (32 caracteres hexadecimales)
    const salt = CryptoJS.lib.WordArray.random(16).toString();
    const hash = CryptoJS.SHA256(contrasena + salt).toString();
    // Combinar el hash y la sal en un solo string
    return hash + salt;
}

// Función para verificar una contraseña
export function verificarContrasena(contrasena, hashAlmacenado) {
    // Separar el hash y la sal del string almacenado
    const hashParte = hashAlmacenado.substring(0, 64); // Hash SHA-256 tiene 64 caracteres hexadecimales
    const saltParte = hashAlmacenado.substring(64);
    // Reconstruir el hash original con la sal
    const hashCalculado = CryptoJS.SHA256(contrasena + saltParte).toString();
    // Comparar los hashes
    return hashCalculado === hashParte;
}

export async function descargarArchivo(url, nombreArchivo, formData = null) {
    try {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.responseType = 'blob';

        // Mostrar alerta de descarga iniciada
        const Toast = Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        Toast.fire({
            icon: "success",
            title: "Descargando archivo..."
        });

        xhr.onload = function () {
            if (xhr.status === 200) {
                const contentType = xhr.getResponseHeader('Content-Type');
                if (!contentType || (!contentType.includes('application/pdf') && !contentType.includes('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))) {
                    const reader = new FileReader();
                    reader.onload = function () {
                        console.error('Respuesta del servidor:', reader.result);
                    };
                    reader.readAsText(xhr.response);
                    throw new Error('La respuesta no es un PDF o Excel válido');
                }

                const urlBlob = window.URL.createObjectURL(xhr.response);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = urlBlob;
                a.download = nombreArchivo;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(urlBlob);

                // Mostrar alerta de descarga completa
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 5000,
                });
                Toast.fire({
                    icon: "success",
                    title: "Archivo Descargado"
                });
            } else {
                throw new Error('Error al generar archivo');
            }
        };

        xhr.onerror = function () {
            console.error('Error al generar archivo:', xhr.statusText);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un error al descargar el archivo.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        };

        xhr.send(formData);
    } catch (error) {
        console.error('Error al generar archivo:', error);
        Swal.fire({
            title: 'Error',
            text: 'Hubo un error al descargar el archivo.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    } finally {
        const botonPdf = document.querySelector('.pdf');
        if (botonPdf) {
            botonPdf.classList.remove('processing');
        }
    }
}

export async function descargarArchivo2(url, nombreArchivo, formData = null) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Error al generar PDF');
        }

        // Verificar el tipo de contenido de la respuesta
        const contentType = response.headers.get('Content-Type');
        if (!contentType || !contentType.includes('application/pdf')) {
            throw new Error('La respuesta no es un PDF válido');
        }

        const blob = await response.blob();
        const urlBlob = window.URL.createObjectURL(blob);

        // Usar el método nativo de descarga
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = urlBlob;
        a.download = nombreArchivo;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

        // Revocar la URL del blob después de su uso
        window.URL.revokeObjectURL(urlBlob);
    } catch (error) {
        console.error('Error al generar PDF:', error);
    } finally {
        // Restaurar el estado del botón en cualquier caso
        const botonPdf = document.querySelector('.pdf');
        if (botonPdf) {
            botonPdf.classList.remove('processing');
        }
    }
}