<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATLAS | Datos</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroFamiliares.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "cssUtils/switch.css"; ?>">
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
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Datos Empleados</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <div class="container-fluid px-3">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="card contenTable" style="background-color: white; box-shadow: none;">
                                <div class="contenTablet mitable table-responsive">
                                    <!-- Boton Switch -->
                                    <div class="card radio-inputs m-2" style="flex-direction: row; box-shadow: none;">
                                        <label class="radio ">
                                            <input name="radio" id="switchDepe" type="radio" />
                                            <span class="name card">Dependencia</span>
                                        </label>
                                        <label class="radio">
                                            <input name="radio" id="switchCargo" type="radio" />
                                            <span class="name">Cargo</span>
                                        </label>
                                        <label class="radio">
                                            <input name="radio" id="switchEstatus" type="radio" />
                                            <span class="name">Estatus</span>
                                        </label>
                                        <label class="radio">
                                            <input name="radio" id="switchDepa" type="radio" />
                                            <span class="name">Departamentos</span>
                                        </label>
                                    </div>
                                    <div class="container">
                                        <button class="mt-2 btn btn-primary btn-sm btn-hover-azul" id="btnAgregarDependencia"><i class="fa-solid fa-plus fa-sm me-2"></i>Agregar</button>
                                        <button class="mt-2 btn btn-primary btn-sm btn-hover-azul" id="btnAgregarCargo"><i class="fa-solid fa-plus fa-sm me-2"></i>Agregar</button>
                                        <button class="mt-2 btn btn-primary btn-sm btn-hover-azul" id="btnAgregarEstatus"><i class="fa-solid fa-plus fa-sm me-2"></i>Agregar</button>
                                        <button class="mt-2 btn btn-primary btn-sm btn-hover-azul" id="btnAgregarDepartamento"><i class="fa-solid fa-plus fa-sm me-2"></i>Agregar</button>
                                    </div>
                                    <table id="tableInic" class="mitable table table-hover nowrap display">
                                        <thead>
                                            <tr id="tr-identity" class="tr-identity">
                                            </tr>
                                        </thead>
                                        <tbody class="contenidoTable">
                                        </tbody>
                                    </table>
                                </div>
                                <div style="background-color:#FE9001;" class="barra_naranja"></div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

    <!-- Modal Dependencia-->
    <div class="modal fade" id="modalDependencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registro Dependencias</h1>
                    <i type="button" data-bs-dismiss="modal" aria-label="Close" class="cerrarEditar close fa-solid fa-xmark"></i>
                </div>
                <div class="modal-body formDependencia" id="modal-body">
                    <div class="container-fluid p-4">
                        <section class=" card" style="background-color: white; box-shadow: none;">
                            <form action="" method="post" class="formularioDepen p-3" accept-charset="UTF-8">
                                <div class="row">
                                    <div class="section-body col-lg-12">
                                        <input type="text" value="" id="identificador_depe" class="cumplido" name="id" hidden>
                                        <div class="col-sm-12 col-md-12 col-xl-12 col-xxl-12 mb-3">
                                            <div class="form-group">
                                                <label for="dependencia">Nombre Dependencia</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_dependencia"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="dependencia" name="dependencia" placeholder="Nombre de la dependencia" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-xl-12 col-xxl-12 mb-3">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_estado"><i class="icons fa-regular fa-user"></i></span>
                                                    <select class="form-select form-select-md estado-estado" id="estado" name="estado" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                        <option value="">Selecione de estado</option>d
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-xl-12 col-xxl-12 mb-3">
                                            <div class="form-group">
                                                <label for="codigo">Codigo de Dependencia</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_codigo"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo de la dependencia" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                        <div style="background-color:#FE9001;" class="barra_naranja"></div>

                    </div>
                    <div class="modal-footer p-1">
                        <button type="button" class="btn btn-warning sinCodigo" id="sinCodigo">Sin Codigo</button>
                        <button type="submit" class="btn btn-primary aceptar" id="aceptar">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cargo-->
    <div class="modal fade" id="modalCargo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registro Cargo</h1>
                    <i type="button" data-bs-dismiss="modal" aria-label="Close" class="cerrarEditar close fa-solid fa-xmark"></i>
                </div>
                <div class="modal-body formCargo" id="modal-body">
                    <div class="container-fluid p-4">
                        <section class=" card" style="background-color: white; box-shadow: none;">
                            <form action="" method="post" class="formularioCargo p-3">
                                <div class="row">
                                    <div class="section-body col-lg-12">
                                        <div class="col-sm-12 col-md-12 col-xl-12 col-xxl-12 mb-3">
                                            <input type="text" value="" id="identificador_cargo" class="cumplido" name="id" hidden>
                                            <div class="form-group">
                                                <label for="cargo">Nombre Del Cargo</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_cargo"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Nombre de la dependencia" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                        <div style="background-color:#FE9001;" class="barra_naranja"></div>

                    </div>
                    <div class="modal-footer p-1">
                        <button type="submit" class="btn btn-primary aceptar" id="aceptar">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Estatus-->
    <div class="modal fade" id="modalEstatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registro Estatus</h1>
                    <i type="button" data-bs-dismiss="modal" aria-label="Close" class="cerrarEditar close fa-solid fa-xmark"></i>
                </div>
                <div class="modal-body formEstatus" id="modal-body">
                    <div class="container-fluid p-4">
                        <section class=" card" style="background-color: white; box-shadow: none;">
                            <form action="" method="post" class="formularioEstatus p-3">
                                <div class="row">
                                    <div class="section-body col-lg-12">
                                        <div class="col-sm-12 col-md-12 col-xl-12 col-xxl-12 mb-3">
                                            <input type="text" value="" id="identificador_estatus" class="cumplido" name="id" hidden>
                                            <div class="form-group">
                                                <label for="estatus">Nombre Del Estatus</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_estatus"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="estatus" name="estatus" placeholder="Nombre de la dependencia" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                        <div style="background-color:#FE9001;" class="barra_naranja"></div>
                    </div>
                    <div class="modal-footer p-1">
                        <button type="submit" class="btn btn-primary aceptar" id="aceptar">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Departamento-->
    <div class="modal fade" id="modalDepartamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registro Departamento</h1>
                    <i type="button" data-bs-dismiss="modal" aria-label="Close" class="cerrarEditar close fa-solid fa-xmark"></i>
                </div>
                <div class="modal-body formDepartamento" id="modal-body">
                    <div class="container-fluid p-4">
                        <section class=" card" style="background-color: white; box-shadow: none;">
                            <form action="" method="post" class="formularioDepa p-3">
                                <div class="row">
                                    <div class="section-body col-lg-12">
                                        <div class="col-sm-12 col-md-12 col-xl-12 col-xxl-12 mb-3">
                                            <input type="text" value="" id="identificador_depa" class="cumplido" name="id" hidden>
                                            <div class="form-group">
                                                <label for="departamento">Nombre Del Departamento</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_departamento"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Nombre de la dependencia" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="background-color:#FE9001;" class="barra_naranja"></div>
                        </section>
                    </div>
                    <div class="modal-footer p-1">
                        <button type="submit" class="btn btn-primary aceptar" id="aceptar">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "datosDecd.js" ?>" type="module"></script>

</body>

</html>