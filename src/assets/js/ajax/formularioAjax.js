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


