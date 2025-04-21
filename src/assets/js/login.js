import { enviarDatos, enviarFormulario, generarHashContrasena, verificarContrasena } from "./utils/formularioAjax.js";
import { AlertDirection, AlertSW2 } from "./utils/alerts.js";

/**
 * Módulo Login: gestiona todas las funciones relacionadas con el inicio de sesión
 */
const ModuloLogin = (() => {
  // Selectores del DOM
  const Selectores = {
    formulario: '.formularioEnviar',
    candado: '#candado',
    password: '#password',
    passwordIcon: '.password',
    alert: '#alert',
    usuario: '#usuario',
    cargando: '#cargando'
  };

  // Constantes para mensajes
  const Mensajes = {
    CAMPOS_VACIOS: "Debes de llenar todos los campos.",
    USUARIO_VACIO: "Por favor, ingresa su nombre de usuario.",
    PASSWORD_VACIO: "Por favor, ingresa su contraseña.",
    PASSWORD_INCORRECTO: "La contraseña es incorrecta"
  };

  // Endpoints de API
  const Endpoints = {
    login: './src/ajax/userAjax.php?modulo_usuario=login',
    redireccion: './src/ajax/userAjax.php?modulo_usuario=redireccionar'
  };

  /**
   * Maneja el cambio de visibilidad de la contraseña
   */
  const manejarVisibilidadPassword = () => {
    const passwordIcon = $(Selectores.passwordIcon);
    const password = $(Selectores.password);

    $(Selectores.candado).on('click', function() {
      const isText = password.attr('type') === 'text';
      
      passwordIcon
        .toggleClass('fa-solid fa-lock', !isText)
        .toggleClass('fa-key', isText);
      
      password.attr('type', isText ? 'password' : 'text');
    });
  };

  /**
   * Maneja el envío del formulario de login
   */
  const manejarEnvioFormulario = () => {
    $(Selectores.formulario).on('submit', function(e) {
      e.preventDefault();
      
      const usuario = $(Selectores.usuario);
      const password = $(Selectores.password);
      const usuarioValor = usuario.val().trim();
      const passwordValor = password.val().trim();

      // Validaciones
      if (!usuarioValor && !passwordValor) {
        AlertSW2("error", Mensajes.CAMPOS_VACIOS, "top", 4000);
        return;
      }
      
      if (!usuarioValor) {
        AlertSW2("warning", Mensajes.USUARIO_VACIO, "top", 4000);
        return;
      }
      
      if (!passwordValor) {
        AlertSW2("warning", Mensajes.PASSWORD_VACIO, "top", 4000);
        return;
      }

      // Mostrar cargando
      $(Selectores.cargando).css('display', 'flex');

      // Preparar datos del formulario
      const formData = new FormData(this);
      formData.append('modulo_usuario', 'login');

      // Función de callback para el éxito
      const callbackExito = (parsedData) => {
        $(Selectores.cargando).hide();

        if (parsedData.exito) {
          const hashAlmacenado = parsedData.password;
          const saltAlmacenada = parsedData.salt;

          if (verificarContrasena(passwordValor, hashAlmacenado, saltAlmacenada)) {
            const redireccion = () => {
              const formData = new FormData();
              formData.append('url', 'inicio');
              enviarDatos(Endpoints.redireccion, formData);
            };
            
            AlertDirection("success", "Inicio de sesión con éxito, Redireccionando", "top", 3000, redireccion);
          } else {
            AlertSW2("error", Mensajes.PASSWORD_INCORRECTO, "top", 4000);
          }
        } else {
          AlertSW2("error", parsedData.mensaje, "top", 4000);
        }
      };

      // Enviar formulario
      enviarFormulario(Endpoints.login, formData, callbackExito, true);
    });
  };

  /**
   * Inicializa el módulo de login
   */
  const inicializar = () => {
    manejarVisibilidadPassword();
    manejarEnvioFormulario();
  };

  // Exponer métodos públicos
  return {
    inicializar
  };
})();

// Inicializar cuando el DOM esté listo
$(function() {
  ModuloLogin.inicializar();
});

