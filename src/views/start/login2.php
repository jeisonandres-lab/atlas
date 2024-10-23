<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicia sesión en tu cuenta para acceder a todas las funcionalidades de ATLAS, nuestro sistema de gestión de recursos humanos">
    <title>Inicio de Sesión | ATLAS</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="./src/assets/css/login.css">
</head>

<body>
    <main class="principal container-fluid d-flex justify-content-center align-items-center">
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-md-4 col-sm-8 user_card">
                    <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <div class=" brand_logo d-flex align-items-center justify-content-center ">
                                <img src="./src/assets/img/icons/dasdad-transformed-removebg.png" class="brand_logo_img" alt="Logo">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center form_container">
                        <form>
                            <div class="mb-3">
                                <div class="input-group mb-3 ">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="" class="form-control input_user px-3" value="" placeholder="Usuario">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" name="" class="form-control input_pass px-3" value="" placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="button" name="button" class="btn btn-primary login_btn">Iniciar</button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            Olvidaste Los Datos De Tu Cuenta?
                        </div>
                        <div
                            class="d-flex justify-content-center links">
                            <a href="#">Recuperar Datos?</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <div id="particles-js"></div>
    <script src="./node_modules/particles.js/particles.js"></script>
    <script>
        particlesJS({
            "particles": {
                "number": {
                    "value": 50,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": false
        })
    </script>
</body>

</html>