export function AlertSW2(icons, messenger, position, time) {
    const Toast = Swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: time,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: icons,
        title: messenger
    });
}

export function AlertDirection(icons, messenger, position, time, callback) {
    const Toast = Swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: time,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: icons,
        title: messenger
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            callback();
        } else {
            console.log("no se logro realizar ninguna accion");
        }
    }).catch((error) => {
        // Manejar errores que puedan ocurrir durante Swal.fire o cualquier otra operación asincrónica
        console.error("Error occurred:", error);
    });
}

export function alertaNormalmix(messenger, time, icons, position){
    const Toast = Swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: time,
        timerProgressBar: false,
    });
    Toast.fire({
        icon: icons,
        title: messenger
    });
}

export function aletaCheck(messenger, icons, position, callback){
    const Toast = Swal.mixin({
        toast: true,
        timer: 10000,
      });
      Toast.fire({
        icon: icons,
        position:position,
        html:messenger,
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: '<i class="fa fa-check me-2"></i> Aceptar', // Icono en el botón de confirmación
        cancelButtonText: '<i class="fa-solid fa-arrow-right me-2"></i> Cancelar',
        customClass: {
            icon: 'my-custom-icon' // Aplica la clase personalizada al icono
        }
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            callback();
        } else if (result.isDenied) {
          Swal.fire("Changes are not saved", "", "info");
        }
      });
}
