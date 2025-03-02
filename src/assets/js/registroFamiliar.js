import { alertaNormalmix, AlertSW2, aletaCheck } from "./ajax/alerts.js";
import { descargarArchivo, enviarFormulario, obtenerDatos, obtenerDatosPromise } from "./ajax/formularioAjax.js";
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
} from "./ajax/inputs.js";

$(function () {
  $("#contenTomo").hide();
  $("#contenFolio").hide();
  $("#contenCarnet").hide();
  $("#contenDoc").hide();
  $("#contentPartida").hide();

  validarNombre("#primerNombre", ".span_nombre");
  validarNombre("#segundoNombre", ".span_nombre2");
  validarNombre("#primerApellido", ".span_apellido");
  validarNombre("#segundoApellido", ".span_apellido2");
  validarNumeros("#cedulaEdi", ".span_cedula");
  validarSelectores("#civil", ".span_civil");
  validarSelectores("#ano2", ".span_ano", "1");
  validarSelectores("#dia2", ".span_dia", "1");
  valdiarCorreos("#correo", ".span_correo");
  validarTelefono("#telefono", ".span_telefono");
  incluirSelec2("#estatus");
  incluirSelec2("#cargo");
  incluirSelec2("#departamento");
  incluirSelec2("#dependencia");
  incluirSelec2("#academico");
  validarSelectoresSelec2("#dependencia", ".span_dependencia");
  validarSelectoresSelec2("#estatus", ".span_estatus");
  validarSelectoresSelec2("#cargo", ".span_cargo");
  validarSelectoresSelec2("#departamento", ".span_departamento");
  validarSelectoresSelec2("#dependencia", ".span_dependencia");
  validarSelectoresSelec2("#academico", ".span_academico");

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

  const cargando = document.getElementById('cargando');
  var boton = $('#aceptarFamilia');

  window.addEventListener('load', function () {
    // Initialize your data table here
    let table = new DataTable('#myTable', {
      responsive: true,
      ajax: {
        url: "./src/ajax/registroPersonal.php?modulo_personal=obtenerPersonal",
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

      processing: false,
      serverSide: true,
      deferRender: true,
      scrollX: true,
      scrollCollapse: true,
      info: false,
      order: [[0, 'desc']],
      paging: true,
      columnDefs: [
        {
          targets: 0,
          width: "100px",
        },
        {
          targets: 5,
          render: function (data, type, row) {
            return `<small class='d-inline-flex px-2 py-1 fw-semibold text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-2'>${data}</small>`;
          }
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return `<small class='d-inline-flex px-2 py-1 fw-semibold text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2'>${data}</small>`;
          }
        },
        {
          targets: 7,
          render: function (data, type, row) {
            return `<small class='d-inline-flex px-2 py-1 fw-semibold text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2'>${data}</small>`;
          }
        },

        {
          targets: 8,
          render: function (data, type, row) {
            return `<small class='d-inline-flex px-2 py-1 fw-semibold text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2'>${data}</small>`;
          }
        },

        {
          targets: 9,
          render: function (data, type, row) {
            return `<small class='d-inline-flex px-2 py-1 fw-semibold text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2'>${data}</small>`;
          }
        },

        {
          targets: 10,
          render: function (data, type, row) {
            return `<small class='d-inline-flex px-2 py-1 fw-semibold text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2'>${data}</small>`;
          }
        },

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
              className: 'copiar btn buttonAmarillo p-2 pe-3 ps-3',
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
              className: 'excel btn buttonVerde p-2 pe-3 ps-3',
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
              className: 'pdf btn buttonRojo p-2 pe-3 ps-3', // Clases CSS para el botón
              titleAttr: 'Exportar a PDF', // Título al pasar el mouse por encima
              // orientation: 'landscape',
              // pageSize: 'LEGAL'
              action: function (e, dt, node, config) {
                descargarArchivo('./src/ajax/tablasDescargar.php?accion=impirimirEmpleados', 'DatosEmpleado.pdf');
              }
            },
            {
              extend: 'colvis',
              text: '<i class="fa-solid fa-eye me-2"></i>',
              className: ' btn buttonAzulClaro p-2 pe-3 ps-3',
              titleAttr: 'Mostrar/Ocultar Columnas',
              columns: ':not(:last)',

            },
          ],
        },
      },
      language: {
        url: "./IdiomaEspañol.json"
      },
      columns: [
        { "data": 3 }, // Cédula
        { "data": 0 }, // Nombre Y Apellido
        { "data": 1 }, // Nombre Y Apellido 2
        { "data": 2 }, // Dia de nacimiento
        { "data": 4 }, // estado civil
        { "data": 9 }, // nivel Academico
        { "data": 10 },  // Acciones O Botones
        { "data": 5 },  // estatus
        { "data": 7 },  // dependencia
        { "data": 6 },  // cargo
        { "data": 8 },  // depeartamento
        { "data": 11 },  // fecha ingreso
        { "data": 12 },  // botones


      ]
    });

  });

  // $('#myTable tbody').on('click', 'tr', function () {
  //   var data = table.row(this).data();

  //   console.log('You clicked on ' + data[0] + "'s row");
  // });

  function limpiarDatos() {
    limpiarInput("#primerNombre", ".span_nombre");
    limpiarInput("#segundoNombre", ".span_nombre2");
    limpiarInput("#primerApellido", ".span_apellido");
    limpiarInput("#segundoApellido", ".span_apellido2");
    limpiarInput("#cedulaEdi", ".span_cedula");
    limpiarInput("#civil", ".span_civil");
    limpiarInput("#contrato", ".span_contrato");
    limpiarInput("#notificacion", ".span_notificacion");
    limpiarInput("#telefono", ".span_telefono");
    limpiarInput("#estatus", ".span_estatus");
    limpiarInput("#cargo", ".span_cargo");
    limpiarInput("#departamento", ".span_departamento");
    limpiarInput("#dependencia", ".span_dependencia");
  }

  function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
      edad--;
    }
    return edad;
  }
  // Función para cambiar la URL del AJAX y recargar la tabla
  function recargarTablaConNuevaURL(nuevaURL) {
    table.ajax.url(nuevaURL).load();
  }

  // Evento click para los botones de familiar
  function personalFamiliar(idPersonal) {
    console.log(idPersonal);
    // Aquí puedes abrir el modal y pasar el idPersonal si es necesario
    $('#exampleModal').modal('show');

    // Destruir el DataTable existente si ya ha sido inicializado
    if ($.fn.DataTable.isDataTable('#myTable2')) {
      $('#myTable2').DataTable().destroy();
    }

    // Inicializar el DataTable con el nuevo idPersonal
    let table2 = new DataTable('#myTable2', {
      responsive: true,
      ajax: {
        url: "./src/ajax/registroPersonal.php?modulo_personal=obtenerFamiliar",
        type: "POST",
        data: { id: idPersonal },
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
          targets: 1,
          width: "8%",
          class: "text-center",
          render: function (data, type, row) {
            return data ? data : 'No Cédulado';
          }
        },
        {
          targets: 2,
          class: "text-center",
          render: function (data, type, row) {
            return data ? data : 'Sin Discapacidad';
          }
        },
        {
          targets: 3,
          width: "8%",
          class: "text-center",
          render: function (data, type, row) {
            return data + " Años";
          }
        },
        {
          targets: 4,
          class: "text-center",
          render: function (data, type, row) {
            return data ? data : 'Sin Tomo';
          }
        },
        {
          targets: 5,
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
        { "data": 0 }, // Cédula
        { "data": 1 }, // Nombre Y Apellido
        { "data": 2 }, // Estatus
        { "data": 3 }, // Dependencia
        { "data": 4 }, // Cargo
        { "data": 5 }, // Departamento
        { "data": 6 },
        { "data": 7 },
      ]
    });
  }

  // Funcion para descargar documentos 
  function DescargarDocumento(doc) {
    console.log("Documento a descargar:", doc);
    const baseDir = './src/global/archives/personal/familiares/';
    const subDirs = ['partidasDiscapacidad', 'partidasNacimiento']; // Lista de subdirectorios conocidos

    let found = false;
    let pendingRequests = subDirs.length;
    // Ejemplo de uso
    Swal.bindClickHandler();
    /* Bind a mixin to a click handler */
    Swal.mixin({
      toast: true
    }).bindClickHandler("data-swal-toast-template");


    $('#saveButton').on('click', function () {
      let cedula = $(this).data('cedula');
    })

    subDirs.forEach(subDir => {
      const filePath = `${baseDir}${subDir}/${doc}`;
      $.ajax({
        url: filePath,
        type: 'HEAD', // Usamos HEAD para verificar si el archivo existe sin descargarlo
        success: function () {
          if (!found) {
            found = true;
            console.log("Archivo encontrado en:", filePath);
            // Crear un enlace temporal para descargar el archivo
            const link = document.createElement('a');
            link.target = "_blank";
            link.href = filePath;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          }
        },
        error: function () {
          pendingRequests--;
          if (pendingRequests === 0 && !found) {
            alert("No se consiguió el archivo: " + doc);
          }
          // No imprimir el error en la consola
        }
      });
    });
  }


  // Editar empledos
  async function editar(idPersonal) {
    let urls = [
      "src/ajax/registroPersonal.php?modulo_personal=obtenerDependencias",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerEstatus",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerCargo",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerDepartamento",
      "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal"
    ];

    let options = { cedulaEmpleado: idPersonal };
    let requests = urls.map((url, index) => {
      if (index === 4) {
        return obtenerDatosPromise(url, options);
      } else {
        return obtenerDatosPromise(url);
      }
    });

    try {
      const [dependencias, estatus, cargo, departamento, datosPersonal] = await Promise.all(requests);

      // Procesar dependencias
      if (dependencias.exito && dependencias.data) {
        llenarSelectDependencias(dependencias.data, 'dependencia');
      } else {
        console.error('Error al obtener dependencias o la estructura de la respuesta es incorrecta');
      }

      // Procesar estatus
      if (estatus.exito && estatus.data) {
        llenarSelectDependencias(estatus.data, 'estatus');
      } else {
        console.error('Error al obtener los estatus o la estructura de la respuesta es incorrecta');
      }

      // Procesar cargo
      if (cargo.exito && cargo.data) {
        llenarSelectDependencias(cargo.data, 'cargo');
      } else {
        console.error('Error al obtener los cargos o la estructura de la respuesta es incorrecta');
      }

      // Procesar departamento
      if (departamento.exito && departamento.data) {
        llenarSelectDependencias(departamento.data, 'departamento');
      } else {
        console.error('Error al obtener departamento o la estructura de la respuesta es incorrecta');
      }

      // Procesar datos personales
      if (datosPersonal.exito) {
        console.log(datosPersonal)
        $("#idEmpleado").val(datosPersonal.idPersonal);
        $("#primerNombre").val(datosPersonal.nombre);
        $("#segundoNombre").val(datosPersonal.segundoNombre);
        $("#primerApellido").val(datosPersonal.apellido);
        $("#segundoApellido").val(datosPersonal.segundoApellido);
        $("#cedulaEdi").val(datosPersonal.cedula);
        $("#telefono").val(datosPersonal.telefono);
        $("#civil").val(datosPersonal.estadoCivil);
        $('#dependencia').val(datosPersonal.iddependencia).trigger('change');
        $('#departamento').val(datosPersonal.iddepartamento).trigger('change');
        $('#estatus').val(datosPersonal.idestatus).trigger('change');
        $('#dependencia').val(datosPersonal.iddependencia).trigger('change');
        $('#cargo').val(datosPersonal.idcargo).trigger('change');
        $('#academico').val(datosPersonal.nivelAcademico).trigger('change');
        $('#ano2').val(datosPersonal.anoNacimiento).trigger('change');
        $('#dia2').val(datosPersonal.diaNacimineto).trigger('change');
        $('#meses2').val(datosPersonal.mesNacimiento).trigger('change');


        // llevarOptionIndividual(datosPersonal[0].dependencia, 'dependencia', datosPersonal[0].iddependencia);
        // se marcar cumplido logrado y se marcar span cumplido logrado 
        $("cedula_trabajador").addClass("cedulaBusqueda");
        clasesInputs("#primerNombre", ".span_nombre");
        clasesInputs("#segundoNombre", ".span_nombre2");
        clasesInputs("#primerApellido", ".span_apellido");
        clasesInputs("#segundoApellido", ".span_apellido2");
        clasesInputs("#cedulaEdi", ".span_cedula");
        clasesInputs("#telefono", ".span_telefono");
        clasesInputs("#civil", ".span_civil");
        clasesInputs("#ano2", ".span_ano");
        clasesInputs("#dia2", ".span_dia");
      } else {
        console.error('Error al obtener datos personales o la estructura de la respuesta es incorrecta');
      }
    } catch (error) {
      console.error('Error al obtener los datos:', error.status, error.error);
    }
  }

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
        $("#cedula_familiar").val(datosPersonal.cedula);
        clasesInputs("#cedula_familiar", ".span_cedula_familiar");
        $("#carnet").val(datosPersonal.codigoCarnet);

        if (datosPersonal.cedula == null) {
          $("#noCedula").prop("checked", true);
          $("#contenTomo").show();
          $("#contenFolio").show();
          $("#tomo").removeClass("ignore-validation");
          $("#folio").removeClass("ignore-validation");
          $("#contenCedula").hide();
          $("#cedula_familiar").addClass("ignore-validation");
          $("#cedula_familiar").removeClass("cumplido");
          $(".span_cedula").removeClass("cumplido_span");
        } else {
          $("#noCedula").prop("checked", false);

          $("#contenTomo").hide();
          $("#contenFolio").hide();
          $("#tomo").addClass("ignore-validation");
          $("#tomo").removeClass("cumplido");
          $(".span_tomo").removeClass("cumplido_span");

          $("#folio").addClass("ignore-validation");
          $("#folio").removeClass("cumplido");
          $(".span_folio").removeClass("cumplido_span");

          $("#contenCedula").show();
          $("#cedula_familiar").removeClass("ignore-validation");
          $("#cedula_familiar").addClass("cumplido");
          $(".span_cedula").addClass("cumplido_span");
        }

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
      } else {
        console.error('Error al obtener datos personales o la estructura de la respuesta es incorrecta');
      }
    } catch (error) {
      console.error('Error al obtener los datos:', error.status, error.error);
    }
  }

  async function llenarSelectDependencias(data, selectId) {
    const select = document.getElementById(selectId);
    console.log(data);
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

  // select.remove(i);
  async function llevarOptionIndividual(data, selectId, idnumber) {
    const select = document.getElementById(selectId);
    const options = select.options;

    // Crear la nueva opción
    const option = document.createElement('option');
    option.value = idnumber;
    option.text = data;
    option.classList.add('new-option'); // Añadir clase para fondo rojo

    // Insertar la opción al principio
    select.insertBefore(option, select.firstChild);

  }

  function eliminar(idPersonal) {
    console.log(idPersonal);
    let formData = new FormData();
    formData.append('id', idPersonal); // Añadir idPersonal al FormData

    function callbackExito(parsedData) {
      // Manejar la respuesta exitosa aquí
      $('#myTable').DataTable().ajax.reload(null, false);
      AlertSW2("success", "Empleado Eliminado Con exito", "top", 3000);

    }

    function enviar() {
      let destino = "src/ajax/registroPersonal.php?modulo_personal=eliminarPersonal";
      let url = destino;
      enviarFormulario(url, formData, callbackExito, true);
    }
    // parametros para la alerta
    let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
    let icons = 'primary';
    let position = 'top-end';

    aletaCheck(messenger, icons, position, enviar);
  }

  function eliminarFamiliar(idPersonal) {
    console.log(idPersonal);
    let formData = new FormData();
    formData.append('id', idPersonal); // Añadir idPersonal al FormData

    function callbackExito(parsedData) {
      // Manejar la respuesta exitosa aquí
      $('#myTable').DataTable().ajax.reload(null, false);
      AlertSW2("success", "Empleado Eliminado Con exito", "top", 3000);

    }

    function enviar() {
      let destino = "src/ajax/registroPersonal.php?modulo_personal=eliminarFamiliar";
      let url = destino;
      enviarFormulario(url, formData, callbackExito, true);
    }
    // parametros para la alerta
    let messenger = 'Estás a punto de <b class="text-danger"><i class="fa-solid fa-xmark"></i> <u>eliminar</u></b> este registro. ¿Deseas continuar?';
    let icons = 'primary';
    let position = 'top-end';

    aletaCheck(messenger, icons, position, enviar);
  }

  // $("#cedula_trabajador_familiar").on("input", function () {
  //   function callbackExito(parsedData) {
  //     if (parsedData.logrado == true) {
  //       let nombre = parsedData.nombre;
  //       let apellido = parsedData.apellido;
  //       // si tiene marcado error
  //       $("#nombreEmpleado").removeClass("error_input");
  //       $("#apellidoEmpleado").removeClass("error_input");
  //       $(".span_nombre").removeClass("error_span");
  //       $(".span_apellido").removeClass("error_span");
  //       // se marcar cumplido logrado
  //       $("#cedula_trabajador_familiar").addClass("cedulaBusqueda");
  //       $("#nombreEmpleado").addClass("cumplido");
  //       $("#apellidoEmpleado").addClass("cumplido");
  //       $(".span_nombre").addClass("cumplido_span");
  //       $(".span_apellido").addClass("cumplido_span");
  //       $("#nombreEmpleado").val(nombre);
  //       $("#apellidoEmpleado").val(apellido);
  //       alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
  //     } else {
  //       $("#nombreEmpleado").val("");
  //       $("#apellidoEmpleado").val("");
  //       $("#nombreEmpleado").removeClass("cumplido");
  //       $("#apellidoEmpleado").removeClass("cumplido");
  //       $(".span_nombre").removeClass("cumplido_span");
  //       $(".span_apellido").removeClass("cumplido_span");
  //       alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
  //     }
  //   }
  //   if ($(this).val().length >= 7) {
  //     const datoCedula = $(this).val();
  //     const formData = new FormData(); // Crea un nuevo objeto FormData
  //     formData.append('cedulaEmpleado', datoCedula);
  //     enviarFormulario("src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal", formData, callbackExito, true);
  //   }
  // });

  // Evento click para los botones de familiar
  $(window).resize(function () {
    table.ajax.reload(null, false); // Recarga la tabla sin reiniciar la paginación
  });

  $('#myTable').on('click', '.btn-familiar', function () {
    let idPersonal = $(this).data('id');
    personalFamiliar(idPersonal);
  });

  $('#myTable').on('click', '.btnEditar', function () {
    let idPersonal = $(this).data('cedula');
    editar(idPersonal);
  });

  $('#myTable').on('click', '.btnEliminar', function () {
    let idPersonal = $(this).data('id');
    eliminar(idPersonal);
  });

  $('#myTable2').on('click', '.btnEliminar', function () {
    let idPersonal = $(this).data('id');
    eliminarFamiliar(idPersonal);
  });

  $('#myTable2').on('click', '.btnEditarFamiliar', function () {
    let idempleado = $(this).data('cedula');
    editarFamiliar(idempleado);
  });

  $('#myTable2').on('click', '.botondocumet', function () {
    let doc = $(this).data('doc');
    DescargarDocumento(doc);
  });

  $(document).on("click", ".btnEditarFamiliar", function () {
    $('#exampleModal').modal('show');
    $('#editarDatosFamiliar').modal('show');

  })
  // Evitar que el primer modal se cierre cuando se abre el segundo modal
  $('#exampleModal').on('show.bs.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function () {
      $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
  });

  $("#formularioActualizar").on("submit", function (e) {
    e.preventDefault();
    const data = new FormData(this);
    const url = "src/ajax/registroPersonal.php?modulo_personal=actualizarPersonal";
    $("#aceptar").prop("disabled", true);

    function callbackExito(parsedData) {
      let dataerror = parsedData.error;
      $("#aceptar").prop("disabled", false);
      console.log(parsedData);
      if (parsedData.exito) {
        AlertSW2("success", "Empleado Actualizado Con Exito", "top-end", 3000);
      } else {
        alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end")
      }
      // else if (dataerror) {
      //   alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end")
      // } else {
      //   alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end")
      // }
      // const myModal = new bootstrap.Modal(document.getElementById('modal'));
      // myModal.show();
    }
    enviarFormulario(url, data, callbackExito, true);
  });

  $("#forActualizarFamiliar").on("submit", function (e) {
    const form = document.getElementById('forActualizarFamiliar');
    e.preventDefault();
    const data = new FormData(form);
    const url = "src/ajax/registroPersonal.php?modulo_personal=actualizarFamiliar";
    $("#aceptar_familia").prop("disabled", true);

    function callbackExito(parsedData) {
      let dataerror = parsedData.error;
      $("#aceptar_familia").prop("disabled", false);
      console.log(parsedData);
      if (parsedData.exito) {
        AlertSW2("success", "Familiar Actualizado Con Exito", "top-end", 3000);
      } else {
        alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end")
      }
    }
    enviarFormulario(url, data, callbackExito, true);
  });

  // MESES DE EMPELADO
  $("#meses2").on("change", function () {
    const year = 2024; // Cambia el año si lo deseas
    const month = $("#meses2").val();
    if (month == "") {
      $(this).removeClass("cumplido");
      $(this).addClass("error_input");
      $(".span_mes").removeClass("cumplido_span");
      $(".span_mes").addClass("error_span");

      $("#dia2").removeClass("cumplido");
      $("#dia2").addClass("error_input");
      $(".span_dia").removeClass("cumplido_span");
      $(".span_dia").addClass("error_span");
      $("#dia2").empty();
    } else {
      // Verificar si month no es null o undefined
      if (month) {
        // Eliminar el cero inicial si existe
        const monthWithoutLeadingZero = month.replace(/^0+/, "");
        // Obtener el número de días en el mes seleccionado
        const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate(); // Restamos 1 al mes porque JavaScript cuenta los meses desde 0
        // Generar las opciones de los días
        $("#dia2").empty(); // Limpiar las opciones anterior
        $("#dia2").removeClass("error_input");
        $("#dia2").addClass("cumplido");
        $(".span_dia").removeClass("error_span");
        $(".span_dia").addClass("cumplido_span");
        for (let i = 1; i <= daysInMonth; i++) {
          const diaFormateado = i.toString().padStart(2, "0");
          $("#dia2").append(
            '<option value="' + diaFormateado + '">' + diaFormateado + "</option>"
          );
        }
        $(this).removeClass("error_input");
        $(this).addClass("cumplido");
        $(".span_mes").removeClass("error_span");
        $(".span_mes").addClass("cumplido_span");
      } else {
        console.error("El valor de month es null o undefined");
      }
    }
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

  $("#ano2").on("input", function () {
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
      colocarMeses("#meses2");

    }
  });

  $("#anoFamiliar").on("input", function () {
    const opcionSeleccionada = $(this).val();
    if (opcionSeleccionada === "") {
      $("#mesesFamiliar").removeClass("cumplido");
      $("#mesesFamiliar").addClass("error_input");
      $(".span_mes_familiar").removeClass("cumplido_span");
      $(".span_mes_familiar").addClass("error_span");

      $("#diaFamiliar").removeClass("cumplido");
      $("#diaFamiliar").addClass("error_input");
      $(".span_dia_familiar").removeClass("cumplido_span");
      $(".span_dia_familiar").addClass("error_span");
      $("#mesesFamiliar").empty();
      $("#diaFamiliar").empty();
    } else {
      colocarMeses("#mesesFamiliar");

    }
  });

  $("#noCedula").on("input", function () {
    if ($(this).is(":checked")) {
      $("#contenTomo").show();
      $("#contenFolio").show();
      $("#contenCedula").hide();
      $("#tomo").removeClass("ignore-validation");
      $("#folio").removeClass("ignore-validation");
      $("#cedula_familiar").addClass("ignore-validation");
    } else {
      $("#contenTomo").hide();
      $("#contenFolio").hide();
      $("#tomo").addClass("ignore-validation");
      $("#folio").addClass("ignore-validation");
      $("#contenCedula").show();
      $("#cedula_familiar").removeClass("ignore-validation");
    }
  });

  $("#disca").on("change", function () {
    if ($(this).is(":checked")) {
      $("#contenCarnet").show();
      $("#carnet").removeClass("ignore-validation");
    } else {
      $("#contenCarnet").hide();
      $("#carnet").addClass("ignore-validation");
    }
  });

  $(".cerrarEditar").on("click", function () {
    limpiarDatos();
  });

  $("#limpiar").on("click", function () {
    limpiarDatos();
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

  $("#diaFamiliar, #mesesFamiliar, #anoFamiliar").on("input", function () {
    const dia = $("#diaFamiliar").val();
    const mes = $("#mesesFamiliar").val();
    const ano = $("#anoFamiliar").val();

    if (dia && mes && ano) {
      const fechaNacimiento = new Date(ano, mes - 1, dia);
      const edad = calcularEdad(fechaNacimiento);
      $("#edad").val(edad);
      $("#edad").addClass("cumplido");
      $(".span_edad").addClass("cumplido_span");
      if (!isNaN(edad)) {
        let check = $("#noCedula");
        if (check.is(":checked")) {
          if (edad >= 18) {
            $("#contenCedula").show();
            $("#contenTomo").hide();
            $("#contenFolio").hide();
          } else {
            $("#contenTomo").show();
            $("#contenFolio").show();
            $("#contenCedula").hide();
            let contenDoc = document.getElementById("contenDoc");
            if (!contenDoc) {
              $("#contenDoc").show();
            }
          }
        } else {
          if (edad >= 18) {
            $("#contenDoc").hide();
            $("#contenTomo").hide();
            $("#contenFolio").hide();
          } else {
            $("#contenDoc").show();
            $("#contenTomo").show();
            $("#contenFolio").show();
            let contenDoc = document.getElementById("#contenDoc");
            if (!contenDoc) {
              $("#contenDoc").show();
            }
          }
        }

      }
      console.log(edad)
    }
  });

  function partidaNacimeinto() {
  }

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

  // Cambiar id y colocar contenedor de notificacion
  $(document).on("click", "#cargaNoti", function () {
    const $this = $(this);
    // Deshabilitar temporalmente el botón para evitar múltiples clics
    $this.prop("disabled", true);
    // Aplicar efecto de desvanecimiento al cambiar el contenido HTML
    $this.slideUp(300, function () {
      $this.html('<i class="fa-solid fa-xmark me-2"></i>Eliminar Notificación').fadeIn(300);
    });
    $this.addClass("eliminar");
    const contentelefono = $("#contentTelefono");
    // Verificar si el contenedor ya existe
    if ($("#contentNoti").length === 0) {
      // Crear el contenedor htmlNotificacion y ocultarlo inicialmente
      const $htmlNotificacion = $(htmlNotificacion).hide();
      // Insertar el contenedor antes del campo de teléfono y mostrarlo con un efecto de desvanecimiento
      $(contentelefono).before($htmlNotificacion);
      $htmlNotificacion.slideDown(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      }); // Mostrar con efecto show slow
    } else {
      // Rehabilitar el botón si el contenedor ya existe
      $this.prop("disabled", false);
    }
    // Cambiar el ID del contenedor
    $this.attr("id", "cargaNotiEliminar");
  });

  // Delegación de eventos para el botón con ID cargaNotiEliminar y 
  // eliminar el contenedor de notificacion 
  $(document).on("click", "#cargaNotiEliminar", function () {
    const $this = $(this);
    // Deshabilitar temporalmente el botón para evitar múltiples clics
    $this.prop("disabled", true);
    $("#contentNoti").slideUp(500, function () {
      $(this).remove();
      // Rehabilitar el botón después de la animación
      $this.prop("disabled", false);
    });
    // Aplicar efecto de desvanecimiento al cambiar el contenido HTML
    $this.slideUp(300, function () {
      $this.html('<i class="fa-solid fa-plus me-2"></i>Cargar Notificación').fadeIn(300);
    });
    $this.attr("id", "cargaNoti");
  });

  // Cambiar id y colocar contenedor de contrato
  $(document).on("click", "#cargaContrato", function () {
    const $this = $(this);
    // Deshabilitar temporalmente el botón para evitar múltiples clics
    $this.prop("disabled", true);
    // Aplicar efecto de desvanecimiento al cambiar el contenido HTML
    $this.slideUp(300, function () {
      $this.html('<i class="fa-solid fa-xmark me-2"></i>Eliminar Contrato').fadeIn(300);
    });
    $this.addClass("eliminar");
    const contentelefono = $("#contentTelefono");
    // Verificar si el contenedor ya existe
    if ($("#contentContrato").length === 0) {
      // Crear el contenedor htmlContrato y ocultarlo inicialmente
      const $htmlContrato = $(htmlContrato).hide();
      // Insertar el contenedor antes del campo de teléfono y mostrarlo con un efecto de desvanecimiento
      $(contentelefono).before($htmlContrato);
      $htmlContrato.slideDown(500, function () {
        // Rehabilitar el botón después de la animación
        $this.prop("disabled", false);
      }); // Mostrar con efecto show slow
    } else {
      // Rehabilitar el botón si el contenedor ya existe
      $this.prop("disabled", false);
    }
    // Cambiar el ID del contenedor
    $this.attr("id", "cargaContratoEliminar");
  });

  // Delegación de eventos para el botón con ID cargaContratoEliminar y 
  // eliminar el contenedor de contrato 
  $(document).on("click", "#cargaContratoEliminar", function () {
    const $this = $(this);
    // Deshabilitar temporalmente el botón para evitar múltiples clics
    $this.prop("disabled", true);
    $("#contentContrato").slideUp(500, function () {
      $(this).remove();
      // Rehabilitar el botón después de la animación
      $this.prop("disabled", false);
    });
    // Aplicar efecto de desvanecimiento al cambiar el contenido HTML
    $this.slideUp(300, function () {
      $this.html('<i class="fa-solid fa-plus me-2"></i>Cargar Contrato').fadeIn(300);
    });
    $this.attr("id", "cargaContrato");
  });

  // Delegación de eventos para botones creados dinámicamente
  $(document).on('click', '.dt-button', function (event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del enlace

    if ($(this).hasClass('dt-button-active')) {
      // Si tiene la clase dt-button-active
      $(this).removeClass('dt-button-desactive'); // Elimina la clase dt-button-desactive
    } else {
      // Si no tiene la clase dt-button-active
      $(this).addClass('dt-button-desactive'); // Añade la clase dt-button-desactive
    }
  });

  // Función para buscar datos
  function buscarDatos() {
    const valor = $("#cedula_trabajador_familiar").val();
    if (valor.length >= 7) {
      function callbackExito(parsedData) {
        if (parsedData.logrado == true) {
          let nombre = parsedData.nombre;
          let apellido = parsedData.apellido;
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
          alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
        } else {
          $("#nombreEmpleado").val("");
          $("#apellidoEmpleado").val("");
          $("#nombreEmpleado").removeClass("cumplido");
          $("#apellidoEmpleado").removeClass("cumplido");
          $(".span_nombre").removeClass("cumplido_span");
          $(".span_apellido").removeClass("cumplido_span");
          alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
        }
      }
      if ($(this).val().length >= 7) {
        const datoCedula = $(this).val();
        const formData = new FormData(); // Crea un nuevo objeto FormData
        formData.append('cedulaEmpleado', datoCedula);
        enviarFormulario("src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal", formData, callbackExito, true);
      }
    }
  }

  // Aplicar debounce a la función de búsqueda
  const buscarDatosDebounced = debounce(buscarDatos, 600);

  // Evento de input para el campo de búsqueda
  $("#cedula_trabajador_familiar").on("input", buscarDatosDebounced);

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
          file("#notificacion", ".span_notificacion");
          file("#contrato", ".span_contrato");
        }
      }
    }, 300)); // Ajusta el tiempo de espera según sea necesario

    // Configurar el observer para observar cambios en los hijos y atributos del formulario
    const config = { childList: true, attributes: true, subtree: true };

    // Comenzar a observar el formulario
    observer.observe(formulario, config);
  }

  // Seleccionar los formularios y los botones correspondientes
  const formularioActualizar = document.querySelector('#formularioActualizar');
  const botonActualizar = $('#aceptar_empleado');

  const forActualizarFamiliar = document.querySelector('.formulario-familia');
  const aceptar_familia = $('#aceptar_familia');

  // Observar cambios en cada formulario por separado
  observarFormulario(formularioActualizar, botonActualizar);
  observarFormulario(forActualizarFamiliar, aceptar_familia);


  // Inicializar el estado de los botones al cargar la página
  habilitarBoton(formularioActualizar, botonActualizar);
  // Inicializar el estado de los botones al cargar la página
  habilitarBoton(forActualizarFamiliar, aceptar_familia);


});

