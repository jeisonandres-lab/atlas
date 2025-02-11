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
                    console.table(parsedData)

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

export async function obtenerDatosJQuery(url, options = {}) {
    let formData = new FormData();
    for (let key in options) {
        formData.append(key, options[key]);
    }

    return $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json'
    });
}
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


export async function descargarArchivo(url, nombreArchivo) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Error al generar PDF');
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