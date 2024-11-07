export async function enviarFormularioUsuarios(formulario, password, collback) {
    return new Promise(() => {
        const data = new FormData(formulario);
        const method = formulario.method;
        const action = formulario.action;
        const config = {
            method: method,
            headers: new Headers(),
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };
        fetch(action, config)
            .then(response => {
                if (!response.ok) {
                    return response.json()
                    .then(data => {
                        // Manejar errores específicos basados en la respuesta del servidor
                        if (data.error) {
                            throw new Error(data.error);
                        } else {
                            throw new Error(`La petición ha fallado: ${response.status}`);
                        }
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.exito) {
                    collback(data);
                } else {
                    alert(data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
                alert('Ocurrió un error inesperado. Por favor, intenta más tarde.');
            })
            .finally(() => {
                cargando.style.display = 'none';
            });
    });
}


// Función para generar un hash seguro con sal
export function generarHashContrasena(contrasena) {
    // Generar una sal aleatoria de 16 bytes (32 caracteres hexadecimales)
    const salt = CryptoJS.lib.WordArray.random(16);
    const hash = CryptoJS.SHA256(contrasena + salt);
    return hash.toString() + salt.toString();
  }
  
// Función para verificar una contraseña
export function verificarContrasena(contrasena, hashAlmacenado) {
    // Separar el hash y la sal del string almacenado
    const hashParte = hashAlmacenado.substring(0, 64); // Hash SHA-256 tiene 64 caracteres hexadecimales
    const saltParte = hashAlmacenado.substring(64);
    // Reconstruir el hash original con la sal
    const hashCalculado = CryptoJS.SHA256(contrasena + saltParte);
    // Comparar los hashes
    return hashCalculado.toString() === hashParte;
}
