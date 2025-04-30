import { alertaNormalmix, AlertSW2, aletaCheck } from "./utils/alerts.js";
import { enviarFormulario } from "./utils/formularioAjax.js";
import { colocarYear, soloNumeros, validarNumeros, validarSelectores, validarSelectoresSelec2 } from "./utils/inputs.js"

$(function () {
    $(document).on("click", function () {

        validarNumeros("#cedula", ".span_cedula");
     

        validarSelectores("#ano", ".span_ano");
        
        soloNumeros("#dias", ".span_dias");
        soloNumeros("#dia2");
        soloNumeros("#ano2");
        soloNumeros("#diasExtra");
    });
    colocarYear("#ano", "1900");
    validarSelectoresSelec2("#ano", "1900");
    var boton = $("#aceptar");

    // Función para buscar datos
    function buscarDatos() {
        const valor = $("#cedula").val();
        if (valor.length >= 7) {
            function callbackExito(parsedData) {
                if (parsedData.logrado == true) {
                    let nombre = parsedData.nombre;
                    let apellido = parsedData.apellido;
                    let cargo = parsedData.cargo;
                    let idEmpleado = parsedData.idEmpleado;

                    // si tiene marcado error
                    $("#primerNombre").removeClass("error_input");
                    $("#primerApellido").removeClass("error_input");
                    $("#cargo").removeClass("error_input");
                    $(".span_nombre").removeClass("error_span");
                    $(".span_apellido").removeClass("error_span");
                    $(".span_cargo").removeClass("error_span");
                    // se marcar cumplido logrado
                    $("#cedula").addClass("cedulaBusqueda");
                    $("#primerNombre").addClass("cumplido");
                    $("#primerApellido").addClass("cumplido");
                    $("#cargo").addClass("cumplido");

                    $(".span_nombre").addClass("cumplido_span");
                    $(".span_apellido").addClass("cumplido_span");
                    $(".span_cargo").addClass("cumplido_span");

                    $("#primerNombre").val(nombre);
                    $("#primerApellido").val(apellido);
                    $("#cargo").val(cargo);
                    $("#identificador").val(idEmpleado);

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

    function obtenerFechaActual() {
        const fechaLocal = new Date();
        const opciones = { day: '2-digit', month: '2-digit', year: 'numeric' };
        return fechaLocal.toLocaleDateString('es-ES', opciones).replace(/\//g, '-'); // Usa la fecha local con guiones
      }
    // Aplicar debounce a la función de búsqueda
    const buscarDatosDebounced = debounce(buscarDatos, 200);

    // Función de debounce para limitar la frecuencia de ejecución
    // Evento de input para el campo de búsqueda
    $("#cedula").on("input", buscarDatosDebounced);

    $("#formVacaciones").on("submit", function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        let url = "src/ajax/vacaciones.php?modulo_datos=registrarVacaciones";
        let callbackExito = function (parsedData) {
            if (parsedData.exito == true) {
                alertaNormalmix(parsedData.messenger, 4000, "success", "top-end");
            } else {
                alertaNormalmix(parsedData.messenger, 4000, "error", "top-end");
            }
        }
        enviarFormulario(url, formData, callbackExito, true);
    });

    const baseConfig = {
        responsive: true,
        processing: false,
        serverSide: false, // Asegúrate de que esto esté configurado si estás usando procesamiento del lado del servidor
        info: false,
        paging: true,
        lengthMenu: [5, 10, 25, 50, 75, 100],
        pageLength: 10,
        pagingType: 'first_last_numbers',
        language: {
            url: "./IdiomaEspañol.json"
        }
    };

    let tableInic = $('#myTable').DataTable(baseConfig);

    // Función para cambiar la URL del AJAX y recargar la tabla con nuevas columnas
    function recargarTabla(newConfig, nuevosTextos) {
        tableInic.clear().destroy(); // Limpiar y destruir la tabla existente
        const $thead = $('#myTable thead');
        $thead.empty(); // Limpiar el contenido existente del thead

        // Crear una nueva fila para los encabezados
        const $fila = $('<tr>').addClass('tr-identity');

        // Crear y agregar las nuevas celdas a la fila
        nuevosTextos.forEach(texto => {
            const $celda = $('<th>').text(texto).addClass('bg-primary text-white');
            // console.log(`Añadiendo celda con texto: ${texto}`); // Depuración
            $fila.append($celda);
        });

        // Agregar la fila al thead
        $thead.append($fila);

        tableInic = $('#myTable').DataTable(newConfig); // Inicializar una nueva instancia con la nueva configuración
    }

    function cambiarTextoCeldas(nuevosTextos) {
        const $thead = $('#myTable thead');
        let $fila = $thead.find('.tr-identity');

        if ($fila.length === 0) {
            // Crear el elemento tr-identity si no existe
            $fila = $('<tr>').addClass('tr-identity');
            $thead.append($fila);
        }

        // Limpiamos todas las celdas existentes en la fila
        $fila.empty();

        // Creamos las nuevas celdas y las agregamos a la fila
        nuevosTextos.forEach(texto => {
            const $celda = $('<th>').text(texto).addClass('bg-primary text-white');
            // console.log(`Añadiendo celda con texto: ${texto}`); // Depuración
            $fila.append($celda);
        });

        // console.log($fila.html());  Depuración: Verificar el contenido de la fila
        // console.log($thead.html());  Depuración: Verificar el contenido del thead
        return true;
    }

    $(document).on("click", "#verVacaciones", async function () {
        const columnasDepe = [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 4 },
            { data: 5 },
            { data: 6 },

            // Agrega más columnas según sea necesario
        ];
        const nuevosTextos = ['Nombre', 'cedula', 'Cargo', 'Año', 'Dia', 'D.D', 'Acciones'];

        if (cambiarTextoCeldas(nuevosTextos)) {
            const newConfig = $.extend(true, {}, baseConfig, {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "src/requests/vacaciones.php?modulo_datos=todasVacaciones",
                    type: "POST",
                    dataSrc: function (json) {
                        // Verificar la estructura de los datos devueltos
                        if (json.data) {
                            // console.log(json.data);
                            return json.data; // Acceder al array de datos dentro de 'data'
                        } else {
                            console.error('Estructura de datos incorrecta:', json);
                            return [];
                        }
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        width: "25%",
                        render: function (data, type, row) {
                            return `<span class="fw-medium"> ${data} </span>`;
                        }
                    },
                    {
                        targets: 1,
                        width: "10%",
                    },
                    {
                        targets: 2,
                        width: "20%",
                        render: function (data, type, row) {
                            return `<span class="fw-medium text-success"> ${data} </span>`;
                        }
                    },
                    {
                        targets: 3,
                        width: "10%",
                        render: function (data, type, row) {
                            return `<span class="ano"> ${data} </span>`;
                        }
                    },
                    {
                        targets: 4,
                        width: "10%",
                        render: function (data, type, row) {
                            return `<span class="dia"> ${data} </span>`;
                        }
                    },
                    {
                        targets: 5,
                        width: "10%",
                        render: function (data, type, row, meta) {
                            // Separar la fecha y los permisos de data
                            const fecha = data;
                            const fechaActual = obtenerFechaActual();
              
                            // Calcular la diferencia de días entre la fecha de data y la fecha actual
                            const fechaData = new Date(fecha.split('-').reverse().join('-'));
                            const fechaActualDate = new Date(fechaActual.split('-').reverse().join('-'));
                            const diferenciaDias = Math.ceil((fechaData - fechaActualDate) / (1000 * 60 * 60 * 24));
              
                            // Aplicar diferentes colores según la proximidad de la fecha
                            let colorClase = 'text-success'; // Verde por defecto
                            if (diferenciaDias <= 3) {
                              colorClase = 'text-warning'; 
                              var span = `<span class="${colorClase}">${fecha}</span>`;
                              // Rojo si está muy cerca (2 o 3 días antes)
                            } else if (diferenciaDias <= 7) {
                              colorClase = 'text-sucess';
                              var span = `<span class="${colorClase}">${fecha}</span>`; // Naranja si está cerca (menos de una semana)
                            }
                            
                            if (fechaData >= fechaActualDate) {
                              colorClase = 'text-danger';
                              var span = `<span class="${colorClase}">${fecha}</span>`;
                              // var span = `<small class='d-inline-flex px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>Liberar</small>`;
                            }
                            return span;
                          }
                    },
                    {
                        targets: 6,
                        width: "20%",
                        

                    }
                ],
                columns: columnasDepe
            });
            recargarTabla(newConfig, nuevosTextos);
        }
    });

    // Evento para guardar las ausencias editadas
    $("#myTable").on('click', '.btnActualizar', function () {
        let idAusencia = $(this).data('id');
        let fila = $(this).closest('tr'); // Obtener la fila correspondiente

        // Obtener los datos de la fila
        let nombre = fila.find('td').eq(0).text();
        let cedula = fila.find('td').eq(1).text();
        let cargo = fila.find('td').eq(2).text();
        let anoInput = fila.find('input[name="ano"]');
        let diaInput = fila.find('input[name="dias"]');
        let diasExtra = fila.find('input[name="diasExtra"]');

        let ano = anoInput.val();
        let dia = parseInt(diaInput.val(), 10); // Convertir a número entero
        let diaExtra2 = parseInt(diasExtra.val(), 10); // Convertir a número entero

        // Verificar si diasExtra existe y tiene un valor numérico
        if (diasExtra.length && !isNaN(diaExtra2)) {
            diaExtra2;
        }else{
            diaExtra2 = 0;
        }

        // Crear un objeto FormData con los datos de la fila
        let formData = new FormData();
        formData.append('id', idAusencia);
        formData.append('nombre', nombre);
        formData.append('cedula', cedula);
        formData.append('cargo', cargo);
        formData.append('ano', ano);
        formData.append('dias', dia);
        formData.append('diadisfrute', diaExtra2);


        function collbackExito(parsedData) {
            if (parsedData.exito) {
                alertaNormalmix(parsedData.messenger, 4000, "success", "top-end");
                // Reemplazar el input con el valor de texto
                anoInput.closest('td').html(ano);
                diaInput.closest('td').html(dia);

                // Cambiar el botón de guardar a editar
                $(".btnActualizar").removeClass('btn btnActualizar btn-success btn-hover-verde')
                    .addClass('btn btnEditar btn-primary btn-hover-azul')
                    .html('<i class="fa-solid fa-pencil fa-sm me-2"></i>Editar');

                fila.find('.btndisfrute').remove();
                fila.find('.btndisdelefrute').remove();
                tableInic.ajax.reload(null, false);
            } else {
                alertaNormalmix(parsedData.messenger, 4000, "error", "top-end");
            }
        }

        if ( diaExtra2 > dia ) {
            alertaNormalmix('Los dias disfrutados son mayores que los dias que tiene asignado', 4000, "error", "top-end");
        }else{
            enviarFormulario('src/ajax/vacaciones.php?modulo_datos=actualizarVacaciones', formData, collbackExito, true);
        }
        
    });

    // Evento para editar las ausencias
    $("#myTable").on('click', '.btnEditar', function () {
        let fila = $(this).closest('tr');
        let anoCelda = fila.find('.ano');
        let diaCelda = fila.find('.dia');
        let anoValor = $.trim(anoCelda.text());
        let diaValor = $.trim(diaCelda.text());
        let anoNumero = parseInt(anoValor);
        let diaNumero = parseInt(diaValor);

        anoCelda.html(`<input name="ano" type="number" id="ano2" class="form-control" value="${anoNumero}" style="width: 100%;">`);
        diaCelda.html(`<input name="dias" type="number" id="dia2" class="form-control" value="${diaNumero}" style="width: 100%;">`);

        // Cambiar el botón de editar a guardar
        $(this).removeClass('btnEditar btn-primary btn-hover-azul')
            .addClass('btn btnActualizar btn-success btn-hover-verde')
            .html(`
            <i class="fa-solid fa-circle-right fa-sm me-2"></i>Guardar
        `);

        // Agregar el nuevo botón en la última celda
        let idAusencia = $(this).data('id');
        let ultimaCelda = fila.find('.contentBoton').last();
        ultimaCelda.append(`
            <button class="btn btn-secondary btn-sm btn-hover-gris btndisfrute me-2 ms-2" data-id="${idAusencia}">
                <i class="fa-solid fa-plus fa-sm me-2 "></i>Disfrute
            </button>
        `);

        ultimaCelda.append(`
            <button class="btn btn-warning btn-sm btn-hover-gris btnLimpiar me-2 ">
                <i class="fa-solid fa-minus fa-sm"></i>
            </button>
        `);
    });

    // Evento para manejar el botón de disfrute
    $("#myTable").on('click', '.btndisfrute', function () {
        let fila = $(this).closest('tr'); // Obtener la fila correspondiente
        let diaInput = fila.find('#dia2'); // Obtener el input con id dia2

        // Agregar un nuevo input al lado del input con id dia2
        diaInput.after(`
            <input name="diasExtra" type="number" class="form-control mt-1" id="diasExtra" value="" style="width: 100%;">
        `);

        $(this).removeClass('btn btn-secondary btn-sm btn-hover-gris btndisfrute')
            .addClass('btn btn-secondary btn-sm btn-hover-gris btndisdelefrute ')
            .html(`
        <i class="fa-solid fa-circle-right fa-sm me-2"></i>Eliminar Disfrute 
        `);
    });

    // Evento para manejar el botón de dele.extra
    $("#myTable").on('click', '.btndisdelefrute', function () {
        let fila = $(this).closest('tr'); // Obtener la fila correspondiente
        let diaInput = fila.find('#dia2');
        fila.find('#diasExtra').remove();

        $(this).removeClass('btn btn-secondary btn-sm btn-hover-gris btndisdelefrute')
            .addClass('btn btn-secondary btn-sm btn-hover-gris btndisfrute ')
            .html(`
        <i class="fa-solid fa-circle-right fa-sm me-2"></i>Disfrute
        `);
    });


    // Evento para manejar el botón de dele.extra
    $("#myTable").on('click', '.btnLimpiar', function () {
        let fila = $(this).closest('tr');
        let anoCelda = fila.find('.ano');
        let diaCelda = fila.find('.dia');
  
        let anoInput = fila.find('input[name="ano"]');
        let diaInput = fila.find('input[name="dias"]');
        let ano = anoInput.val();
        let dia = parseInt(diaInput.val(), 10); // Convertir a número entero

        anoInput.closest('td').html(`<span class="ano">${ano}</span>`);
        diaInput.closest('td').html(`<span class="dia">${dia}</span>`);

        // Cambiar el botón de guardar a editar
        $(".btnActualizar").removeClass('btn btnActualizar btn-success btn-hover-verde')
            .addClass('btn btnEditar btn-primary btn-hover-azul')
            .html('<i class="fa-solid fa-pencil fa-sm me-2"></i>Editar');

        fila.find('.btnLimpiar').remove();
        fila.find('.btndisfrute').remove();
        fila.find('.btndisdelefrute').remove();
    });

    $("#myTable").on('click', '.btnEliminarVaca', function () {
            let idAusencia = $(this).data('id');
            let formData = new FormData();
            formData.append('id', idAusencia); // Añadir idPersonal al FormData
        
            function callbackExito(parsedData) {
              // Manejar la respuesta exitosa aquí
              $('#myTable').DataTable().ajax.reload(null, false);
              AlertSW2("success", parsedData.messenger, "top", 3000);
        
            }
        
            function enviar() {
              let destino = "./src/ajax/vacaciones.php?modulo_datos=desactivarVaca";
              let url = destino;
              enviarFormulario(url, formData, callbackExito, true);
            }
            // parametros para la alerta
            let messenger = 'Estás a punto de <b class="text-warning"><i class="fa-solid fa-xmark"></i> <u>desactivar</u></b> este usuario. ¿Deseas continuar?';
            let icons = 'primary';
            let position = 'top-end';
        
            aletaCheck(messenger, icons, position, enviar);
          });

    // metodos para escuchar cambios en el dom y habilitar el boton de enviar formulario 
    // Función para verificar si todos los campos están cumplidos en un formulario específico
    function todosCumplidos(form) {
        const elementosCumplidos = $(form).find('input, select').filter('.cumplido, .cumplidoNormal');
        return elementosCumplidos.length === $(form).find('input, select').length;
    }

    // Función para habilitar o deshabilitar el botón en un formulario específico
    function habilitarBoton(form, boton) {
        boton.prop('disabled', !todosCumplidos(form));
    }

    // Función de debounce para limitar la frecuencia de ejecución
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Seleccionar los formularios específicos que deseas observar
    const forms = document.querySelectorAll('.formVacaciones, .formEditarAusencia');

    forms.forEach(form => {
        const boton = $(form).closest('.modalContent').find('.aceptar');

        // Inicialmente desactivar el botón
        boton.prop('disabled', true);

        // Crear una instancia de MutationObserver y observar cambios
        const observer = new MutationObserver(debounce((mutationsList) => {
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList' || mutation.type === 'attributes') {
                    habilitarBoton(form, boton);
                }
            }
        }, 300)); // Ajusta el tiempo de espera según sea necesario

        // Configurar el observer para observar cambios en los hijos y atributos del formulario
        const config = { childList: true, attributes: true, subtree: true };

        // Comenzar a observar el formulario
        observer.observe(form, config);

        // Ejecutar la validación inicialmente
        habilitarBoton(form, boton);
    });
})