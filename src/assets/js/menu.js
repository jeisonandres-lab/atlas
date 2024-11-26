const body = document.querySelector("body");
const main = document.querySelector("main");
const footer = document.querySelector("footer");
const darkLight = document.querySelector("#darkLight");
const sidebar = document.querySelector(".sidebar");
const submenuItems = document.querySelectorAll(".submenu_item");

sidebar.addEventListener("mouseenter", () => {
  if (sidebar.classList.contains("hoverable")) {
    sidebar.classList.remove("close");
  }
});
sidebar.addEventListener("mouseleave", () => {
  if (sidebar.classList.contains("hoverable")) {
    sidebar.classList.add("close");
  }
});

darkLight.addEventListener("click", () => {
  body.classList.toggle("dark");
  main.classList.toggle("dark");
  footer.classList.toggle("dark");

  if (body.classList.contains("dark")) {
    document.setI
    darkLight.classList.replace("bx-sun", "bx-moon");
  } else {
    darkLight.classList.replace("bx-moon", "bx-sun");
  }
});

submenuItems.forEach((item, index) => {
  item.addEventListener("click", () => {
    item.classList.toggle("show_submenu");
    submenuItems.forEach((item2, index2) => {
      if (index !== index2) {
        item2.classList.remove("show_submenu");
      }
    });
  });
});

// SUB MENU DE LAS PAGINAS
function agregarClaseActive(ultimoSegmentoUrl) {
  // Buscamos el elemento con la clase contentos
  const contenedorContenidos = document.querySelector('.contentSubMenu');

  // Buscamos el elemento con el ID que coincide con el último segmento de la URL
  const elementoAActivar = contenedorContenidos.querySelector(`#${ultimoSegmentoUrl}`);

  // Si encontramos el elemento, le agregamos la clase active
  if (elementoAActivar) {
    elementoAActivar.classList.add('active');
  }
}

// Obtenemos el último segmento de la URL (como en tu código anterior)
let urlActual = window.location.pathname;
let partesUrl = urlActual.split('/');
let ultimaParte = partesUrl[partesUrl.length - 1];

// Llamamos a la función para agregar la clase active
agregarClaseActive(ultimaParte);


// MENU LATERAL DEL SISTEMA
function agregarClaseActive2(ultimoSegmentoUrl2) {
  // Buscamos el elemento con la clase contentos
  const contenedorContenidos = document.querySelector('.menu_content');

  // Buscamos el elemento con el ID que coincide con el último segmento de la URL
  const elementoAActivar = contenedorContenidos.querySelector(`.${ultimoSegmentoUrl2}`);

  // Si encontramos el elemento, le agregamos la clase active
  if (elementoAActivar) {
    elementoAActivar.classList.add('active');
  }
}

// Obtenemos el último segmento de la URL (como en tu código anterior)
let urlActual2 = window.location.pathname;
let partesUrl2 = urlActual2.split('/');
let ultimaParte2 = partesUrl2[partesUrl2.length - 1];

// Llamamos a la función para agregar la clase active
agregarClaseActive2(ultimaParte2);
