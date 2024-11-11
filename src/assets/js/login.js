import { enviarDatos, enviarFormulario, generarHashContrasena, verificarContrasena } from "./ajax/formularioAjax.js";

let formulariosAJAX=document.querySelector(".formularioEnviar");
let cerradura = document.getElementById("candado");
let inputPassword = document.querySelector("#password");
let inputPassword2 = document.querySelector(".password");

//cambio de icono
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

//verificar si los inputs tienen datos 
formulariosAJAX.addEventListener('submit', (e) => {
    e.preventDefault();
    // Obtener los elementos del formulario
    let usuarioInput = document.getElementById('usuario');
    let contrasenaInput = document.getElementById('password');
    let passwordSinEncrip = contrasenaInput.value;
    // Validar los campos
   
    if (usuarioInput.value.trim() === '' && contrasenaInput.value.trim() === '') {
        alert('Por favor, llena todos los campos.');
    } else if (usuarioInput.value.trim() === '') {
        alert('Por favor, ingresa tu nombre de usuario.');
    } else if (contrasenaInput.value.trim() === '') {
        alert('Por favor, ingresa tu contraseña.');
    } else {
      let contrseñatring = contrasenaInput.toString();
      let contraseñaEncrip = generarHashContrasena(contrseñatring);
      contrasenaInput.value = contraseñaEncrip;
      const cargando = document.getElementById('cargando');
      cargando.style.display = 'flex';
      
      function callbackExito(parsedData){
        let hashAlmacenado =parsedData.password;
        const esValida = verificarContrasena(passwordSinEncrip, hashAlmacenado);
        if (esValida === true) {
          let formData = new FormData();
          formData.append('url', 'inicio?usuario='+ parsedData.usuario);
          const url = "http://localhost/atlas/src/ajax/userAjax.php?modulo_usuario=redireccionar";
          enviarDatos(url, formData)
        } else {
          console.log("la contraseña no es correcta");
        }
      }
      let url = "http://localhost/atlas/src/ajax/userAjax.php?modulo_usuario=login";
      const data = new FormData(formulariosAJAX);
      data.append('modulo_usuario', 'login');
      enviarFormulario(url,data,callbackExito);
      contrasenaInput.value = passwordSinEncrip;
    }
});
