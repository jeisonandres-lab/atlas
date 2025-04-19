import { todosCumplidos, habilitarBoton, debounce, observarFormulario } from "./utils/formularioAjax.js";
import { AlertDirection, AlertSW2 } from "./utils/alerts.js";
import { validarSelectoresSelec2, incluirSelec2, validarNumeroNumber, validarTexto } from "./utils/inputs.js";

$(function () {
    incluirSelec2("#datosRecuperar");
    validarSelectoresSelec2("#datosRecuperar");
    validarNumeroNumber("#cedula", "", 10);
    validarNumeroNumber("#pin", "", 10);
    validarTexto("#rpUser", "");
    validarTexto("#password", "");
    $(".usarPass").hide();
    $(".usarPin").hide();

    // DATOS DE RECUPERAR DATOS
    $(document).on("keyup", "#cedula", function () {
        const cedula = $(this).val();

        if (cedula.length >= 7) {
            const formData = new FormData();
            formData.append("cedula", cedula);

            fetch("src/ajax/administrador.php?modulo_datos=existeCedula", {
                method: "POST",
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Manejar los datos recibidos del servidor
                    console.log(data.existeEmpleado);
                    if (data.existeEmpleado) {
                        $("#contenSelect").removeAttr('hidden');
                        AlertSW2("success", data.mensaje, "top", 4000);
                    } else {
                        $("#contenSelect").attr('hidden', true);
                        AlertSW2("error", data.mensaje, "top", 4000);
                    }

                    // Aquí puedes actualizar la interfaz con los datos del empleado
                })
                .catch(error => {
                    // Manejar errores de la petición
                    console.error("Error en la petición:", error);
                    // Mostrar un mensaje de error al usuario
                });
        } else {
            $("#contenSelect").attr('hidden', true);
        }
    });

    // Cambiar contenido de recuperar datos
    $(document).on('change', '#datosRecuperar', function () {
        if ($(this).val() === 'rpUser') {
            $('#rpPassContent').remove();
            $('#rpUserContent').remove();
            $("#alert2").html(`
                <div class="d-flex alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center alert-icon me-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-text">
                        <strong>Para recuperar Usuario</strong> es necesario que ingrese el  <strong class="text-danger">contraseña</strong> de usuario o  otro medio como el <strong class="text-danger">pin</strong>
                    </div>
                </div>
            `)
            $('#contenSelect').after(`
            <div class="input-group mb-3" id="rpUserContent">
                <span class="input-group-text"><i class="fa-regular fa-user-group"></i></span>
                <input type="text" name="usuario" id="rpUser" class="form-control input_user px-3" value="" placeholder="Recuperar Usuario" autocomplete="username">
            </div>
        `);
        }

        if ($(this).val() === 'rpPassword') {
            $('#rpPassContent').remove();
            $('#rpUserContent').remove();
            $("#alert2").html(`
                <div class="d-flex alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center alert-icon me-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-text">
                        <strong>Para recuperar la contraseña</strong> es necesario que ingrese el <strong class="text-danger">pin</strong> de usuario y responda una <strong class="text-danger">pregunta de seguridad</strong>
                    </div>
                </div>
            `)
            $('#contenSelect').after(`
            <div class="input-group mb-3" id="rpPassContent">
                <span class="input-group-text"><i class="password fa-solid fa-key"></i></span>
                <input type="text" name="password" id="password" class="form-control input_user px-3" value="" placeholder="Nueva contraseña" >
            </div>
        `);
        }
    });

    // enviar datos de recuperar datos
    $(document).on("click", "#button", function (e) {
        $("#modalUser").modal('show');
        $(".usarPin").show();
        $(".usarPass").show();
        let select = $("#datosRecuperar").val();
        console.log(select);
        if (select == "rpUser") {
            $(".modalBodyUsuario").html(`
            <div class="input-group mb-3" id="rpPassContent">
                <span class="input-group-text"><i class="password fa-solid fa-key"></i></span>
                <input type="text" name="password" id="password" class="form-control input_user px-3" value="" placeholder="Nueva contraseña" >
            </div>
            `);
        }
        if (select == "rpPassword") {
            $(".modalBodyUsuario").html(`
            <div class="input-group mb-3" id="rpPassContent">
                <span class="input-group-text"><i class="password fa-solid fa-key"></i></span>
                <input type="text" name="password" id="password" class="form-control input_user px-3" value="" placeholder="Contraseña">
            </div>
            `);
        }
    });

    // CARGAR input pin
    $(document).on("click", ".usarPin", function (e) {
        $(".modalBodyUsuario").html(`
            <div class="input-group mb-3" id="rpPassContent">
                <span class="input-group-text"><i class="password fa-solid fa-key"></i></span>
                <input type="text" name="pin" id="pin" class="form-control input_user px-3" value="" placeholder="Pin">
            </div>
            `);

    });

    // CARGAR input password
    $(document).on("click", ".usarPass", function (e) {
        $(".modalBodyUsuario").html(`
            <div class="input-group mb-3" id="rpPassContent">
                <span class="input-group-text"><i class="password fa-solid fa-key"></i></span>
                <input type="text" name="password" id="password" class="form-control input_user px-3" value="" placeholder="Contraseña">
            </div>
            `);

    });

    // Enviar formulario de actualzar datos
    $(document).on("click", "#enviarDatos", function (e) {
        e.preventDefault();
        const cedula = $("#cedula").val();
        const select = $("#datosRecuperar").val();
        const pin = $("#pin").val();
        const password = $("#password").val();
        const formData = new FormData();
        formData.append("cedula", cedula);
        formData.append("select", select);
        
        if(pin == ""){
            formData.append("pin", pin);
        }
        if(password == ""){
            formData.append("password", password);
        }
      

    });


    $(document).on("submit", ".formularioVerificar", function (e) {
        e.preventDefault();
        const cedula = $("#cedula").val();
        const formData = new FormData(this);
        formData.append("cedula", cedula);
  

        fetch("src/ajax/userAjax.php?modulo_usuario=verificarPin", {
            method: "POST",
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Manejar los datos recibidos del servidor
                console.log(data);
                if (data.actualizado) {
                    AlertSW2("success", data.mensaje, "top", 4000);
                } else {
                    AlertSW2("error", data.mensaje, "top", 4000);
                }

                // Aquí puedes actualizar la interfaz con los datos del empleado
            })
            .catch(error => {
                // Manejar errores de la petición
                console.error("Error en la petición:", error);
                // Mostrar un mensaje de error al usuario
        });
    });

    const formulario = document.querySelector('.formularioEnviar');
    const boton = $('#button');

    // datos de verificacion
    const formulario2 = document.querySelector('.formularioVerificar');
    const boton2 = $('.actualizarDatos');
    // Inicializar la observación del formulario
    observarFormulario(formulario, boton);
    habilitarBoton(formulario, boton);

    observarFormulario(formulario2, boton2);
    habilitarBoton(formulario2, boton2);
});

// <span class="input-group-text"><i class="user fas fa-user"></i></span>
//                 <input type="text" name="pin" id="rpPin" class="form-control input_user px-3" value="" placeholder="pin de usuario" ></input>