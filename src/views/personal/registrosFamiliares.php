<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroFamiliares.css"; ?>">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0 pb-4">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registros del Personal</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "menu_registro.php" ?>
            <div class="container-fluid px-4">
                <div class="container-fluid card p-2" style="background-color: #f5f5f5; box-shadow: none;">
                    <div class="">
                        <div class="row">
                            <div class="col-lg-12">
                                <section class="card contenTable" style="background-color: white; box-shadow: none;">
                                    <div class="contenTablet mitable table-responsive">
                                        <!-- Boton Switch -->
                                        <div class="togglewrapper m-2">
                                            <input type="checkbox" name="" id="dn" class="dn">
                                            <label for="dn" class="toggle bg-primary">
                                                <span class="toggle_handler"></span>
                                            </label>
                                        </div>
                                        <table id="myTable" class="mitable table table-striped table-bordered table-hover nowrap display">
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
                </div>
            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>



    <!-- Modal Familiar-->
    <div class="modal  fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Familiares</h1>
                    <i type="button" data-bs-dismiss="modal" aria-label="Close" class="close fa-solid fa-xmark"></i>
                </div>
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="container-fluid card p-2" style="background-color: #f5f5f5; box-shadow: none;">
                            <section class="card p-2" style="background-color: white; box-shadow: none;">
                                <table id="myTable2" class="mitable table table-striped table-bordered table-hover nowrap display">
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


    <!-- Modal para editar-->
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
                                    <div class="col-sm-12 col-md-7 col-lg-7 col-xl-12 col-xxl-8">
                                        <div class="row col-sm-12 col-md-7  h-100  w-100 p-2">
                                            <p class="mb-0 mt-2">Datos del Personal</p>
                                            <hr class="mb-2">
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
                                                            <option value="soltero">Soltero</option>
                                                            <option value="casado">Casado</option>
                                                            <option value="Viudo">Viudo</option>
                                                            <option value="Divorciado">Divorciado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="mb-0 mt-2">Fecha de nacimiento</p>
                                            <hr class="mb-2">

                                            <div class="col-sm-4 mb-2 ">
                                                <div class="form-group">
                                                    <label class="required-field" for="message">Año</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_ano"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select form-select-md" name="ano" id="ano2" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4  mb-2">
                                                <div class="form-group">
                                                    <label class="required-field" for="message">Mes</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_mes"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select" id="meses2" name="meses" aria-label="Default select example" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4  mb-2">
                                                <div class="form-group ">
                                                    <label class="required-field" for="message">Día</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_dia"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                        <select class="form-select w-5" id="dia2" name="dia" aria-label="Default select example" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="mb-0 mt-2">Datos Del Trabajador</p>
                                            <hr class="mb-2">

                                            <div class="col-sm-6 mb-2">
                                                <div class="form-group">
                                                    <label for="correo">Contrato</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_contrato"><i class="icons fa-regular fa-file-zipper"></i></span>
                                                        <input type="file" class="form-control" name="contratoArchivo" id="contrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-2">
                                                <div class="form-group">
                                                    <label for="correo">Notificación</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_notificacion"><i class="icons fa-regular fa-file-zipper"></i></span>
                                                        <input type="file" name="notacionAchivo" class="form-control" id="notificacion" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 mb-2">
                                                <label class="form-label mb-0" for="telefono">N.Telefono</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_telefono"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 mb-2">
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

                                            <div class="col-sm-4 mb-2">
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

                                            <div class="col-sm-6 mb-2">
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

                                            <div class="col-sm-6 mb-2">
                                                <div class="form-group">
                                                    <label for="dependencia">Estado dependencia</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text span_dependencia"><i class="icons fa-regular fa-clipboard"></i></span>
                                                        <select class="form-select form-select-md estado-dependencia" id="dependencia" name="dependencia" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                            <option value="">Selecione la dependencia</option>
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
                                                <button type="submit" id="aceptar" name="submit" class="btn btn-primary" data-bs-dismiss="modal">
                                                    <i class="fa-solid fa-plus me-2"></i>
                                                    Aceptar
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


    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>

    <script src="<?php echo App::URL_SCRIPS . "registroFamiliar.js" ?>" type="module"></script>

</body>

</html>