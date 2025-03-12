
import { alertaNormalmix, AlertSW2, aletaCheck } from "./ajax/alerts.js";
import { descargarArchivo, enviarFormulario, obtenerDatosJQuery, obtenerDatosPromise } from "./ajax/formularioAjax.js";
import {
  colocarMeses,
  colocarYear,
  valdiarCorreos,
  validarNombre,
  validarNumeros,
  validarSelectores,
  validarTelefono,
  file,
  limpiarInput,
  colocarNivelesEducativos,
  clasesInputs,
  incluirSelec2,
  validarSelectoresSelec2,
  validarNumerosMenores,
  validarNombreConEspacios,
  validarNumeroNumber,
  validarDosDatos,
  validarInputFecha,
  mesesDias,
  configurarInactividad,
} from "./ajax/inputs.js";

$(function () {

  $("#contenDoc").hide();
  $("#contentPartida").hide();

  validarSelectoresSelec2("#ano2", ".span_ano");
  validarSelectoresSelec2("#meses2", ".span_mes");
  validarSelectoresSelec2("#dia2", ".span_dia");

  file("#contrato", ".span_contrato");
  file("#notificacion", ".span_notificacion");
  colocarYear("#ano2", "1900");
  colocarMeses("#meses2");
  colocarNivelesEducativos("#academico");

  // Validar los campos del formulario de registro de familiares
  validarNombre("#primerNombreFamiliar", ".span_nombre1");
  validarNombre("#segundoNombreFamiliar", ".span_nombre2");
  validarNombre("#primerApellidoFamiliar", ".span_apellido1");
  validarNombre("#segundoApellidoFamiliar", ".span_apellido2");
  validarSelectores("#parentesco", ".span_parentesco");
  validarSelectores("#anoFamiliar", ".span_ano_familiar", "1");
  validarSelectores("#diaFamiliar", ".span_dia_familiar", "1");
  validarNumeros("#cedula_familiar", ".span_cedula_familiar");
  colocarMeses("#mesesFamiliar");
  colocarYear("#anoFamiliar", "1900");
  validarNumeros("#carnet", ".span_carnet");
  validarNumerosMenores("#tomo", ".span_tomo");
  validarNumerosMenores("#folio", ".span_folio");
  validarNumeros("#cedula_trabajador_familiar", ".span_cedula_empleado");
  file("#achivoparti", ".span_docArchivo");
  file("#achivoDis", ".span_docArchivoDis");

  mesesDias("#meses2", ".span_mes", "#dia2", "span_dia", "#ano2");

  const baseConfig = {
    responsive: true,
    ajax: {
      url: "./src/ajax/registroPersonal.php?modulo_personal=obtenerDatosFamiliarTotal",
      type: "POST",
      dataSrc: function (json) {
        // Verificar la estructura de los datos devueltos
        if (json.data) {
          return json.data; // Acceder al array de datos dentro de 'data'
        } else {
          console.error('Estructura de datos incorrecta:', json);
          return [];
        }
      }
    },
    processing: true,
    serverSide: true,
    info: false,
    order: [[0, 'desc']],
    paging: true,
    lengthMenu: [2, 10, 25],
    pageLength: 10,
    columnDefs: [
      {
        targets: 2,
        width: "8%",
        class: "text-center",
        render: function (data, type, row) {
          return data ? data : 'No Cédulado';
        }
      },
      {
        targets: 3,
        class: "text-center",
        render: function (data, type, row) {
          return data ? data : 'Sin Discapacidad';
        }
      },
      {
        targets: 4,
        width: "8%",
        class: "text-center",
        render: function (data, type, row) {
          return data + " Años";
        }
      },
      {
        targets: 5,
        class: "text-center",
        render: function (data, type, row) {
          return data ? data : 'Sin Tomo';
        }
      },
      {
        targets: 6,
        class: "text-center",
        render: function (data, type, row) {
          return data ? data : 'Sin Folio';
        }
      },

    ],
    language: {
      url: "./IdiomaEspañol.json"
    },
    columns: [
      { "data": 0 }, 
      { "data": 1 }, 
      { "data": 2 }, 
      { "data": 3 }, 
      { "data": 4 }, 
      { "data": 5 }, 
      { "data": 6 },
      { "data": 7 },
      { "data": 8 },
    ],
    layout: {
      topStart: {
        pageLength: {
          menu: [
            [10, 15, 30, -1], // Valores
            ['10', '15', '30', 'Todos'] // Etiquetas
          ],
        },

        buttons: [
          //   {
          //     extend: 'collection',
          //     text: 'ExportarPDF',
          //     className: 'excel btn buttonVerde p-2 pe-3 ps-3',
          //     split: [

          //         {
          //             text: 'copy',
          //             split: [
          //               {
          //                 extend: 'pdfHtml5', // Extensión para generar PDF
          //                 text: '<i class="bi bi-file-earmark-pdf-fill"></i>', // Texto del botón (con icono)
          //                 className: 'pdf btn buttonRojo p-2 pe-3 ps-3', // Clases CSS para el botón
          //                 titleAttr: 'Exportar a PDF', // Título al pasar el mouse por encima
          //                 // orientation: 'landscape',
          //                 // pageSize: 'LEGAL'
          //                 action: function (e, dt, node, config) {
          //                   descargarArchivo('./src/ajax/tablasDescargar.php?accion=impirimirEmpleados', 'DatosEmpleado.pdf');
          //                 }
          //               },
          //             ]
          //         },


          //     ]
          // },
          {
            extend: 'copyHtml5',
            text: '<i class="fa-solid fa-copy"></i>',
            className: 'copiar btn buttonAmarillo btn-hover-amarillo p-2 pe-3 ps-3',
            titleAttr: 'Copiar a portapapeles',
            exportOptions: {
              columns: ':not(:last)',
              modifier: {
                page: 'all'
              }
            },

          },
          {
            extend: 'excelHtml5',
            text: '<i class="fa-regular fa-table"></i>',
            className: 'excel btn buttonVerde btn-hover-verde p-2 pe-3 ps-3',
            titleAttr: 'Exportar a Excel',
            exportOptions: {
              columns: ':not(:last)',
              modifier: {
                search: 'none', // Ignorar el filtro de búsqueda
                order: 'applied', // Mantener el orden aplicado
                page: 'all' // Exportar todas las páginas
              }
            },
            excelStyles: [
              // Add an excelStyles definition
              {
                template: 'cyan_medium', // Apply the 'green_medium' template
              },
              {
                cells: 'sh', // Use Smart References (s) to target the header row (h)
                style: {
                  // Add a style block
                  font: {
                    // Style the font
                    size: 12, // Size 14
                    b: true, // Turn off the default bolding of the header
                  },
                  fill: {
                    // Style the fill/background
                    pattern: {
                      // Add a pattern (default type is solid)
                      color: '1929bb', // Define the color
                    },
                  },
                  alignment: {
                    horizontal: 'center', // Alineación centrada
                  },

                },
              },
              {
                cells: 1, // Use Smart References (s) to target the header row (h)
                style: {

                  fill: {
                    // Style the fill/background
                    pattern: {
                      // Add a pattern (default type is solid)
                      color: '1929bb', // Define the color
                    },
                  },
                  font: {
                    size: 14, // Tamaño de fuente
                    b: true, // Texto en negrita
                    color: 'FFFFFF', // Texto blanco
                  },
                },


              },
            ]
          },
          {
            extend: 'pdfHtml5', // Extensión para generar PDF
            text: '<i class="bi bi-file-earmark-pdf-fill"></i>', // Texto del botón (con icono)
            className: 'pdf btn buttonRojo btn-hover-rojo p-2 pe-3 ps-3', // Clases CSS para el botón
            titleAttr: 'Exportar a PDF', // Título al pasar el mouse por encima
            // orientation: 'landscape',
            // pageSize: 'LEGAL'
            action: async function (e, dt, node, config) {
              await descargarArchivo('./src/ajax/tablasDescargar.php?accion=impirimirFamiliar', 'DatosFamiliar.pdf');
            }
          },
          {
            extend: 'colvis',
            text: '<i class="fa-solid fa-eye me-2"></i>',
            className: ' btn buttonAzulClaro btn-hover-azul p-2 pe-3 ps-3',
            titleAttr: 'Mostrar/Ocultar Columnas',
            columns: ':not(:last)',

          },
        ],
      },
    },
  };


  let tableInic = $('#tableInic').DataTable(baseConfig);

  // funcion para editar familiar
  async function editarFamiliar(idPersonal) {
    let url = "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosFamiliar";
    let options = { id: idPersonal };
    try {
      const datosPersonal = await obtenerDatosPromise(url, options);

      if (datosPersonal.exito) {
        $("#idEmpleadoFamiliar").val(datosPersonal.idEmpleado);
        $("#cedula_trabajador_familiar").val(datosPersonal.cedulaEmpleado);
        $("#nombreEmpleado").val(datosPersonal.nombreEmpleado);
        $("#apellidoEmpleado").val(datosPersonal.apellidoEmpleado);

        $("#primerNombreFamiliar").val(datosPersonal.nombre);
        $("#segundoNombreFamiliar").val(datosPersonal.segundoNombre);
        $("#primerApellidoFamiliar").val(datosPersonal.apellido);
        $("#segundoApellidoFamiliar").val(datosPersonal.segundoApellido);
        $("#edad").val(datosPersonal.edad);
        $("#identificador").val(datosPersonal.idfamiliar);
        $('#parentesco').val(datosPersonal.parentesco).trigger('change');
        $('#anoFamiliar').val(datosPersonal.anoNacimiento).trigger('change');
        $('#diaFamiliar').val(datosPersonal.diaNacimineto).trigger('change');
        $('#mesesFamiliar').val(datosPersonal.mesNacimiento).trigger('change');

        $("#tomo").val(datosPersonal.tomo);
        $("#folio").val(datosPersonal.folio);

        $("#cedula_trabajador_familiar").addClass("cedulaBusqueda");
        clasesInputs("#nombreEmpleado", ".span_nombre");
        clasesInputs("#apellidoEmpleado", ".span_apellido");
        clasesInputs("#cedula_trabajador_familiar", ".span_cedula_empleado");
        clasesInputs("#primerNombreFamiliar", ".span_nombre1");
        clasesInputs("#segundoNombreFamiliar", ".span_nombre2");
        clasesInputs("#primerApellidoFamiliar", ".span_apellido1");
        clasesInputs("#segundoApellidoFamiliar", ".span_apellido2");
        clasesInputs("#parentesco", ".span_parentesco");
        clasesInputs("#edad", ".span_edad");
        clasesInputs("#anoFamiliar", ".span_ano_familiar");
        clasesInputs("#diaFamiliar", ".span_dia_familiar");
        clasesInputs("#tomo", ".span_tomo");
        clasesInputs("#folio", ".span_folio");
        clasesInputs("#carnet", ".span_carnet");
        clasesInputs("#cedula_familiar", ".span_cedula_familiar");
        $("#cedula_familiar").val(datosPersonal.cedula);

        $("#carnet").val(datosPersonal.codigoCarnet);
        // $("#noCedula").prop("checked", true);

        if (datosPersonal.codigoCarnet == null) {
          $("#disca").prop("checked", false);
          $("#contenCarnet").hide();
          $("#carnet").removeClass("cumplido");
          $(".span_carnet").removeClass("cumplido_span");

          $("#carnet").addClass("ignore-validation");
        } else {
          $("#contenCarnet").show();
          $("#carnet").addClass("cumplido");
          $(".span_carnet").addClass("cumplido_span");
          $("#carnet").removeClass("ignore-validation");
          $("#disca").prop("checked", true);
        }
        $('#editarDatos').removeAttr('hidden');
        // Animación de apertura
        $('#editarDatos').slideDown(500, function () {
          $('#editarDatos').animate({
            transform: 'scale(1)' // Escala final
          }, 350, function () {
            // Animación de desplazamiento después de la animación de apertura
            $('html, body').animate({
              scrollTop: $('#editarDatos')[0].scrollIntoView({ behavior: 'smooth' })
            }, 800);
          });
        });
      } else {
        console.error('Error al obtener datos personales o la estructura de la respuesta es incorrecta');
      }
    } catch (error) {
      console.error('Error al obtener los datos:', error.status, error.error);
    }
  }

  //funcion para eliminar familiar
  async function eliminarFamiliar(idPersonal) {
    let formData = new FormData();
    formData.append('id', idPersonal); // Añadir idPersonal al FormData

    // funcion de accion
    async function callbackExito(parsedData) {
      // Manejar la respuesta exitosa aquí
      tableInic.ajax.reload(null, false);
      await AlertSW2("success", "Empleado Eliminado Con exito", "top", 3000);
    }

    async function enviar() {
      let destino = "src/ajax/registroPersonal.php?modulo_personal=eliminarFamiliar";
      let url = destino;
      await enviarFormulario(url, formData, callbackExito, true);

    }
    // parametros para la alerta
    let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
    let icons = 'primary';
    let position = 'top-end';
    await aletaCheck(messenger, icons, position, enviar);
  }

  // Función para buscar datos
  async function buscarDatos() {
    const valor = $("#cedula_trabajador_familiar").val();
    if (valor.length >= 7) {
      async function callbackExito(parsedData) {
        if (parsedData.exito == true) {
          let nombre = parsedData.nombre;
          let apellido = parsedData.apellido;
          let idEmpleado = parsedData.idEmpleado;
          // si tiene marcado error
          $("#nombreEmpleado").removeClass("error_input");
          $("#apellidoEmpleado").removeClass("error_input");
          $(".span_nombre").removeClass("error_span");
          $(".span_apellido").removeClass("error_span");
          // se marcar cumplido logrado
          $("#cedula_trabajador_familiar").addClass("cedulaBusqueda");
          $("#nombreEmpleado").addClass("cumplido");
          $("#apellidoEmpleado").addClass("cumplido");
          $(".span_nombre").addClass("cumplido_span");
          $(".span_apellido").addClass("cumplido_span");
          $("#nombreEmpleado").val(nombre);
          $("#apellidoEmpleado").val(apellido);
          $("#idEmpleadoFamiliar").val(idEmpleado);
          await alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
        } else {
          $("#nombreEmpleado").val("");
          $("#apellidoEmpleado").val("");
          $("#nombreEmpleado").removeClass("cumplido");
          $("#apellidoEmpleado").removeClass("cumplido");
          $(".span_nombre").removeClass("cumplido_span");
          $(".span_apellido").removeClass("cumplido_span");
          await alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
        }
      }
      if ($(this).val().length >= 7) {
        const datoCedula = $(this).val();
        const formData = new FormData(); // Crea un nuevo objeto FormData
        formData.append('cedulaEmpleado', datoCedula);
        await enviarFormulario("src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal", formData, callbackExito, true);
      }
    }
  }

  async function descargarDocumento(doc) {
    const baseDir = './src/global/archives/personal/familiares/';
    const subDirs = ['partidasDiscapacidad', 'partidasNacimiento'];

    let found = false;
    let pendingRequests = subDirs.length;

    Swal.bindClickHandler();
    Swal.mixin({ toast: true }).bindClickHandler("data-swal-toast-template");

    $('#saveButton').on('click', function () {
      let cedula = $(this).data('cedula');
    });

    subDirs.forEach(subDir => {
      const filePath = `${baseDir}${subDir}/${doc}`;
      $.ajax({
        url: filePath,
        type: 'HEAD',
        beforeSend: async function () {
          await AlertSW2("info", "Descaregando imagen", "top");
        },
        success: async function () {

          setTimeout(async function () {
            Swal.close();
            await AlertSW2("success", "Foto Descargada con exito", "top", 4000);
            if (!found) {
              found = true;
              const link = document.createElement('a');
              link.target = "_blank";
              link.href = filePath;
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
            }
          }, 2000);
        },
        error: function () {
          pendingRequests--;
          if (pendingRequests === 0 && !found) {
            alert("No se consiguió el archivo: " + doc);
          }
        }
      });
    });
  }

  async function cerrarEditar(idCard){
    $(idCard).slideUp(600, function () {
      // Animación de desplazamiento al narvarPrincipal después del cierre
      $('html, body').animate({
        scrollTop: $('#narvarPrincipal')[0].scrollIntoView({ behavior: 'smooth' })
      }, 3000);
      // Aquí puedes agregar cualquier otra lógica que necesites después del cierre
    });

  }
  // Aplicar debounce a la función de búsqueda
  const buscarDatosDebounced = debounce(buscarDatos, 600);

  // Evento de input para el campo de búsqueda
  $("#cedula_trabajador_familiar").on("input", buscarDatosDebounced);

  //EVENTO PARA CAPTURAR EL ID PARA ELIMINAR EL FAMILIAR
  $(document).on('click', '.btnEliminar', async function () {
    let idPersonal = $(this).data('id');
    await eliminarFamiliar(idPersonal);
  });

  //EVENTO PARA CAPTURAR EL ID PARA EDITAR EL FAMILIAR
  $(document).on('click', '.btnEditarFamiliar', async function () {
    let idempleado = $(this).data('cedula');
    await editarFamiliar(idempleado);

  });

  //check no cedulado
  $("#noCedula").on("change", function () {
    if ($(this).is(":checked")) {
      $("#cedula").prop("disabled", true);
      $('#cedula_familiar').removeAttr('required');
      $("#cedula_familiar").val("");
      clasesInputs("#cedula_familiar", ".span_cedula")

    } else {
      $('#cedula_familiar').attr('required', 'required');
      $("#cedula_familiar").removeClass("cumplido");
      $(".span_cedula").removeClass("cumplido_span");
      $("#cedula").prop("disabled", false);
    }
  });

  //check de disca
  $("#disca").on("change", function () {
    if ($(this).is(":checked")) {
      $("#contenCarnet").show();
      $("#carnet").removeClass("ignore-validation");
    } else {
      $("#contenCarnet").hide();
      $("#carnet").addClass("ignore-validation");
    }
  });

  //EVETO PARA EVALUAR LOS DATOS DE LAS FECHA DE NACIMIENTO
  $(document).on("change", "#dia2, #meses2, #ano2", function () {
    const dia = $("#dia2").val();
    const mes = $("#meses2").val();
    const ano = $("#ano2").val();

    // Validar que los campos tengan contenido
    if (dia && mes && ano) {
      const fechaNacimiento = new Date(ano, mes - 1, dia);
      let calcularEdad2 = calcularEdad(fechaNacimiento);
      $("#edadEmp").val(calcularEdad2);
      clasesInputs("#edadEmp", ".span_edadEmp");
    } else {
      // Si algún campo está vacío, puedes hacer algo aquí (opcional)
      $("#edadEmp").val('0'); // Limpiar el campo edadEmp
      $("#edadEmp").removeClass("cumplido");
      $(".span_edadEmp").removeClass("cumplido_span");

      clasesInputs("#edadEmp", ".span_edadEmp"); // Actualizar clasesInputs
    }
  });

  // Carga de Partida de Nacimiento familiar
  $(document).on("click", "#cargaPartiNacimiento", function () {
    const $this = $(this);
    // Deshabilitar temporalmente el botón para evitar múltiples clics
    $this.prop("disabled", true);
    // Aplicar efecto de desvanecimiento al cambiar el contenido HTML
    $this.slideUp(300, function () {
      $this.html('<i class="fa-solid fa-xmark me-2"></i>Eliminar Partida').fadeIn(300);
    });
    $this.addClass("eliminar");
    $("#achivoparti").removeClass("ignore-validation");
    $("#achivoparti").empty();
    const $contentPartida = $("#contenDoc");
    // Verificar si el contenedor ya está visible
    if ($contentPartida.is(":visible")) {
      // Ocultar el contenedor si ya está visible
      $contentPartida.slideDown(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      });
    } else {
      // Mostrar el contenedor si no está visible
      $contentPartida.slideDown(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      });
    }
    // Cambiar el ID del contenedor
    $this.attr("id", "cargaPartiEliminar");
  });

  // Eliminar Partida de Nacimiento familiar
  $(document).on("click", "#cargaPartiEliminar", function () {
    const $this = $(this);
    // Deshabilitar temporalmente el botón para evitar múltiples clics
    $this.prop("disabled", true);
    // Aplicar efecto de desvanecimiento al cambiar el contenido HTML
    $this.slideUp(300, function () {
      $this.html('<i class="fa-solid fa-plus me-2"></i>Cargar Partida').fadeIn(300);
    });
    $this.removeClass("eliminar");
    $("#achivoparti").addClass("ignore-validation");
    $("#achivoparti").removeClass("cumplido");
    $("#achivoparti").val('');
    const $contentPartida = $("#contenDoc");
    // Verificar si el contenedor ya está visible
    if ($contentPartida.is(":visible")) {
      // Ocultar el contenedor si ya está visible
      $contentPartida.slideUp(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      });
    } else {
      // Mostrar el contenedor si no está visible
      $contentPartida.slideDown(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      });
    }
    // Cambiar el ID del contenedor
    $this.attr("id", "cargaPartiNacimiento");
  });

  // Carga de Partida de Nacimiento familiar
  $(document).on("click", "#cargaDiscapacidad", function () {
    const $this = $(this);
    // Deshabilitar temporalmente el botón para evitar múltiples clics
    $this.prop("disabled", true);
    // Aplicar efecto de desvanecimiento al cambiar el contenido HTML
    $this.slideUp(300, function () {
      $this.html('<i class="fa-solid fa-xmark me-2"></i>Eliminar Partida').fadeIn(300);
    });
    $this.addClass("eliminar");
    $("#achivoDis").removeClass("ignore-validation");
    const $contentPartida = $("#contentPartida");
    // Verificar si el contenedor ya está visible
    if ($contentPartida.is(":visible")) {
      // Ocultar el contenedor si ya está visible
      $contentPartida.slideDown(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      });
    } else {
      // Mostrar el contenedor si no está visible
      $contentPartida.slideDown(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      });
    }
    // Cambiar el ID del contenedor
    $this.attr("id", "cargaDiscaEliminar");
  });

  // Eliminar Partida de Nacimiento familiar
  $(document).on("click", "#cargaDiscaEliminar", function () {
    const $this = $(this);
    // Deshabilitar temporalmente el botón para evitar múltiples clics
    $this.prop("disabled", true);
    // Aplicar efecto de desvanecimiento al cambiar el contenido HTML
    $this.slideUp(300, function () {
      $this.html('<i class="fa-solid fa-plus me-2"></i>Cargar Partida').fadeIn(300);
    });
    $this.removeClass("eliminar");
    $("#achivoDis").addClass("ignore-validation");
    const $contentPartida = $("#contentPartida");
    // Verificar si el contenedor ya está visible
    if ($contentPartida.is(":visible")) {
      // Ocultar el contenedor si ya está visible
      $contentPartida.slideUp(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      });
    } else {
      // Mostrar el contenedor si no está visible
      $contentPartida.slideDown(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      });
    }
    // Cambiar el ID del contenedor
    $this.attr("id", "cargaPartiNacimiento");
  });

  // MESES DE FAMILIAR
  $("#mesesFamiliar").on("change", function () {
    const year = 2024; // Cambia el año si lo deseas
    const month = $("#mesesFamiliar").val();
    if (month == "") {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(".span_mes_familiar").removeClass("cumplido_span");
      $(".span_mes_familiar").addClass("error_span");

      $("#diaFamiliar").removeClass("cumplido");
      $("#diaFamiliar").addClass("error_input");
      $(".span_dia_familiar").removeClass("cumplido_span");
      $(".span_dia_familiar").addClass("error_span");
      $("#diaFamiliar").empty();
    } else {
      // Verificar si month no es null o undefined
      if (month) {
        // Eliminar el cero inicial si existe
        const monthWithoutLeadingZero = month.replace(/^0+/, "");
        // Obtener el número de días en el mes seleccionado
        const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate(); // Restamos 1 al mes porque JavaScript cuenta los meses desde 0
        // Generar las opciones de los días
        $("#diaFamiliar").empty();
        $("#diaFamiliar").removeClass("error_input");
        $("#diaFamiliar").addClass("cumplido");
        $(".span_dia_familiar").removeClass("error_span");
        $(".span_dia_familiar").addClass("cumplido_span");
        // Limpiar las opciones anteriores
        for (let i = 1; i <= daysInMonth; i++) {
          const diaFormateado = i.toString().padStart(2, "0");
          $("#diaFamiliar").append(
            '<option value="' + diaFormateado + '">' + diaFormateado + "</option>"
          );
        }
        $(this).removeClass("error_input");
        $(this).addClass("cumplido");
        $(".span_mes_familiar").removeClass("error_span");
        $(".span_mes_familiar").addClass("cumplido_span");
      } else {
        console.error("El valor de month es null o undefined");
      }
    }
  });

  // VALIDAR EL ANO DEL FAMILIAR 
  $(document).on("input", "ano2", async function () {
    const opcionSeleccionada = $(this).val();
    if (opcionSeleccionada === "") {
      $("#meses2").removeClass("cumplido");
      $("#meses2").addClass("error_input");
      $(".span_mes").removeClass("cumplido_span");
      $(".span_mes").addClass("error_span");

      $("#dia2").removeClass("cumplido");
      $("#dia2").addClass("error_input");
      $(".span_dia").removeClass("cumplido_span");
      $(".span_dia").addClass("error_span");
      $("#meses2").empty();
      $("#dia2").empty();
    } else {
      await colocarMeses("#meses2");
    }
  });

  //Descargar Documentos
  $(document).on('click', '.botondocumet', function () {
    let doc = $(this).data('doc');
    descargarDocumento(doc);
  });

  //ACTULIZAR FAMILIAR
  $(document).on("submit", "#formularioActualizar", async function (event) {
    const form = document.getElementById('formularioActualizar');
    event.preventDefault();
    const data = new FormData(form);
    const url = "src/ajax/registroPersonal.php?modulo_personal=actualizarFamiliar";
    $("#aceptar_familia").prop("disabled", true);

    async function callbackExito(parsedData) {
      $("#aceptar_familia").prop("disabled", false);
      if (parsedData.exito) {
        tableInic.ajax.reload(null, false);
        await AlertSW2("success", "Familiar Actualizado Con Exito", "top-end", 3000);
        cerrarEditar("#editarDatos");
      } else {
        await alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end")
      }
    }
    await enviarFormulario(url, data, callbackExito, true);
  });

  // cerrar el card de reporte
  $(document).on('click', '#cerrarReport', function () {
    $('#datosReporte').slideUp(800, function () {

      // Animación de desplazamiento al narvarPrincipal después del cierre
      $('html, body').animate({
        scrollTop: $('#narvarPrincipal')[0].scrollIntoView({ behavior: 'smooth' })
      }, 3000);
      $("#contentReport").remove();

      // Aquí puedes agregar cualquier otra lógica que necesites después del cierre
    });
  });

  $(document).on('click', '#cerrarEdit', function () {
    cerrarEditar("#editarDatos")
    // limpiarDatos();
  });
  
  function todosCumplidos(formulario) {
    const elementosCumplidos = $(formulario).find('input, select').filter('.cumplido, .cumplidoNormal').not('.ignore-validation');
    const totalElementos = $(formulario).find('input, select').not('.ignore-validation').length;
    return elementosCumplidos.length === totalElementos;
  }

  // Función para habilitar o deshabilitar el botón
  function habilitarBoton(formulario, boton) {
    boton.prop('disabled', !todosCumplidos(formulario));
  }

  // Función de debounce para limitar la frecuencia de ejecución
  function debounce(func, wait) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }

  // Crear una instancia de MutationObserver y observar cambios en un formulario específico
  function observarFormulario(formulario, boton) {
    const observer = new MutationObserver(debounce((mutationsList, observer) => {
      for (const mutation of mutationsList) {
        if (mutation.type === 'childList' || mutation.type === 'attributes') {
          habilitarBoton(formulario, boton);

        }
      }
    }, 300)); // Ajusta el tiempo de espera según sea necesario

    // Configurar el observer para observar cambios en los hijos y atributos del formulario
    const config = { childList: true, attributes: true, subtree: true };

    // Comenzar a observar el formulario
    observer.observe(formulario, config);
  }

  const forActualizarFamiliar = document.querySelector('#formularioActualizar');
  const aceptar_familia = $('#aceptar_familia');

  const formDescargarPDF = document.querySelector('#formulario-descargarpdf');
  const descargarpdf = $('#descargarReporte');


  observarFormulario(forActualizarFamiliar, aceptar_familia);

  habilitarBoton(forActualizarFamiliar, aceptar_familia);


})
