export async function mostrarPDFenModal(formAction, nombreArchivo, modalId, formElement) {
    try {
        // Mostrar alerta de "Generando PDF"
        Swal.fire({
            title: 'Generando PDF',
            text: 'Por favor, espere mientras se genera el PDF.',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData(formElement);
        const response = await fetch(formAction, {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            const result = await response.json();

            // Ocultar alerta de "Generando PDF"
            Swal.close();

            if (result.pdfBase64) {
                const pdfData = result.pdfBase64;
                const pdfUrl = `data:application/pdf;base64,${pdfData}`;

                // Mostrar el PDF en un modal
                if ($(`#${modalId}`).length === 0) {
                    $('body').append(`
                        <div class="modal modal-xl fade" id="${modalId}" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-xl-12 p-0 m-0" id="columna1">
                                                    <iframe src="${pdfUrl}" width="100%" height="600px"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer p-1" style="background-color: rgba(var(33, 37, 41), 0.03);">
                                        <a href="${pdfUrl}" download="${nombreArchivo}" class="btn btn-danger btn-sm btn-hover-rojo" style="margin-right: 10px;"><i class="fa-regular fa-file-pdf fa-sm me-2"></i>Descargar PDF</a>
                                        <button class="btn btn-secondary btn-sm btn-hover-gris" onclick="$('#${modalId}').modal('hide');"><i class="fa-regular fa-xmark-large fa-sm me-2"></i>Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                } else {
                    $(`#${modalId} #columna1`).html(`<iframe src="${pdfUrl}" width="100%" height="600px"></iframe>`);
                }
                $(`#${modalId}`).modal('show');
            } else {
                alert("Error al generar el PDF");
            }
        } else {
            // Ocultar alerta de "Generando PDF" en caso de error
            Swal.close();
            alert("Error al generar el PDF");
        }
    } catch (error) {
        // Ocultar alerta de "Generando PDF" en caso de error
        Swal.close();
        console.error('Error:', error);
        alert("Error al generar el PDF");
    }
}