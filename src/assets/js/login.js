import { enviarDatos, enviarFormulario, generarHashContrasena, verificarContrasena } from "./ajax/formularioAjax.js";
import { AlertDirection, AlertSW2 } from "./ajax/alerts.js";

let formulariosAJAX = document.querySelector(".formularioEnviar");
let cerradura = document.getElementById("candado");
let inputPassword = document.querySelector("#password");
let inputPassword2 = document.querySelector(".password");
let contentAlert = document.querySelector("#alert");

//cambio de icono
cerradura.addEventListener('click', function () {
  // Cambia el tipo de input y el icono
  if (inputPassword.type === "text") {
    inputPassword2.classList.add("fa-solid");
    inputPassword2.classList.add("fa-lock");
    inputPassword2.classList.remove("fa-key");
  } else {
    inputPassword2.classList.remove("fa-lock");
    inputPassword2.classList.add("fa-key");
  }
  inputPassword.type = inputPassword.type === "password" ? "text" : "password";
});

//verificar si los inputs tienen datos 
formulariosAJAX.addEventListener('submit', (e) => {
  e.preventDefault();
  // Obtener los elementos del formulario
  let usuarioInput = document.getElementById('usuario');
  let contrasenaInput = document.getElementById('password');
  let passwordSinEncrip = contrasenaInput.value;
  // Validar los campos

  if (usuarioInput.value.trim() === '' && contrasenaInput.value.trim() === '') {
    AlertSW2("error", "Debes de llenar todos los campos.", "top", 4000);
  } else if (usuarioInput.value.trim() === '') {
    AlertSW2("warning", "Por favor, ingresa su nombre de usuario.", "top", 4000);
  } else if (contrasenaInput.value.trim() === '') {
    AlertSW2("warning", "Por favor, ingresa su contraseña.", "top", 4000);
  } else {
    let contrseñatring = contrasenaInput.toString();
    let contraseñaEncrip = generarHashContrasena(contrseñatring);
    contrasenaInput.value = contraseñaEncrip;
    const cargando = document.getElementById('cargando');
    cargando.style.display = 'flex';

    function callbackExito(parsedData) {
      if (parsedData.exito) {
        let hashAlmacenado = parsedData.password;
        const esValida = verificarContrasena(passwordSinEncrip, hashAlmacenado);
        if (esValida === true) {
          let redirecion = function () {
            const url = "./src/ajax/userAjax.php?modulo_usuario=redireccionar";
            let formData = new FormData();
            formData.append('url', `inicio`);
            enviarDatos(url, formData);
          };
          AlertDirection("success", "Inicio de session con exito, Redireccionando", "top-end", 4000, redirecion);
        } else {
          AlertSW2("error", "La contraseña es incorrecta", "top", 4000);
        }
      } else {
        AlertSW2("error", `${parsedData.mensaje}`, "top", 4000);
      }
    }
    let url = "./src/ajax/userAjax.php?modulo_usuario=login";
    const data = new FormData(formulariosAJAX);
    data.append('modulo_usuario', 'login');
    enviarFormulario(url, data, callbackExito, true);
    contrasenaInput.value = passwordSinEncrip;
  }
});
