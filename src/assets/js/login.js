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