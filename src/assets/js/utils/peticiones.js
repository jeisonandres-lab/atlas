import { endpoints } from "./endpoints.js";
import { obtenerDatosJQuery } from "./formularioAjax.js";
import { llenarSelect } from "./inputs.js";

export async function buscarMunicipioPorEstado(estadoSelector, municipioSelector) {
    $(document).on("change", estadoSelector, async function () {
        const idEstado = $(this).val();
        try {
            if (idEstado !== undefined) {
                try {
                    let urls = [endpoints.obtenerMunicipios];
                    let options = { idestado: idEstado };
                    let requests = urls.map((url, index) => {
                        if (index === 0) { // Suponiendo que quieres pasar `options` solo a la primera solicitud
                            return obtenerDatosJQuery(url, options);
                        }
                    });
                    const [municipio] = await Promise.all(requests);
                    if (municipio.exito) {
                        $(municipioSelector).empty();
                        $(municipioSelector).append('<option value="">Seleccione un municipio</option>');
                        await llenarSelect(municipio.data, municipioSelector.substring(1), 'Seleccione un municipio');
                    } else {
                        console.error('Error al obtener estado o la estructura de la respuesta es incorrecta');
                    }
                } catch (error) {
                    console.error('Error al obtener los datos de la estado:', error);
                }
            } else {
                console.error('El idestado es undefined');
            }
        } catch (error) {
            console.error('Error al manejar el evento de clic:', error);
        }
    });
}

export async function buscarParroquiaPorMunicipio(municipioSelector, parroquiaSelector) {
    $(document).on("change", municipioSelector, async function () {
        const idmunicipio = $(this).val();
        try {
            if (idmunicipio !== undefined) {
                try {
                    let urls = [endpoints.obtenerParroquias];
                    let options = { idmunicipio: idmunicipio };
                    let requests = urls.map((url, index) => {
                        if (index === 0) { // Suponiendo que quieres pasar `options` solo a la primera solicitud
                            return obtenerDatosJQuery(url, options);
                        }
                    });
                    const [parroquia] = await Promise.all(requests);
                    if (parroquia.exito) {
                        $(parroquiaSelector).empty();
                        $(parroquiaSelector).append('<option value="">Seleccione una parroquia</option>');
                        await llenarSelect(parroquia.data, parroquiaSelector.substring(1), 'Seleccione una parroquia');
                    } else {
                        console.error('Error al obtener parroquias o la estructura de la respuesta es incorrecta');
                    }
                } catch (error) {
                    console.error('Error al obtener los datos de la parroquia:', error);
                }
            } else {
                console.error('El idparroquia es undefined');
            }
        } catch (error) {
            console.error('Error al manejar el evento de clic:', error);
        }
    });
}