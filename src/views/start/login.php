<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicia sesión en tu cuenta para acceder a todas las funcionalidades de ATLAS, nuestro sistema de gestión de recursos humanos">
    <title>Inicio de Sesión | ATLAS</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    
</head>

<body>
    <section class="background-radial-gradient overflow-hidden">
        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="content row gx-lg-5 align-items-center ">
                <section class="col-lg-6 mb-lg-0" style="z-index: 10; color: hsl(218, 81%, 95%)" > 
                    <div class="d-flex justify-content-lenft " >
                        <h1 class="me-5 display-5 fw-bold ls-tight" >
                            <span class="atlas" style="color: #3243E2; font-size:4rem;">ATLAS SISTEMA </span>
                        </h1>
                    </div>
                    <span class="fw-bold " style="font-size:2rem;">PARA RECURSOS HUMANOS</span>
                    <p class=" mb-4 mt-3 opacity-70" style="color: hsl(218, 81%, 85%)">
                        Solución tecnológica integral para la optimizando procesos y
                        automatización de tareas administrativas en el departamento
                        de Recursos Humanos.
                    </p>
                </section>

                <section class="col-lg-4 mb-5 mb-lg-0 position-relative contenedorLogin" style="border-color: none;">
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                    <div class="cuerpoFrom bg-glass w-0">
                        <div class="header rounded-top">
                            <img src="./inces.png" alt="">
                        </div>
                        <div class="text-center py-2">
                           <h3 style="color: #D7D7D7;">INICIO SESION</h3>
                        </div>
                        <div class=" pl-4 py-1 px-md-5">
                            <form>
                                <!-- usuario input -->
                                <label class="" for="form3Example3">Usuario</label>
                                <div data-mdb-input-init class="form-outline mb-3 input-group flex-nowrap" >
                                    <span class="input-group-text" id="addon-wrapping">@</span>
                                    <input type="text" id="form3Example3" class="form-control  p-2" placeholder="Usuario" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                                                          
                                <!-- contraseña input -->
                                <label class="" for="contraseña">Contraseña</label>
                                <div data-mdb-input-init class="form-outline mb-3 input-group flex-nowrap" >
                                    <span class="input-group-text" id="addon-wrapping">@</span>
                                    <input type="password" id="contraseña" class="form-control p-2" placeholder="Contraseña" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>  

                                <!-- Submit button --> 
                                 <div class="d-flex justify-content-center">
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                                        Iniciar
                                    </button>
                                 </div>
                            </form>
                        </div>
                        <!-- barra -->
                        <div class="colorNaranja" id="naranja">s</div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <section>

    </section>
</body>

</html>