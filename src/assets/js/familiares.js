import {
  validarNombre,
  colocarMeses,
  colocarYear,
  validarNumeroNumber,
  validarNumeros,
  validarSelectores,
  limpiarFormulario,
  liberarInputs,
  file,
  mesesDias,
} from "./ajax/inputs.js";

import { alertaNormalmix, AlertSW2 } from "./ajax/alerts.js";
import { enviarDatos, enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";
const cedulado = `<p class="mb-0 mt-2">Datos del Empleado</p>
                        <hr class="mb-3">
                        <div class="col-sm-4 mb-2">
                            <label class="form-label mb-0" for="cedula_trabajador">Cédula</label>
                            <div class="input-group">
                                <span class="input-group-text span_cedula_empleado "><i class="fa-regular fa-address-card"></i></span>
                                <input type="text" class="form-control " id="cedula_trabajador" name="cedula_familiar" placeholder="Cédula">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-2">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text span_nombre"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Primer Nombre" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-2">
                            <div class="form-group">
                                <label for="apellido">apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Primer Nombre" required readonly>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0 mt-2">Datos Del Familiar</p>
                        <hr class="mb-3">
                        <div class="col-sm-6 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="primerNombre">Primer Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text span_nombre1"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="segundoNombre">Segundo Nombre</label>
                                <div class="input-group ">
                                    <span class="input-group-text span_nombre2"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="primerApellido">Primer Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido1"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="segundoApellido">Segundo Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido2"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="cedula">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cedula"><i class="fa-regular fa-address-card"></i></span>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula de Identidad" required disabled>
                                </div>
                            </div>
                            <p class="text-body-secondary">Este campo es opcional</p>
                        </div>

                        <div class="col-sm-6 col-md-6 ">
                            <div class="form-group">
                                <label for="cedula">Edad</label>
                                <div class="input-group">
                                    <span class="input-group-text span_edad"><i class="fa-regular fa-user"></i></span>
                                    <input type="number" class="form-control" id="edad" name="edad" placeholder="Cédula de Identidad" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="correo">Partida De Nacimiento</label>
                                <div class="input-group">
                                    <span class="input-group-text span_partidaNacmiento"><i class="fa-regular fa-file-zipper"></i></span>
                                    <input type="file" class="form-control" name="partidaNacmientoArchivo" id="partidaNacimiento" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required disabled>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0">Fecha de nacimiento</p>
                        <hr class="mb-2">

                        <div class="col-sm-4  ">
                            <div class="form-group">
                                <label class="required-field" for="message">Año</label>
                                <div class="input-group">
                                    <span class="input-group-text span_ano"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select form-select-md" name="ano" id="ano" required disabled></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4  ">
                            <div class="form-group">
                                <label class="required-field" for="message">Mes</label>
                                <div class="input-group">
                                    <span class="input-group-text span_mes"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select" id="meses" name="meses" aria-label="Default select example" required disabled></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4  mb-3">
                            <div class="form-group ">
                                <label class="required-field" for="message">Día</label>
                                <div class="input-group">
                                    <span class="input-group-text span_dia"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select w-5" id="dia" name="dia" aria-label="Default select example" required disabled></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 ">
                            <button type="submit" id="aceptar_emepleado" name="aceptar" class="btn btn-primary" disabled style="display: none;">
                                <i class="fa-solid fa-plus me-2"></i>Aceptar
                            </button>
                            <button type="submit" id="buscador" name="buscar" class="btn btn-success">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>Buscar
                            </button>
                            <button type="button" id="limpiar" name="submit" class="btn btn-warning" style="color: white;">
                                <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                            </button>
                        </div>`;
$(function () {

  function totalActionInput() {
    const cargando = document.getElementById('cargando');
    validarNumeros("#cedula_trabajador", ".span_cedula_empleado");
    validarNombre("#nombre", ".span_nombre");
    validarNombre("#apellido", ".span_apellido");
    validarNombre("#primerNombre", ".span_nombre1");
    validarNombre("#segundoNombre", ".span_nombre2");
    validarNombre("#primerApellido", ".span_apellido1");
    validarNombre("#segundoApellido", ".span_apellido2");
    validarNumeros("#cedula", ".span_cedula");
    validarSelectores("#ano", ".span_ano");
    validarSelectores("#dia", ".span_dia");
    colocarYear("#ano", "1900");
    colocarMeses("#meses");
    validarNumeroNumber("#edad", ".span_edad");
    file("#partidaNacimiento", ".span_partidaNacimiento");

    $("#dia").append('<option value="">Selecciona un día</option>');
    $("#meses").on("change", function () {
      mesesDias("#dia", ".span_mes", "#meses")      
    });


    $(document).on("input", ".cedulaBusqueda", function () {
      if ($(this).val().length < 7) {
        $("#aceptar_emepleado").hide();
        $("#cedula_trabajador").removeClass("cedulaBusqueda");
        cedulaEjecutar();
      } else {
        cedulaEjecutar(1);
      }
    });




    // Selector para todos los inputs y selects dentro del formulario
    var inputs = $('form input, form select');
    var boton = $('#aceptar_emepleado'); // Reemplaza con el ID de tu botón

    // Función para verificar si todos los elementos tienen la clase "cumplido"
    function todosCumplidos() {
      return inputs.filter('.cumplido').length === inputs.length;
    }

    // Función para habilitar o deshabilitar el botón
    function habilitarBoton() {
      boton.prop('disabled', !todosCumplidos());
    }

    // Inicialmente verificamos el estado
    habilitarBoton();

    // Evento para detectar cambios en los inputs
    inputs.on('change', function () {
      habilitarBoton();
    });
  }

  function envioDatos() {
    $('#formulario_empleado').on("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(this);
      const accion = $(this).find('button[type="submit"]:focus').attr('name');
      console.log(accion)
      if (accion == "buscar") {
        function callbackExito(parsedData) {
          if (parsedData.logrado == true) {
            let nombre = parsedData.nombre;
            let apellido = parsedData.apellido;
            // si tiene marcado error
            $("#nombre").removeClass("error_input");
            $("#apellido").removeClass("error_input");
            $(".span_nombre").removeClass("error_span");
            $(".span_apellido").removeClass("error_span");

            // se marcar cumplido logrado
            $("#cedula_trabajador").addClass("cedulaBusqueda");
            $("#nombre").addClass("cumplido");
            $("#apellido").addClass("cumplido");
            $(".span_nombre").addClass("cumplido_span");
            $(".span_apellido").addClass("cumplido_span");
            $("#nombre").val(nombre);
            $("#apellido").val(apellido);

            $("#primerNombre").prop("disabled", false);
            $("#segundoNombre").prop("disabled", false);
            $("#primerApellido").prop("disabled", false);
            $("#segundoApellido").prop("disabled", false);
            $("#cedula").prop("disabled", false);
            $("#edad").prop("disabled", false);
            $("#ano").prop("disabled", false);
            $("#meses").prop("disabled", false);
            $("#dia").prop("disabled", false);
            $("#partidaNacimiento").prop("disabled", false);

            $("#aceptar_emepleado").show();
            alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
          } else {
            alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
          }
        }
        let destino = "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal";
        let url = destino;
        enviarFormulario(url, formData, callbackExito, true);

      } else if (accion == "aceptar") {
        function callbackExito(parsedData) {
          if (parsedData.logrado == true) {
            let nombre = parsedData.nombre;

            // se marcar cumplido logrado
            $("#cedula_trabajador").addClass("cedulaBusqueda");
            $("#nombre").addClass("cumplido");
            $("#apellido").addClass("cumplido");
            $(".span_nombre").addClass("cumplido_span");
            $(".span_apellido").addClass("cumplido_span");
            $("#nombre").val(nombre);
            $("#apellido").val(apellido);

            $("#primerNombre").prop("disabled", false);
            $("#segundoNombre").prop("disabled", false);
            $("#primerApellido").prop("disabled", false);
            $("#segundoApellido").prop("disabled", false);
            $("#cedula").prop("disabled", false);
            $("#edad").prop("disabled", false);
            $("#ano").prop("disabled", false);
            $("#meses").prop("disabled", false);
            $("#dia").prop("disabled", false);
            $("#partidaNacimiento").prop("disabled", false);
            $("#aceptar_emepleado").show();
            alertaNormalmix(parsedData.mensaje, 4000, "success", "top-end");
          } else {
            alertaNormalmix(parsedData.mensaje, 4000, "error", "top-end");
          }
        }
        let destino = "src/ajax/registroPersonal.php?modulo_personal=";
        let url = destino;
        enviarFormulario(url, formData, callbackExito, true);
      } else {
        console.log("los destinos deben de tener un  error");
      }
    });
  }

  function cedulaEjecutar(valor) {
    if (valor == 1) {
      //liberar inputs
      liberarInputs("#primerNombre", ".span_nombre1", "1");
      liberarInputs("#segundoNombre", ".span_nombre2", "1");
      liberarInputs("#primerApellido", ".span_apellido1", "1");
      liberarInputs("#segundoApellido", ".span_apellido2", "1");
      liberarInputs("#cedula", ".span_cedula", "1");
      liberarInputs("#edad", ".span_edad", "1");
      liberarInputs("#ano", ".span_ano", "1");
      liberarInputs("#meses", ".span_mes", "1");
      liberarInputs("#dia", ".span_dia", "1");
    } else {
      $("#primerNombre").prop("disabled", true);
      $("#segundoNombre").prop("disabled", true);
      $("#primerApellido").prop("disabled", true);
      $("#segundoApellido").prop("disabled", true);
      $("#cedula").prop("disabled", true);
      $("#edad").prop("disabled", true);
      $("#ano").prop("disabled", true);
      $("#meses").prop("disabled", true);
      $("#dia").prop("disabled", true);
      // inputs de busqueda
      $("#nombre").val("");
      $("#apellido").val("");
      // nombre del trabajador
      $("#nombre").removeClass("cumplido");
      $("#nombre").addClass("error_input");
      $(".span_nombre").removeClass("cumplido_span");
      $(".span_nombre").addClass("error_span");

      // apellido del trabajador
      $("#apellido").removeClass("cumplido");
      $("#apellido").addClass("error_input");
      $(".span_apellido").removeClass("cumplido_span");
      $(".span_apellido").addClass("error_span");

      //liberar inputs
      liberarInputs("#primerNombre", ".span_nombre1", "0");
      liberarInputs("#segundoNombre", ".span_nombre2", "0");
      liberarInputs("#primerApellido", ".span_apellido1", "0");
      liberarInputs("#segundoApellido", ".span_apellido2", "0");
      liberarInputs("#cedula", ".span_cedula", "0");
      liberarInputs("#edad", ".span_edad", "0");
      liberarInputs("#ano", ".span_ano", "0");
      liberarInputs("#meses", ".span_mes", "0");
      liberarInputs("#dia", ".span_dia", "0");
    }
  }

  $('#conCedula').on("click", function () {
    $('#formFamiliar').html(cedulado); 
    $('#formFamiliar').addClass('formulario1')
  });

  $('#noCedula').on("click", function () {
    $('#formFamiliar').html(cedulado);
    $('#formFamiliar').addClass('formulario1')
  });

  $(document).on("click", '.formulario1', function () {
    totalActionInput();
    envioDatos();
  });



  $("#limpiar").on("click", function () {
    limpiarFormulario(
      "#formulario_registro",
      "#dia", " #meses", "#ano", "#nombre", "#apellido", "#segundoNombre", "#segundoNombre", "#primerApellido", "#segundoApellido", "#cedula", ".span_ano", ".span_dia", ".span_mes", ".error_span", "cumplido", "cumplido_span", "error_input"
    );
  });
})