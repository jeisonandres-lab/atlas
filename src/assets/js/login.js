import { enviarFormulario } from "./ajax/formularioAjax.js";

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
async function generarHashContrasena(contrasena) {
  const salt = await CryptoJS.lib.WordArray.random(16);
  const hash = await CryptoJS.MD5(contrasena, salt, { keySize: 32/16 });
  const total= await salt.toString() + hash.toString();
  console.log(total);
  return total;
}

generarHashContrasena('hola');
function verificarContrasena(contrasena, hashAlmacenado) {
  const salt = CryptoJS.lib.WordArray.random(16);
  salt.words = CryptoJS.enc.Hex.parse(hashAlmacenado.substring(0, 32));
  const hashCalculado = CryptoJS.PBKDF2(contrasena, salt, { keySize: 32/16 });
  const total = hashCalculado.toString() === hashAlmacenado.substring(32);
    console.log(total);
    return total;
}

verificarContrasena('hola', 'MD5')