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
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <div class="container-fluid px-3">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="card contenTable" style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                            <div class="contenTablet mitable table-responsive">
                                <!-- Boton Switch
                                        <div class="togglewrapper m-2">
                                            <input type="checkbox" name="" id="dn" class="dn">
                                            <label for="dn" class="toggle bg-primary">
                                                <span class="toggle_handler"></span>
                                            </label>
                                        </div> -->
                                <table id="myTable" class="mitable table table-striped  table-hover nowrap display">
                                    <thead>
                                        <tr>
                                            <th scope="col" id="cedula" class="bg-primary">Cédula</th>
                                            <th scope="col" class="bg-primary">Nombre</th>
                                            <th scope="col" class="bg-primary">Estatus</th>
                                            <th scope="col" class="bg-primary">Dependencia</th>
                                            <th scope="col" class="bg-primary">Cargo</th>
                                            <th scope="col" class="bg-primary">Departamento</th>
                                            <th scope="col" class="bg-primary">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div style="background-color:#FE9001;" class="barra_naranja"></div>
                        </section>
                    </div>
                </div>

            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>


    <!-- Modal para editar datos de empelados-->
    <div class="modal  fade modal-xl" id="editarDatos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Datos</h1>
                    <i type="button" data-bs-dismiss="modal" aria-label="Close" class="cerrarEditar close fa-solid fa-xmark"></i>
                </div>
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="container-fluid card p-2" style="background-color: #f5f5f5; box-shadow: none;">
                            <section class="card p-2" style="background-color: white; box-shadow: none;">
                                <form action="#" class="row contact-form form-validate d-flex justify-content-center" novalidate="novalidate" id="formularioActualizar">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-10">
                                        <div class="row col-sm-12 col-md-7  h-100  w-100 p-2">
                                            <p class="mb-0 mt-2">Datos Personales</p>
                                            <hr class="mb-2">
                                            <input type="text" class="form-control cumplido" id="idEmpleado" name="id" placeholder="Primer Nombre" required hidden>
                                            <div class="col-sm-6 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label for="primerNombre">Primer Nombre</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label for="segundoNombre">Segundo Nombre</label>
                                                    <div class="input-group ">
                                                        <span class="input-group-text span_nombre2"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label for="primerApellido">Primer Apellido</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label for="segundoApellido">Segundo Apellido</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_apellido2"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label for="cedulaEdi">Cédula</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_cedula"><i class="icons fa-regular fa-address-card"></i></span>
                                                        <input type="text" class="form-control" id="cedulaEdi" name="cedula" placeholder="Cédula de Identidad" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label for="civil">Estado civil</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_civil"><i class="icons fa-regular fa-clipboard"></i></span>
                                                        <select class="form-select form-select-md estado-civil" id="civil" name="civil" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Estado civil</option>
                                                            <option value="Soltero">Soltero</option>
                                                            <option value="Casado">Casado</option>
                                                            <option value="Viudo">Viudo</option>
                                                            <option value="Divorciado">Divorciado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="mb-0 mt-2">Fecha de nacimiento</p>
                                            <hr class="mb-2">

                                            <div class="col-sm-12 col-md-4 mb-2 ">
                                                <div class="form-group">
                                                    <label class="required-field" for="message">Año</label>
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

                                            <p class="mb-0 mt-2">Datos Del Trabajador</p>
                                            <hr class="mb-2">

                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <button type="button" id="cargaNoti" class="btn btn-primary btn-xs"><i class="fa-solid fa-plus me-2"></i>Actualizar notificacion</button>
                                                <button type="button" id="cargaContrato" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Actualizar Contrato</button>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-2" id="contentTelefono">
                                                <label class="form-label mb-0" for="telefono">N.Telefono</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_telefono"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-2">
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

                                            <div class="col-sm-12 col-md-4 mb-2">
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

                                            <div class="col-sm-12 mt-3 ">
                                                <button type="submit" id="aceptar_empleado" name="submit" class="btn btn-success" data-bs-dismiss="modal">
                                                    Actualizar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cerrarEditar btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fa-solid fa-arrow-right me-2"></i>Cerrar
                    </button>
                </div>
                <div style="background-color:#FE9001;" class="barra_naranja"></div>
            </div>
        </div>
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
                        <div class="container-fluid card p-2" style="background-color: #f5f5f5; box-shadow: none;">
                            <section class="card p-2" style="background-color: white; box-shadow: none;">
                                <table id="myTable2" class="mitable table table-striped table-hover nowrap display">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="bg-primary">Nombre</th>
                                            <th scope="col" class="text-center bg-primary">Cédula</th>
                                            <th scope="col" class="text-center bg-primary">Carnet</th>
                                            <th scope="col" class="text-center bg-primary">Edad</th>
                                            <th scope="col" class="text-center bg-primary">Tomo</th>
                                            <th scope="col" class="text-center bg-primary">Folio</th>
                                            <th scope="col" class="text-center bg-primary">Acciones</th>
                                            <th scope="col" class="text-center bg-primary">Documento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </section>
                        </div>
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


    <!-- Modal para editar familiar-->
    <div class="modal  fade modal-lg" id="editarDatosFamiliar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Datos</h1>
                    <i type="button" data-bs-dismiss="modal" aria-label="Close" class="cerrarEditar close fa-solid fa-xmark"></i>
                </div>
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="container-fluid card p-2" style="background-color: #f5f5f5; box-shadow: none;">
                            <section class="card p-2" style="background-color: white; box-shadow: none;">
                                <form action="#" class="row contact-form form-validate d-flex justify-content-center formulario-familia" novalidate="novalidate" id="forActualizarFamiliar">
                                    <div class=" col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 ">
                                        <div class="row col-sm-12 col-md-9 h-100 bg-white w-100 p-2 m-0 content">
                                            <p class="mb-0 mt-2">Datos del Empleado</p>
                                            <hr class="mb-3">
                                            <div class="col-sm-4 mb-2">
                                                <label class="form-label mb-0" for="cedula_trabajador">Cédula</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_cedula_empleado "><i class="icons fa-regular fa-address-card"></i></span>
                                                    <input type="text" class="form-control " id="cedula_trabajador_familiar" name="cedulaEmpleado" placeholder="Cédula">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label for="nombre">Nombre</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="nombreEmpleado" name="nombre" placeholder="Primer Nombre" required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label for="apellido">apellido</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="apellidoEmpleado" name="apellido" placeholder="Primer Nombre" required readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="mb-0 mt-2">Datos Del Familiar</p>
                                            <hr class="mb-3">
                                            <div class=" d-flex justify-content-center">
                                                <!-- CHECK NO CEDULADO -->
                                                <div class="checkbox-wrapper-12 d-flex me-3">
                                                    <div class="cbx ">
                                                        <input id="noCedula" class="cumplidoNormal" type="checkbox" />
                                                        <label for="noCedula"></label>
                                                        <i class="icons fa-solid fa-check fa-xs"></i>
                                                    </div>
                                                    <p>No Cédulado</p>
                                                </div>

                                                <!-- CHECK DE DISCAPACIDAD -->
                                                <div class="checkbox-wrapper-12 d-flex">
                                                    <div class="cbx ">
                                                        <input id="disca" class="cumplidoNormal" type="checkbox" />
                                                        <label for="disca"></label>
                                                        <i class="icons fa-solid fa-check fa-xs"></i>
                                                    </div>
                                                    <p>Discapacidad</p>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <button type="button" id="cargaPartiNacimiento" class="btn btn-primary btn-xs"><i class="fa-solid fa-plus me-2"></i>Partida De Nacimiento</button>
                                                <button type="button" id="cargaDiscapacidad" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Documento De Discapacidad</button>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="primerNombre">Primer Nombre</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_nombre1"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="primerNombreFamiliar" name="primerNombre" placeholder="Primer Nombre" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="segundoNombre">Segundo Nombre</label>
                                                    <div class="input-group ">
                                                        <span class="input-group-text span_nombre2"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="segundoNombreFamiliar" name="segundoNombre" placeholder="Segundo Nombre" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="primerApellido">Primer Apellido</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_apellido1"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="primerApellidoFamiliar" name="primerApellido" placeholder="Primer Apellido" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3" id="contenApellidoDos">
                                                <div class="form-group">
                                                    <label for="segundoApellido">Segundo Apellido</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_apellido2"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control" id="segundoApellidoFamiliar" name="segundoApellido" placeholder="segundo Apellido" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3" hidden=="true">
                                                <div class="form-group">
                                                    <label for="identificador">identificador</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_identificador span_cumplido"><i class="icons fa-regular fa-user"></i></span>
                                                        <input type="text" class="form-control cumplido" id="identificador" name="idfamiliar" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3" id="contenCedula">
                                                <div class="form-group">
                                                    <label for="cedula">Cédula</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_cedula_familiar "><i class="icons fa-regular fa-address-card"></i></span>
                                                        <input type="text" class="form-control ignore-validation" id="cedula_familiar" name="cedula" placeholder="Cédula de Identidad" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3 ">
                                                <div class="form-group">
                                                    <label for="parentesco">Parentesco</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_parentesco"><i class="icons fa-regular fa-clipboard"></i></span>
                                                        <select class="form-select form-select-md estado-parentesco" id="parentesco" name="parentesco" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione</option>
                                                            <option value="Hijo">Hijo</option>
                                                            <option value="Hija">Hija</option>
                                                            <option value="Padre">Padre</option>
                                                            <option value="Madre">Madre</option>
                                                            <option value="Hermano">Hermano</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3" id="contenTomo">
                                                <div class="form-group">
                                                    <label for="tomo">Tomo</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_tomo"><i class="fa-regular fa-address-card"></i></span>
                                                        <input type="text" class="form-control ignore-validation" id="tomo" name="tomo" placeholder="Tomo De partida De Nacimiento" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3" id="contenFolio">
                                                <div class="form-group">
                                                    <label for="folio">Folio</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_folio"><i class="fa-regular fa-address-card"></i></span>
                                                        <input type="text" class="form-control ignore-validation" id="folio" name="folio" placeholder="Número de folio" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3" id="contenCarnet">
                                                <div class="form-group">
                                                    <label for="cedula">Número de Carnet de Discapacidad</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_carnet"><i class="fa-regular fa-address-card"></i></span>
                                                        <input type="text" class="form-control ignore-validation" id="carnet" name="carnet" placeholder="Cédula de Identidad" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3" id="contenDoc">
                                                <div class="form-group">
                                                    <label for="correo">Partida De Nacimiento</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_docArchivo"><i class="fa-regular fa-file-zipper"></i></span>
                                                        <input type="file" class="form-control ignore-validation" name="docArchivo" id="achivoparti" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3" id="contentPartida">
                                                <div class="form-group">
                                                    <label for="correo">Partida De Discapacidad</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_docArchivoDis"><i class="fa-regular fa-file-zipper"></i></span>
                                                        <input type="file" class="form-control ignore-validation" name="docArchivoDis" id="achivoDis" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 mb-3" id="contenEdad">
                                                <div class="form-group">
                                                    <label for="edad">Edad</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_edad"><i class="icons fa-regular fa-user-clock"></i></span>
                                                        <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad Del Familiar" required readonly>
                                                    </div>
                                                    <p class="parrafo fs-6 fw-light mb-0">La edad del familiar se ingresa automáticamente con la fecha de nacimiento.</p>
                                                </div>
                                            </div>

                                            <p class="mb-0">Fecha de nacimiento</p>
                                            <hr class="mb-2">

                                            <div class="col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label class="required-field" for="message">Año</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_ano_familiar"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select form-select-md" name="ano" id="anoFamiliar" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label class="required-field" for="message">Mes</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_mes_familiar"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select meses2" id="mesesFamiliar" name="meses" aria-label="Default select example" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <div class="form-group ">
                                                    <label class="required-field" for="message">Día</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_dia_familiar"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select w-5 dias" id="diaFamiliar" name="dia" aria-label="Default select example" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 ">
                                                <button type="submit" id="aceptar_familia" name="aceptar2" class="btn btn-success " disabled>
                                                    <i class="fa-solid fa-plus me-2"></i>Aceptar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cerrarEditar btn btn-secondary btn-sm" data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-dismiss="modal">
                        <i class="fa-solid fa-arrow-right me-2"></i>Cerrar
                    </button>
                </div>
                <div style="background-color:#FE9001;" class="barra_naranja"></div>
            </div>
        </div>
    </div>

    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>

    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "registroFamiliar.js" ?>" type="module"></script>

</body>

</html>