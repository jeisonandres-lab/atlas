<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicia sesión en tu cuenta para acceder a todas las funcionalidades de ATLAS, nuestro sistema de gestión de recursos humanos">
    <title>Inicio de Sesión | ATLAS</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <section class="background-radial-gradient overflow-hidden">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .background-radial-gradient {
                height: 100vh;
                background-color: hsl(218, 41%, 15%);
                background-image: radial-gradient(650px circle at 0% 0%,
                        hsl(218, 41%, 35%) 15%,
                        hsl(218, 41%, 30%) 35%,
                        hsl(218, 41%, 20%) 75%,
                        hsl(218, 41%, 19%) 80%,
                        transparent 100%),
                    radial-gradient(1250px circle at 100% 100%,
                        hsl(218, 41%, 45%) 15%,
                        hsl(218, 41%, 30%) 35%,
                        hsl(218, 41%, 20%) 75%,
                        hsl(218, 41%, 19%) 80%,
                        transparent 100%);
            }

            #radius-shape-1 {
                height: 220px;
                width: 220px;
                top: -60px;
                left: -130px;
                background: radial-gradient(#00336b, #1f60ff);
                overflow: hidden;
            }

            #radius-shape-2 {
                border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
                bottom: -60px;
                right: -110px;
                width: 300px;
                height: 300px;
                background: radial-gradient(#00336b, #1f60ff);
                overflow: hidden;
            }

            /* .bg-glass {
                background-color: hsla(0, 0%, 100%, 0.9) !important;
                backdrop-filter: saturate(200%) blur(25px);
            } */
        </style>

        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center ">
                <div class="col-lg-6 mb-lg-0" style="z-index: 10">
                    <h1 class="me-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                        <span style="color: #3243E2; font-size:4rem;">ATLAS SISTEMAS</span>
                        <span style="font-size:2rem;"> <br>DE RECURSOS HUMANOS</span>
                    </h1>

                    <p class=" mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                        Solución tecnológica integral para la optimizando procesos y
                        automatización de tareas administrativas en el departamento
                        de Recursos Humanos.
                    </p>
                </div>

                <div class="col-lg-5 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                    <div class="card bg-glass">
                        <div class="card-body pl-4 py-5 px-md-5">
                            <form>
                                <!-- usuario input -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Usuario</label>
                                    <input type="email" id="form3Example3" class="form-control" />

                                </div>

                                <!-- contraseña input -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="form3Example4">Contraseña</label>
                                    <input type="password" id="form3Example4" class="form-control" />
                                </div>

                                <!-- Submit button -->
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                                    Iniciar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>