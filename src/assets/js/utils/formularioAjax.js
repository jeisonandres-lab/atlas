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
            success: function (response) {
                resolve(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject({ status: textStatus, error: errorThrown });
            }
        });
    });
}

export async function obtenerDatosJQuery(url, options = {}) {
    const formData = new FormData();
    for (const key in options) {
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

        return await response.json();
    } catch (error) {
        console.error('Error al obtener los datos:', error);
        throw error;
    }
}

// Función para generar un hash seguro con sal
export function generarHashContrasena(contrasena) {
    // Generar una sal aleatoria de 16 bytes (32 caracteres hexadecimales)
    const salt = CryptoJS.lib.WordArray.random(16).toString(CryptoJS.enc.Hex);
    const hash = CryptoJS.SHA256(contrasena + salt).toString(CryptoJS.enc.Hex);
    // Devolver el hash y la sal por separado
    return {
        hash: hash,
        salt: salt
    };
}

// Función para verificar una contraseña
export function verificarContrasena(contrasena, hashAlmacenado, saltAlmacenada) {
    // Reconstruir el hash original con la sal almacenada
    const hashCalculado = CryptoJS.SHA256(contrasena + saltAlmacenada).toString(CryptoJS.enc.Hex);
    // Comparar los hashes
    return hashCalculado === hashAlmacenado;
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

// Abrebiar nombres de empelados
export function abreviarNombre(nombreCompleto) {
    const palabras = nombreCompleto.split(' ');
    let nombreAbreviado = palabras[0]; // Primera palabra (nombre)

    // Iniciales de las palabras intermedias del nombre
    for (let i = 1; i < palabras.length - 2; i++) {
        nombreAbreviado += ' ' + palabras[i].charAt(0) + '.';
    }

    // Primer apellido y iniciales de los apellidos
    if (palabras.length > 2) {
        nombreAbreviado += ' ' + palabras[palabras.length - 2] + ' ' + palabras[palabras.length - 1].charAt(0) + '.';
    } else {
        nombreAbreviado += ' ' + palabras[palabras.length - 1] + '.';
    }

    return nombreAbreviado;
}

// Función para verificar si todos los inputs y selects cumplen con las clases requeridas
export function todosCumplidos(formulario) {
    const elementos = formulario.querySelectorAll('input, select');
    const noCumplidos = Array.from(elementos).filter(el => 
        !el.classList.contains('cumplido') && 
        !el.classList.contains('cumplidoNormal') && 
        !el.classList.contains('ignore-validation')
    );

    if (noCumplidos.length > 0) {
        // console.log('Elementos que faltan:', noCumplidos);
    }

    return noCumplidos.length === 0;
}

// Función para habilitar o deshabilitar el botón
export function habilitarBoton(formulario, boton) {
    const todosCumplen = todosCumplidos(formulario);
    console.log('Todos cumplen:', todosCumplen);
    $(boton).prop('disabled', !todosCumplen);
}

// Función de debounce para limitar la frecuencia de ejecución
export function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Crear una instancia de MutationObserver y observar cambios en un formulario específico
export function observarFormulario(formulario, boton) {
    const observer = new MutationObserver(mutationsList => {
        let shouldValidate = false;
        for (const mutation of mutationsList) {
            if (mutation.type === 'childList' || mutation.type === 'attributes') {
                shouldValidate = true;
                // console.log('Cambio detectado:', mutation);
                break;
            }
        }
        if (shouldValidate) {
            habilitarBoton(formulario, boton);
        }
    });

    // Configurar el observer para observar cambios en los hijos y atributos del formulario, excluyendo el botón
    const config = { childList: true, attributes: true, subtree: true, attributeFilter: ['class', 'style'] };

    // Comenzar a observar el formulario
    observer.observe(formulario, config);
}