// CONTENIDO HTML
let htmlContrato = `
<div class="col-sm-12 col-md-12 mb-2" id="contentContrato">
  <div class="form-group">
        <label for="correo">Contrato</label>
        <div class="input-group">
            <span class="input-group-text span_contrato"><i class="icons fa-regular fa-file-zipper"></i></span>
            <input type="file" class="form-control" name="contratoArchivo" id="contrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
        </div>
    </div>
</div>
`;

let htmlNotificacion = `
  <div class="col-sm-12 col-md-12 mb-2" id="contentNoti">
      <div class="form-group">
          <label for="correo">Notificación</label>
          <div class="input-group">
              <span class="input-group-text span_notificacion"><i class="icons fa-regular fa-file-zipper"></i></span>
              <input type="file" name="notacionAchivo" class="form-control" id="notificacion" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
          </div>
      </div>
  </div>
`;

// plantillas HTML
let cedulaContenido = `
<div class="col-sm-6 col-md-6" id="contenCedula">
    <div class="form-group" >
      <label for="cedula">Cédula</label>
      <div class="input-group">
        <span class="input-group-text span_cedula_familiar"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control " id="cedula_familiar" name="cedula" placeholder="Cédula de Identidad" required >
      </div>
  </div>
</div>
`;

let noCedulado = `
<div class="col-sm-6 col-md-6 mb-3" id="contenTomo">
    <div class="form-group" >
      <label for="tomo">Tomo</label>
      <div class="input-group">
        <span class="input-group-text span_tomo"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control" id="tomo" name="tomo" placeholder="Tomo De partida De Nacimiento" required >
      </div>
  </div>
</div>

<div class="col-sm-6 col-md-6 mb-3" id="contenFolio">
    <div class="form-group" >
      <label for="folio">Folio</label>
      <div class="input-group">
        <span class="input-group-text span_folio"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control" id="folio" name="folio" placeholder="Número de folio" required >
      </div>
  </div>
</div>
`;

