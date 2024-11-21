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