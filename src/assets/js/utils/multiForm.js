import { clasesInputs, clasesInputsError } from "./inputs.js";

export function formulariomultiple(datos, alerta, contenido) {
  // Manejar el botón "Siguiente"
  $(document).on("click", datos, function () {
    const parentFieldset = $(this).closest("fieldset");
    const currentStep = $(".f1-step.active");
    const progressLine = $(".f1-progress-line");
    let nextStep = true;

    // Validar inputs dentro del fieldset actual
    //input, select, textarea
    parentFieldset.find("").each(function () {
      if (!$(this).hasClass("ignore-validation")) {
        if (!$(this).hasClass("cumplido") && !$(this).hasClass("cumplidoNormal")) {
          clasesInputsError($(this));
          $(alerta).empty().html(contenido).hide().slideDown("slow");

          setTimeout(() => {
            $(alerta).slideUp("slow");
          }, 10000);

          nextStep = false;
        } else {
          clasesInputs($(this));
        }
      }
    });

    // Si la validación es exitosa, avanzar al siguiente paso
    if (nextStep) {
      parentFieldset.fadeOut(400, function () {
        currentStep
          .removeClass("active")
          .addClass("activated")
          .next()
          .addClass("active");
        updateProgress(progressLine, "right");
        $(this).next().fadeIn(400);
        scrollToElement(".f1", 20);
      });
    }
  });

  // Manejar el botón "Atrás"
  $(document).on("click", ".btn-previous", function () {
    const parentFieldset = $(this).closest("fieldset");
    const currentStep = $(".f1-step.active");
    const progressLine = $(".f1-progress-line");

    parentFieldset.fadeOut(400, function () {
      currentStep
        .removeClass("active")
        .prev()
        .removeClass("activated")
        .addClass("active");
      updateProgress(progressLine, "left");
      $(this).prev().fadeIn(400);
      scrollToElement(".f1", 20);
    });
  });
}

// Función para actualizar la barra de progreso
function updateProgress(progressLine, direction) {
  const steps = progressLine.data("number-of-steps");
  const currentValue = progressLine.data("now-value");
  const newValue =
    direction === "right"
      ? currentValue + 100 / steps
      : currentValue - 100 / steps;

  progressLine.css("width", `${newValue}%`).data("now-value", newValue);
}

// Función para desplazarse a un elemento
function scrollToElement(element, offset) {
  const position = $(element).offset().top - offset;
  $("html, body").stop().animate({ scrollTop: position }, 400); // Desplazamiento en 400ms
}

// Inicialización del script
$(function () {
  // Ajustar el fondo al mostrar/ocultar el navbar
  $("#top-navbar-1").on("shown.bs.collapse hidden.bs.collapse", function () {
    $.backstretch("resize");
  });

  // Mostrar el primer fieldset con un efecto de deslizamiento
  $(".f1").hide().slideDown(1600); // Efecto de aparición en 600ms

  // Eliminar clase de error al enfocar un input
  $(".f1 input, .f1 textarea, .f1 select").on("focus", function () {
    $(this).removeClass("input-error");
  });
});