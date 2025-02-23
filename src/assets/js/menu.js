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

const contenedorNofi = document.querySelector('#contenNoti');
const subContenedorNofi = document.querySelector('#conten-notificaciones');

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


let interval = 5000; // Intervalo inicial (5 segundos)
let maxInterval = 60000; // Intervalo máximo (1 minuto)

async function getNotifications() {
  try {
    const response = await fetch('./src/ajax/notificacion.php?modulo_noti=obtenerNoti');
    const data = await response.json();

    if (data.error) {
      console.error('Error al obtener notificaciones:', data.error);
      return;
    }

    // Verifica si data es un array y tiene la estructura esperada
    if (Array.isArray(data) && data.length === 2 && Array.isArray(data[0]) && Array.isArray(data[1])) {
      const notificaciones = data[0];
      const conteo = data[1][0].contarNotificacion;

      $(subContenedorNofi).empty();
      let contadornoti = document.querySelector('#contadorNoti');
      let notificacionesHTML = '';

      if (conteo === 0) {
        contadornoti.textContent = '';
        notificacionesHTML += `
              <div class="conten-messenger-noti d-flex">
                  <div class="horafecha-nofi">
                      <div class="messengerNoti">No Tienes Ninguna Notificación</div>
                  </div>
              </div>
          `;
      } else {
        contadornoti.textContent = conteo;
        notificaciones.forEach((notificacion) => {
          notificacionesHTML += `
                  <div class="conten-messenger-noti d-flex">
                      <div class="contentImgNofi me-2"><img src="./src/global/archives/photos/30012937.png" alt="" class="imgNoti"></div>
                      <div class="horafecha-nofi">
                          <div class="messengerNoti">${notificacion.notificacion}</div>
                          <p class="me-2">${notificacion.fecha} ${notificacion.hora} </p> 
                      </div>
                  </div>
              `;
        });
      }

      $(subContenedorNofi).append(notificacionesHTML); // Agrega el HTML al contenedor
    } else {
      console.error('Error: La respuesta del servidor no es un array:', data);
    }

    // Ajustar intervalo
    if (data.length === 0) {
      interval = Math.min(interval * 2, maxInterval);
    } else {
      interval = 5000;
    }
  } catch (error) {
    console.error('Error de red:', error);
  }

  setTimeout(getNotifications, interval);
}

getNotifications();



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








