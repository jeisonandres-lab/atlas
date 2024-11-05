export function enviarFormulario(formulario) {
    return new Promise((resolve, reject) => {
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
                    return response.json().then(data => {
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
                    // Mostrar un mensaje de éxito más específico
                    console.table(data)
                    alert('¡Los datos se enviaron correctamente!');
                } else {
                    // Mostrar un mensaje de error basado en la respuesta del servidor
                    alert(data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
                alert('Ocurrió un error inesperado. Por favor, intenta más tarde.');
            });
    });
}


export function generarHashContrasena(contrasena) {
  const salt = CryptoJS.lib.WordArray.random(128/8); // Sal de 128 bits
  const hash = CryptoJS.PBKDF2(contrasena, salt, {
    keySize: 256/32, // Tamaño de la clave en bits (256 bits)
    iterations: 100000 // Número de iteraciones (ajustable)
  });
  return salt.toString() + hash.toString();
}

// Función para verificar una contraseña
export  function verificarContrasena(contrasena, hashAlmacenado) {
  const salt = CryptoJS.enc.Hex.parse(hashAlmacenado.substring(0, 32));
  const hashCalculado = CryptoJS.PBKDF2(contrasena, salt, {
    keySize: 256/32,
    iterations: 100000
  });
  return hashCalculado.toString() === hashAlmacenado.substring(32);
}

// // Ejemplo de uso
// const contrasena = 'micontraseñasegura';
// const hash = generarHashContrasena(contrasena);
// console.log(hash);

// // Verificar la contraseña
// const esValida = verificarContrasena('micontraseñasegura', hash);
// console.log(esValida);