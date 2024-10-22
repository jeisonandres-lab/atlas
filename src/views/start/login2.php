<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/boxicons/css/boxicons.min.css">
    <style>
 #naranja{
    background-color: #FE9001;
    color: transparent;
    border-radius: 0px 0px 5px 5px ;
    height: 15px;
}
.header img{
    width: 115px;
    height: 50px;
}
.header{
    background-color: #F4F4F4;
    padding: 5px;
    display: flex;
    justify-content: center;
}
.atlas{
    text-shadow: 2px 4px 3px rgba(0,0,0,0.3);
    background: transparent;
}
.svg{
    background: transparent !important;
}
    </style>
</head>
<body>
    <!-- Section: Design Block -->
<section class="">
  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%); height:100vh;">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight" style="font-size:3rem;">
          <span class="text-primary atlas"style="font-size:4rem;" >ATLAS SISTEMA</span><br />
            PARA RECURSOS HUMANOS
           
          </h1>
          <p style="color: hsl(217, 10%, 50.8%)">
            Solución tecnológica integral para la optimizando procesos y
            automatización de tareas administrativas en el departamento
            de Recursos Humanos.
          </p>
        </div>

        <div class="col-lg-4 mb-5 mb-lg-0">
          <div class="card">
          <div class="header rounded-top border-bottom">
                            <img src="./inces.png" alt="">
                        </div>
            <div class="card-body py-5 px-md-5">
              <form>
              
                <!-- usuario input -->
                <label class="" for="form3Example3">Usuario</label>
                                <div data-mdb-input-init class="form-outline mb-3 input-group flex-nowrap" >
                                    <span class="input-group-text" id="addon-wrapping"><i class='bx bx-user bx-sm'></i></span>
                                    <input type="text" id="form3Example3" class="form-control  p-2" placeholder="Usuario" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                                                          
                                <!-- contraseña input -->
                                <label class="" for="contraseña">Contraseña</label>
                                <div data-mdb-input-init class="form-outline mb-3 input-group flex-nowrap" >
                                    <span class="input-group-text" id="addon-wrapping"><i class='bx bx-lock bx-sm'></i></span>
                                    <input type="password" id="contraseña" class="form-control p-2" placeholder="Contraseña" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>  

                                <!-- Submit button --> 
                                 <div class="d-flex justify-content-center">
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-1 px-3">
                                        Iniciar
                                    </button>
                                 </div>
                
              </form>
              </div>
              <div class="colorNaranja" id="naranja">s</div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
    <img src="./wave.png" alt="">
  </div>
  <!-- Jumbotron -->
    
  
</section>
<!-- Section: Design Block -->
</body>
</html>