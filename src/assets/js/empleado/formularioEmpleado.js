import { enviarFormulario } from "../utils/formularioAjax.js";
import { alertaNormalmix } from "../utils/alerts.js";
import { selectores } from "../utils/objetos.js";

/**
 * Maneja el envío del formulario
 */
export async function manejarEnvioFormulario(evento) {
  evento.preventDefault();
  const formData = new FormData(evento.target);
  const fechaIngreso = $(selectores.fechaIngreso).val().split("-").reverse().join("-");
  formData.append("fechaing", fechaIngreso);

  if ($("#btnEDInces").prop('checked')) {
    formData.append("FamiliarInces", "si");
  }

  $(selectores.btnAceptar).prop("disabled", true);

  try {
    const response = await enviarFormulario('src/routers/registroPersonal.php?modulo_personal=registrar', formData);
    $(selectores.btnAceptar).prop("disabled", false);

    if (response.exito) {
      await AlertDirection("success", response.mensaje, "top", 7000);
    } else {
      await alertaNormalmix(response.mensaje, 4000, "error", "top-end");
    }
  } catch (error) {
    console.error('Error en el envío:', error);
    $(selectores.btnAceptar).prop("disabled", false);
  }
}