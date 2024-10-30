import { enviarFormulario } from "./ajax/formularioAjax.js";

let formulariosAJAX=document.querySelector(".formularioEnviar");
let cerradura = document.getElementById("candado");
let inputPassword = document.querySelector("#password");
let inputPassword2 = document.querySelector(".password");

cerradura.addEventListener('click', function() {
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


formulariosAJAX.addEventListener('submit', (e) => {
    e.preventDefault();
    // Obtener los elementos del formulario
    let usuarioInput = document.getElementById('usuario');
    let contrasenaInput = document.getElementById('password');

    // Validar los campos
    if (usuarioInput.value.trim() === '' && contrasenaInput.value.trim() === '') {
        alert('Por favor, llena todos los campos.');
    } else if (usuarioInput.value.trim() === '') {
        alert('Por favor, ingresa tu nombre de usuario.');
    } else if (contrasenaInput.value.trim() === '') {
        alert('Por favor, ingresa tu contraseña.');
    } else {
        // Si ambos campos están llenos, enviar el formulario
        enviarFormulario(formulariosAJAX);
    }
});