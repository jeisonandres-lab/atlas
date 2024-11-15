<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | ATLAS</title>
    <?php require_once App::URL_INC . "icons.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS. "registroPersonal.css";?>">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper conten-main">
        <?php require_once App::URL_INC . "/menu.php"; ?>
        <main class="app-main p-0">
            <div class="imagen-pages" style="height: 17%;">
                <div class="d-flex align-items-center" style="position: absolute; height: 16%;">
                    <span class="ms-4 fw-bold fs-4 text-white">Registro del Personal</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <div class="contenForm m-2 h-100">
                <form action="#" class="contact-form form-validate h-100" novalidate="novalidate">
                    <div class="row m-0 w-50 h-100 row2">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label mb-0" for="primerNombre">Primer Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre">
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="segundoNombre">Segundo Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="primerApellido">Primer Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="segundoApellido">Segundo Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 ">
                            <div class="form-group">
                                <label for="cedula">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula de Identidad">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="civil">Estado civil</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <select class="form-select form-select-md estado-civil" id="civil" name="civil" aria-label="Small select example" aria-placeholder="dasdas">
                                        <option value="estadocivil">Estado civil</option>
                                        <option value="soltero">Soltero</option>
                                        <option value="casado">Casado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3 ">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electronico">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label class="required-field" for="message">Día</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="number" class="form-control" id="dia" name="dia">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label class="required-field" for="message">Mes</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="number" min="1" max="31" class="form-control" id="mes" name="mes">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label class="required-field" for="message">Año</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="number" class="form-control" id="ano" name="ano">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </div>
                    <div class="row row2 m-0">
                    <div class="col-md-6">
      Contenido de la primera columna de la segunda fila
    </div>
    <div class="col-md-6">
      Contenido de la segunda columna de la segunda fila
    </div>
                    </div>
                </form>
            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>
</body>

</html>