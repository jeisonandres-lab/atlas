
import {
  colocarMeses,
  colocarYear,
  valdiarCorreos,
  validarBusquedaCedula,
  validarNombre,
  validarNumeros,
  validarSelectores,
  validarTelefono,
  file,
  limpiarInput,
  validarSelectoresSelec2,
  incluirSelec2,
  clasesInputsError,
  validarDosDatos,
  validarNombreConEspacios,
  validarNumeroNumber,
} from "./ajax/inputs.js";

import {
  enviarFormulario,
  obtenerDatos,
  obtenerDatosJQuery
} from "./ajax/formularioAjax.js";

import {
  alertaNormalmix,
} from "./ajax/alerts.js";


// jQuery
$(function () {
  $(".formulario_empleado").hide();

  const cargando = document.getElementById('cargando');

  // formulario de registro
  validarNombre("#primerNombre", ".span_nombre");
  validarNombre("#segundoNombre", ".span_nombre2");
  validarNombre("#primerApellido", ".span_apellido");
  validarNombre("#segundoApellido", ".span_apellido2");
  validarNombreConEspacios("#calle", ".span_calle");
  validarNombreConEspacios("#urbanizacion", ".span_urbanizacion");
  validarNumeros("#cedula", ".span_cedula");
  validarNumeroNumber("#piso", ".span_piso", 2);
  validarNumeroNumber("#numeroVivienda", ".span_numeroVivienda", 3);
  validarBusquedaCedula("#cedula", ["#img-modals", "#img-contener"]);
  valdiarCorreos("#correo", ".span_correo");
  colocarYear("#ano", "1900");
  colocarMeses("#meses");
  validarTelefono("#telefono", ".span_telefono", "#linea");
  validarSelectores("#civil", ".span_civil");
  validarSelectores("#ano", ".span_ano", "1");
  validarSelectores("#dia", ".span_dia", "1");
  file("#contrato", ".span_contrato");
  file("#notificacion", ".span_notificacion");

  validarSelectores("#estado", ".span_estado");
  validarSelectores("#municipio", ".span_municipio");
  validarSelectores("#parroquia", ".span_parroquia");
  validarSelectores("#vivienda", ".span_vivienda");
  validarSelectores("#sexo", ".span_sexo");
  // formulario de empleados por select 2
  incluirSelec2("#estatus");
  incluirSelec2("#cargo");
  incluirSelec2("#departamento");
  incluirSelec2("#dependencia");
  incluirSelec2("#academico");
  incluirSelec2("#sexo");
  incluirSelec2("#estado");
  incluirSelec2("#municipio");
  incluirSelec2("#parroquia");
  incluirSelec2("#vivienda");
  incluirSelec2("#meses");
  incluirSelec2("#dia");

  validarSelectoresSelec2("#dependencia", ".span_dependencia");
  validarSelectoresSelec2("#estatus", ".span_estatus");
  validarSelectoresSelec2("#cargo", ".span_cargo");
  validarSelectoresSelec2("#departamento", ".span_departamento");
  validarSelectoresSelec2("#dependencia", ".span_dependencia");
  validarSelectoresSelec2("#academico", ".span_academico");
  validarSelectoresSelec2("#sexo", ".span_sexo");
  validarSelectoresSelec2("#estado", ".span_estado");
  validarSelectoresSelec2("#municipio", ".span_municipio");
  validarSelectoresSelec2("#parroquia", ".span_parroquia");
  validarSelectoresSelec2("#vivienda", ".span_vivienda");
  validarSelectoresSelec2("#meses", ".span_meses");

  validarDosDatos("#numeroDepa", ".span_numeroDepa");
  // URLs para las consultas
  const urls = [
    "src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias",
    "src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus",
    "src/ajax/registroPersonal.php?modulo_personal=obtenerCargo",
    "src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento",
    "src/ajax/registroPersonal.php?modulo_personal=obtenerEstados"
  ];

  // Función para realizar las consultas y llenar los selectores
  async function realizarConsultas() {
    try {
      const [dependencias, estatus, cargo, departamento, estado] = await Promise.all(urls.map(url => obtenerDatosJQuery(url)));

      if (dependencias && dependencias.exito && dependencias.data) {
        llenarSelectDependencias(dependencias.data, 'dependencia');
      } else {
        console.error('Error al obtener dependencias o la estructura de la respuesta es incorrecta');
      }

      if (estatus && estatus.exito && estatus.data) {
        llenarSelectDependencias(estatus.data, 'estatus');
      } else {
        console.error('Error al obtener los estatus o la estructura de la respuesta es incorrecta');
      }

      if (cargo && cargo.exito && cargo.data) {
        llenarSelectDependencias(cargo.data, 'cargo');
      } else {
        console.error('Error al obtener los cargos o la estructura de la respuesta es incorrecta');
      }

      if (departamento && departamento.exito && departamento.data) {
        llenarSelectDependencias(departamento.data, 'departamento');
      } else {
        console.error('Error al obtener departamento o la estructura de la respuesta es incorrecta');
      }

      if (estado && estado.exito && estado.data) {
        llenarSelectDependencias(estado.data, 'estado');
      } else {
        console.error('Error al obtener departamento o la estructura de la respuesta es incorrecta');
      }
    } catch (error) {
      console.error('Error al realizar las consultas:', error);
    }
  }

  // Llamar a la función para realizar las consultas
  realizarConsultas();


  async function llenarSelectDependencias(data, selectId) {
    const select = document.getElementById(selectId);
    // Asegúrate de que el ID del select sea correcto
    if (!select) {
      console.error(`El elemento select con el ID "${selectId}" no se encontró en el DOM.`);
      return;
    }

    data.forEach(item => {
      const option = document.createElement('option');
      option.value = item.id;
      option.text = item.value;
      select.appendChild(option);
    });
  }


  $("#meses").on("change", function (yearnull) {
    const year = $("#ano").val();
    const month = $("#meses").val();
    if (month == "") {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(".span_mes").removeClass("cumplido_span");
      $(".span_mes").addClass("error_span");
    } else {
      // Eliminar el cero inicial si existe
      const monthWithoutLeadingZero = month.replace(/^0+/, "");
      // Obtener el número de días en el mes seleccionado
      const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate(); // Restamos 1 al mes porque JavaScript cuenta los meses desde 0
      // Generar las opciones de los días
      $("#dia").empty(); // Limpiar las opciones anteriores
      $("#dia").append(
        '<option value="">Seleccione un dia</option>'
      );

      $(".span_dia").removeClass("cumplido_span");
      $("#contentDia .select2").removeClass("cumplido");
      for (let i = 1; i <= daysInMonth; i++) {
        const diaFormateado = i.toString().padStart(2, "0");
        $("#dia").append(
          '<option value="' + diaFormateado + '">' + diaFormateado + "</option>"
        );
      }
      $(this).removeClass("error_input");
      $(this).addClass("cumplido");
      $(".span_mes").removeClass("error_span");
      $(".span_mes").addClass("cumplido_span");
    }
  });

  $("#meses").trigger("input");

  $("#formulario_registro").on("submit", function (e) {
    e.preventDefault();
    const data = new FormData(this);
    const url = "src/ajax/registroPersonal.php?modulo_personal=registrar";
    $("#aceptar").prop("disabled", true);

    function callbackExito(parsedData) {
      let dataerror = parsedData.error;
      $("#aceptar").prop("disabled", false);
      console.log(parsedData);
      if (parsedData.personalEncontrado) {
        $("#alerta").slideDown('slow', 'swing').delay(10000).slideUp();
      }
      else if (dataerror) {
        alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end")
      } else {
        alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end")
      }
      // const myModal = new bootstrap.Modal(document.getElementById('modal'));
      // myModal.show();
    }
    enviarFormulario(url, data, callbackExito, true);
  });

  $("#noCedula").on("change", function () {
    if ($(this).is(":checked")) {
      $("#disca").prop("checked", false);
    }
  });

  $("#disca").on("change", function () {
    if ($(this).is(":checked")) {
      $("#noCedula").prop("checked", false);
    }
  });

  $("#estado").on("change", async function () {
    const idEstado = $(this).val();
    try {
      if (idEstado !== undefined) {
        try {
          let urls = ["src/ajax/registroPersonal.php?modulo_personal=obtenerMunicipio"];
          let options = { idestado: idEstado };
          let requests = urls.map((url, index) => {
            if (index === 0) { // Suponiendo que quieres pasar `options` solo a la primera solicitud
              return obtenerDatosJQuery(url, options);
            }
          });

          const [municipio] = await Promise.all(requests);

          if (municipio.exito) {
            $("#municipio").empty()
            $("#municipio").append('<option value="">Seleccione un municipio</option>');
            llenarSelectDependencias(municipio.data, 'municipio');
          } else {
            console.error('Error al obtener estado o la estructura de la respuesta es incorrecta');
          }
        } catch (error) {
          console.error('Error al obtener los datos de la estado:', error);
        }
      } else {
        console.error('El idestado es undefined');
      }
    } catch (error) {
      console.error('Error al manejar el evento de clic:', error);
    }
  });

  $("#municipio").on("change", async function () {
    const idmunicipio = $(this).val();
    try {
      if (idmunicipio !== undefined) {
        try {
          let urls = ["src/ajax/registroPersonal.php?modulo_personal=obtenerParroquia",];
          let options = { idmunicipio: idmunicipio };
          let requests = urls.map((url, index) => {
            if (index === 0) { // Suponiendo que quieres pasar `options` solo a la primera solicitud
              return obtenerDatosJQuery(url, options);
            }
          });

          const [parroquia] = await Promise.all(requests);

          if (parroquia.exito) {
            $("#parroquia").empty()
            $("#parroquia").append('<option value="">Seleccione una parroquia</option>');
            llenarSelectDependencias(parroquia.data, 'parroquia');
          } else {
            console.error('Error al obtener parroquias o la estructura de la respuesta es incorrecta');
          }
        } catch (error) {
          console.error('Error al obtener los datos de la parroquia:', error);
        }
      } else {
        console.error('El idparroquia es undefined');
      }
    } catch (error) {
      console.error('Error al manejar el evento de clic:', error);
    }
  });

  $("#vivienda").on("change", async function () {
    let vivienda = $(this).val();
    if (vivienda == 'Departamento') {
      // Crea el HTML que quieres insertar
      let nuevoHTML = `
            <div class="col-sm-6 col-md-6 mb-2" id="contenPiso">
                <div class="form-group">
                    <label for="piso">N.Piso</label>
                    <div class="input-group">
                        <span class="input-group-text span_piso"><i class="icons fa-regular fa-user"></i></span>
                        <input type="number" class="form-control" id="piso" name="piso" placeholder="Numero de piso" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 mb-2" id="contenNombreDepa">
                <div class="form-group">
                    <label for="urbanizacion">Nombre de la urbanización</label>
                    <div class="input-group">
                        <span class="input-group-text span_urbanizacion"><i class="icons fa-regular fa-user"></i></span>
                        <input type="text" class="form-control" id="urbanizacion" name="urbanizacion" placeholder="Nombre de la urbanizacion" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 mb-2" id="contenNumDepa">
                <div class="form-group">
                    <label for="numeroDepa">Numero del departamento</label>
                    <div class="input-group">
                        <span class="input-group-text span_numeroDepa"><i class="icons fa-regular fa-user"></i></span>
                        <input type="text" class="form-control" id="numeroDepa" name="numeroDepa" placeholder="Numero del departamento" required>
                    </div>
                </div>
            </div>
        `;

      // Inserta el HTML después del elemento con ID "contenCalle"
      $("#contenCalle").after(nuevoHTML);
    } else {
      // Si el valor del select no es "Departamento", elimina el HTML adicional (si existe)
      $("#contenPiso").remove();
      $("#contenNombreDepa").remove();
      $("#contenNumDepa").remove();

    }

    $(document).on('input', '#numeroDepa', function () {
      let inputValue = $(this).val();

      // Limita la longitud a 2 caracteres
      if (inputValue.length > 2) {
        $(this).val(inputValue.slice(0, 2));
        inputValue = $(this).val();
      }

      // Convierte letras a mayúsculas
      $(this).val(inputValue.toUpperCase());
    });


    if (vivienda == 'Casa') {
      // Crea el HTML que quieres insertar
      let nuevoHTML = `
            <div class="col-sm-6 col-md-6 mb-2" id="contenNVivienda">
                <div class="form-group">
                    <label for="numeroVivienda">N.Vivienda</label>
                    <div class="input-group">
                        <span class="input-group-text span_numeroVivienda"><i class="icons fa-regular fa-user"></i></span>
                        <input type="number" class="form-control" id="numeroVivienda" name="numeroVivienda" placeholder="Numero Vivienda" required>
                    </div>
                </div>
            </div>
        `;

      // Inserta el HTML después del elemento con ID "contenCalle"
      $("#contenCalle").after(nuevoHTML);
    } else {
      // Si el valor del select no es "Departamento", elimina el HTML adicional (si existe)
      $("#contenNVivienda").remove();
    }
  });

  var boton = $('#aceptar'); // Reemplaza con el ID de tu botón
  // metodos para escuchar cambios en el dom y habilitar el boton de enviar formulario 
  // Función para verificar si todos los campos están cumplidos
  function todosCumplidos() {
    const elementosCumplidos = $('form input, form select').filter('.cumplido, .cumplidoNormal, .cumplido_segundario');
    return elementosCumplidos.length === $('form input, form select').length;
  }

  // Función para habilitar o deshabilitar el botón
  function habilitarBoton() {
    boton.prop('disabled', !todosCumplidos());
  }

  // Función de debounce para limitar la frecuencia de ejecución
  function debounce(func, wait) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }

  // Crear una instancia de MutationObserver y observar cambios
  const observer = new MutationObserver(debounce((mutationsList, observer) => {
    for (const mutation of mutationsList) {
      if (mutation.type === 'childList' || mutation.type === 'attributes') {
        habilitarBoton();
        validarSelectoresSelec2("#dia", ".span_dia");
      }
    }
  }, 300)); // Ajusta el tiempo de espera según sea necesario

  // Configurar el observer para observar cambios en los hijos y atributos del formulario
  const config = { childList: true, attributes: true, subtree: true };

  // Seleccionar el formulario y comenzar a observar
  const form = document.querySelector('form');
  observer.observe(form, config);


  $("#limpiar").on("click", function () {
    limpiarInput("#primerNombre", ".span_nombre");
    limpiarInput("#segundoNombre", ".span_nombre2");
    limpiarInput("#primerApellido", ".span_apellido");
    limpiarInput("#segundoApellido", ".span_apellido2");
    limpiarInput("#cedula", ".span_cedula");
    limpiarInput("#civil", ".span_civil");
    limpiarInput("#ano", ".span_ano");
    limpiarInput("#meses", ".span_mes");
    limpiarInput("#dia", ".span_dia");
    limpiarInput("#contrato", ".span_contrato");
    limpiarInput("#notificacion", ".span_notificacion");
    limpiarInput("#telefono", ".span_telefono");
    limpiarInput("#estatus", ".span_estatus");
    limpiarInput("#cargo", ".span_cargo");
    limpiarInput("#departamento", ".span_departamento");
    limpiarInput("#dependencia", ".span_dependencia");
    limpiarInput("#academico", ".span_academico");
    $(".imgFoto").remove();
  });



});