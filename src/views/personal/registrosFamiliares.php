<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATLAS | Registros</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "Utils/checkbox.css"; ?>">
    <!-- <link rel="stylesheet" href="./src/libs/jQueryUI/jquery-ui.min.css">
    <link rel="stylesheet" href="./src/libs/jQueryUI/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="./src/libs/jQueryUI/jquery-ui.theme.min.css"> -->

    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroFamiliares.css"; ?>">

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0 pb-4">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registros Del Personal Y Familiares</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.webp"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <div class="container-fluid px-3">
                <div class="card text-center" id="cardID1" style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                    <div class="card-header py-3">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item me-3">
                                <a class="d-flex justify-content-center align-items-baseline icon-link reporteTrabajador " id="reporteTrabajador" href="pdf">
                                    <i class="bi bi-file-pdf"></i>Reportes PDF
                                </a>

                            </li>
                            <li class="nav-item me-3">
                                <a class="d-flex justify-content-center align-items-baseline icon-link reporteTrabajador " id="reporteTrabajador" href="excel">
                                    <i class="bi bi-file-earmark-spreadsheet"></i>Reportes EXCEL
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="card contenTable" id="contenTable" style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                            <div class="contenTablet mitable table-responsive">
                                <!-- Boton Switch
                                        <div class="togglewrapper m-2">
                                            <input type="checkbox" name="" id="dn" class="dn">
                                            <label for="dn" class="toggle bg-primary">
                                                <span class="toggle_handler"></span>
                                            </label>
                                        </div> -->

                                <table id="myTable" class="mitable table-bordered table table-hover nowrap display">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-dt-order="disable" id="cedula" class="bg-primary" style="font-size: 14px;">Cédula</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Nombres</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Apellidos</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Sexualidad</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Fecha Nacimiento</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Estado Civil</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Nivel Academico</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Telefono</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Estatus</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Dependencia</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Cargo</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Departamento</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Fecha Ingreso</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Vivienda</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Estado</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Municipio</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Parroquia</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Direcciones</th>
                                            <th scope="col" data-dt-order="disable" class="bg-primary" style="font-size: 14px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px;">
                                    </tbody>
                                </table>
                            </div>
                            <div style="background-color:#FE9001;" class="barra_naranja"></div>
                        </section>
                    </div>
                </div>

                <!-- card para editar -->
                <div class="card mt-2" id="editarDatos" hidden style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                    <div class="card-header text-white p-3" style="background-color: #1929bb !important;">
                        <h5 class=" text-white m-0">Editar Datos</h5>
                    </div>

                    <form action="#" class="contact-form form-validate" id="formularioActualizar">
                        <div class="card-body p-0" style="font-size: 14px;">
                            <div class="container-fluid px-4">
                                <div class="row  d-flex " novalidate="novalidate">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                        <div class="row col-sm-12 col-md-7  h-100  w-100 p-2">
                                            <p class="mb-0 mt-2">Datos Personales</p>
                                            <hr class="mb-2">
                                            <input type="text" class="form-control cumplido" id="idEmpleado" name="id" placeholder="id personal" required hidden>
                                            <input type="text" class="form-control cumplido" id="idEmpleado2" name="idEmpleado" placeholder="id empleado" required hidden>
                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="primerNombre">Primer Nombre</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="segundoNombre">Segundo Nombre</label>
                                                    <div class="input-group ">
                                                        <span class="input-group-text span_nombre2"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="primerApellido">Primer Apellido</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="segundoApellido">Segundo Apellido</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_apellido2"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="cedulaEdi">Cédula</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_cedula"><i class="icons fa-regular fa-address-card"></i></span>
                                                        <input type="text" class="form-control" id="cedulaEdi" name="cedula" placeholder="Cédula de Identidad" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="civil">Estado civil</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_civil"><i class="icons fa-regular fa-handshake"></i></span>
                                                        <select class="form-select form-select-md estado-civil" id="civil" name="civil" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Estado civil</option>
                                                            <option value="Soltero">Soltero</option>
                                                            <option value="Casado">Casado</option>
                                                            <option value="Viudo">Viudo</option>
                                                            <option value="Divorciado">Divorciado</option>
                                                            <option value="EstadoDerecho">Estado De Derecho</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="sexo">Sexualidad</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_sexo"><i class="icons fa-regular fa-person-half-dress"></i></span>
                                                        <select class="form-select form-select-md sexo-sexo" id="sexo" name="sexo" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione el sexo</option>
                                                            <option value="Masculino">Masculino</option>
                                                            <option value="Femenino">Femenino</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-2 mb-2" id="contentEdad">
                                                <div class="form-group">
                                                    <label for="edadEmp">Edad</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_edadEmp"><i class="icons fa-regular fa-user-clock"></i></span>
                                                        <input type="number" class="form-control" id="edadEmp" name="edad" placeholder="Edad del personal" required readonly>
                                                    </div>
                                                    <p class="parrafo fs-6 fw-light mb-0">La edad se autocompleta con la fecha de nacimiento</p>
                                                </div>
                                            </div>

                                            <p class="mb-0 mt-2">Fecha de nacimiento</p>
                                            <hr class="mb-2">

                                            <div class="col-sm-12 col-md-4 mb-2 ">
                                                <div class="form-group">
                                                    <label class="required-field" for="ano2">Año</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_ano"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select form-select-md" name="ano" id="ano2" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="required-field" for="message">Mes</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_mes"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select meses2" id="meses2" name="meses" aria-label="Default select example" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-2">
                                                <div class="form-group ">
                                                    <label class="required-field" for="message">Día</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_dia"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select w-5 dias" id="dia2" name="dia" aria-label="Default select example" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="mb-0 mt-1">Ubicación</p>
                                            <hr class="mb-2">

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="estado">Estado</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_estado"><i class="icons fa-regular fa-location-dot"></i></span>
                                                        <select class="form-select form-select-md estado-estado" id="estado" name="estado" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione un estado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="municipio">Municipio</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_municipio"><i class="icons fa-regular fa-location-dot"></i></span>
                                                        <select class="form-select form-select-md municipio-municipio" id="municipio" name="municipio" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Seleccione un municipio</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="parroquia">Parroquia</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_parroquia"><i class="icons fa-regular fa-location-dot"></i></span>
                                                        <select class="form-select form-select-md parroquia-parroquia" id="parroquia" name="parroquia" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione un parroquia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="vivienda">Vivienda</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_vivienda"><i class="icons fa-regular fa-house-building"></i></span>
                                                        <select class="form-select form-select-md vivienda-vivienda" id="vivienda" name="vivienda" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione un vivienda</option>
                                                            <option value="Casa">Casa</option>
                                                            <option value="Departamento">Departamento</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2" id="contenCalle">
                                                <div class="form-group">
                                                    <label for="calle">Calle</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_calle"><i class="icons fa-regular fa-road"></i></span>
                                                        <input type="text" class="form-control" id="calle" name="calle" placeholder="Nombre de la Calle" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="mb-0 mt-2">Datos Del Trabajador</p>
                                            <hr class="mb-2">

                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <div class="col-sm-12 col-md-12 " id="contenButton">

                                                </div>
                                                <button type="button" id="cargaNoti" class="btn btn-sm btn-primary btn-xs  btn-hover-azul mb-2"><i class="fa-solid fa-plus me-2"></i>Actualizar notificacion</button>
                                                <button type="button" id="cargaContrato" class="btn btn-sm btn-primary btn-xs btn-hover-azul mb-2"><i class="fa-solid fa-plus me-2"></i>Actualizar Contrato</button>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2" id="contentIngreso">
                                                <div class="form-group">
                                                    <label for="fechaing">Fecha Ingreso</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_fechaing"><i class="icons fa-regular fa-calendars"></i></span>
                                                        <input type="text" class="form-control fechaing" id="fechaing" name="fechaing2" placeholder="Fecha de Ingreso" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <label class="form-label mb-0" for="telefono">N.Telefono</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_telefono"><i class="icons fa-regular fa-mobile-notch"></i></span>
                                                    <div class="col-sm-4">
                                                        <select class="form-select" name="linea" id="linea" style="border-radius: 0px;">
                                                            <option value=" ">Línea</option>
                                                            <option value="0412">0412</option>
                                                            <option value="0416">0416</option>
                                                            <option value="0424">0424</option>
                                                            <option value="0426">0426</option>
                                                        </select>
                                                    </div>

                                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="estatus">Estatus</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_estatus"><i class="icons fa-regular fa-clipboard"></i></span>
                                                        <select class="form-select form-select-md estado-estatus" id="estatus" name="estatus" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione un estatus</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="cargo">Cargo</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_cargo"><i class="icons fa-regular fa-clipboard"></i></span>
                                                        <select class="form-select form-select-md estado-cargo" id="cargo" name="cargo" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione un cargo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6 mb-2">
                                                <div class="form-group">
                                                    <label for="departamento">Departamento</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_departamento"><i class="icons fa-regular fa-clipboard"></i></span>
                                                        <select class="form-select form-select-md estado-departamento" id="departamento" name="departamento" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione un departamento</option>d
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6 mb-2">
                                                <div class="form-group">
                                                    <label for="dependencia">Estado dependencia</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_dependencia"><i class="icons fa-regular fa-clipboard"></i></span>
                                                        <select class="form-select form-select-md estado-dependencia" id="dependencia" name="dependencia" aria-describedby="dependencia" required>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label for="academico">Nivel Academico</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_academico"><i class="icons fa-regular fa-user-graduate"></i></span>
                                                        <select class="form-select form-select-md" id="academico" name="nivelAcademico">
                                                            <option value="">Nivel Academico</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="col-sm-12  d-flex justify-content-between ">
                                    <button type="submit" id="aceptar_empleado" name="submit" class="btn-sm btn btn-success btn-hover-verde" data-bs-dismiss="modal">
                                        <i class="fa-solid fa-thumbs-up fa-sm me-2"></i>Actualizar
                                    </button>

                                    <button type="button" id="cerrarEdit" class="btn-sm btn btn-secondary btn-hover-gris">
                                        <i class="fa-regular fa-xmark-large fa-sm me-2"></i>Cerrar
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>

            </div>

            <!-- GENERAR REPORTES DE EMPELADOS PDF -->
            <div class="card mt-2" hidden id="datosReporte" style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                <div class="card-header" id="cabeza-reporte" style="background-color: #1929bb !important;">
                    Generar reportes PDF
                </div>
                <form action="#" class="contact-form  form-validate formulario-descargarpdf formdata " id="formulario-descargarpdf">
                    <div class="card-body" id="contentBodyCard">

                    </div>
                    <div class="card-footer">
                        <div class="col-sm-12  d-flex justify-content-between " id="buttonBody">
                            <button type="button" id="cerrarReport" class="btn-sm btn btn-secondary btn-hover-gris">
                                <i class="fa-regular fa-xmark-large fa-sm me-2"></i> Cerrar
                            </button>

                            <button type="submit" id="descargarReporte2" name="submit" class="btn-sm btn btn-danger btn-hover-rojo" >
                                <i class="fa-regular fa-file-pdf fa-sm me-2"></i>Generar PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

    <!-- Modal Familiar-->
    <div class="modal  fade modal-xl " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Familiares</h1>
                    <i type="button" data-bs-dismiss="modal" aria-label="Close" class="close fa-solid fa-xmark"></i>
                </div>
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <section class="card p-2" style="background-color: white; box-shadow: none;">
                            <table id="myTable2" class="mitable table table-bordered table-hover nowrap display">
                                <thead>
                                    <tr>
                                        <th scope="col" class="bg-primary" style="font-size: 14px;">Nombre</th>
                                        <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Cédula</th>
                                        <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Carnet</th>
                                        <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Edad</th>
                                        <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Tomo</th>
                                        <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Folio</th>
                                        <!-- <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Acciones</th> -->
                                        <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Documentación</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 14px;">
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fa-solid fa-arrow-right me-2"></i>Cerrar
                    </button>
                </div>
                <div style="background-color:#FE9001;" class="barra_naranja"></div>
            </div>
        </div>
    </div>

    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>

    <script src="<?php echo App::URL_SCRIPS . "registroFamiliar.js" ?>" type="module" defer></script>
    <script src="<?php echo App::URL_SCRIPS . "reportesEmpleado.js" ?>" type="module" defer></script>

</body>

</html>