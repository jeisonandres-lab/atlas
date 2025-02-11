import { enviarDatos } from "./ajax/formularioAjax.js";

const body = document.querySelector("body");
const main = document.querySelector("main");
const footer = document.querySelector("footer");
const darkLight = document.querySelector("#darkLight");
const sidebar = document.querySelector(".sidebar");
const submenuItems = document.querySelectorAll(".submenu_item");
const cerrarSession = document.querySelector("#cerrarSession");


const buscador = document.getElementById('buscador');
const resultadosBusqueda = document.getElementById('resultadosBusqueda');

buscador.addEventListener('input', () => {
  const textoBusqueda = buscador.value.toLowerCase();
  const elementosMenuItems = document.querySelectorAll('.menu_items');
  const resultados = [];

  // Verificar si el campo de búsqueda está vacío
  if (textoBusqueda.trim() === '') {
    ocultarResultados(); // Ocultar si está vacío
    return; // Salir de la función
  }

  elementosMenuItems.forEach(elementoMenuItem => {
    const menuTitleElement = elementoMenuItem.querySelector('.menu_title');
    if (menuTitleElement) {
      const tituloApartado = window.getComputedStyle(menuTitleElement, '::before').content.replace(/"/g, '');
      const elementosNavLink = elementoMenuItem.querySelectorAll('.navlink');

      elementosNavLink.forEach(elementoNavLink => {
        const textoElemento = elementoNavLink.textContent.toLowerCase();

        if (textoElemento.includes(textoBusqueda)) {
          // Buscar el href en el elemento más cercano con la clase 'item'
          const itemElement = elementoNavLink.closest('.item');
          let href = '';
          if (itemElement) {
            const linkElement = itemElement.querySelector('a');
            if (linkElement) {
              href = linkElement.getAttribute('href');
            }
          }

          resultados.push({
            texto: tituloApartado,
            titulo: elementoNavLink.textContent,
            href: href
          });
        }
      });
    }
  });

  if (resultados.length > 0) {
    mostrarResultados(resultados);
  } else {
    ocultarResultados();
  }
});

function mostrarResultados(resultados) {
  const listaResultados = document.createElement('ul');
  resultados.forEach(resultado => {
    const itemResultado = document.createElement('li');
    itemResultado.innerHTML = `<a href="${resultado.href}"><strong>${resultado.texto}</strong> <span class="subtitulo">${resultado.titulo}</span></a>`;
    listaResultados.appendChild(itemResultado);
  });

  resultadosBusqueda.innerHTML = '';
  resultadosBusqueda.appendChild(listaResultados);
  resultadosBusqueda.style.display = 'block';
}

function ocultarResultados() {
  resultadosBusqueda.style.display = 'none';
}



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

cerrarSession.addEventListener("click", () => {
  const url = "./src/ajax/userAjax.php?modulo_usuario=cerrarSession";
  let formData = new FormData();
  formData.append('url', `Identificarse`);
  enviarDatos(url, formData);
});
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