let numeroCernet = `
<div class="col-sm-6 col-md-6 mb-3" id="contenCarnet">
  <div class="form-group" >
      <label for="cedula">Número de Carnet de Discapacidad</label>
        <div class="input-group">
        <span class="input-group-text span_carnet"><i class="fa-regular fa-address-card"></i></span>
        <input type="text" class="form-control " id="carnet" name="carnet" placeholder="Cédula de Identidad" required>
    </div>
  </div>
</div>
`;

let partidaNacimiento = `
<div class="col-sm-12 mb-2 mt-3" id="contenDoc">
  <div class="form-group">
    <label for="correo">Partida De Nacimiento</label>
    <div class="input-group">
      <span class="input-group-text span_docArchivo"><i class="fa-regular fa-file-zipper"></i></span>
      <input type="file" class="form-control" name="docArchivo" id="achivo" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required >
    </div>
  </div>
</div>
`;

let partidaDiscapacidad = `
<div class="col-sm-12 mb-2" id="contentPartida">
  <div class="form-group">
      <label for="correo">Partida De Discapacidad</label>
      <div class="input-group">
          <span class="input-group-text span_docArchivoDis"><i class="fa-regular fa-file-zipper"></i></span>
          <input type="file" class="form-control" name="docArchivoDis" id="achivoDis" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
      </div>
  </div>
</div>
`;
