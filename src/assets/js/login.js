import { enviarFormulario, enviarFormularioUsuarios, generarHashContrasena, verificarContrasena } from "./ajax/formularioAjax.js";

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
        // Si ambos campos están llenos, enviar el formulario
      let contrseñatring = contrasenaInput.toString();
      let contraseñaEncrip = generarHashContrasena(contrseñatring);
      contrasenaInput.value = contraseñaEncrip;
      const cargando = document.getElementById('cargando');
      cargando.style.display = 'flex';
      
      function callbackExito(parsedData){
        // let hashAlmacenado = data.password;
        // let id = data.id;
        // let usuario = data.usuario;
        // let metodoAcceso = "inicioSesion";
        // const esValida = verificarContrasena(passwordSinEncrip, hashAlmacenado);
        // let formData = new FormData();
        // formData.append('hash', hashAlmacenado);
        // formData.append('id', id);
        // formData.append('usuario', usuario);
        // formData.append('modulo_usuario', metodoAcceso);
        let hashAlmacenado =parsedData.password;
        let id =parsedData.id;
        let usuario =parsedData.usuario;
        let metodoAcceso = "inicioSesion";
        let formData = new FormData();
        formData.append('hash', hashAlmacenado);
        formData.append('id', id);
        formData.append('usuario', usuario);
        formData.append('modulo_usuario', metodoAcceso);
        $.ajax({
          type: "POST",
          url: "http://localhost/atlas/src/ajax/userAjax.php",
          data: formData ,
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
              console.log(response);
          },
          error: function(jqXHR, textStatus, errorThrown)   
       {
              console.error("Error:", textStatus, errorThrown);   
      
          }
      });
        
      }
      let url = "http://localhost/atlas/src/ajax/userAjax.php";
      const data = new FormData(formulariosAJAX);
      enviarFormulario(url,data,callbackExito);
      //enviarFormularioUsuarios(formulariosAJAX, contraseñaEncrip, collback);
      contrasenaInput.value = passwordSinEncrip;

      
    }
});
