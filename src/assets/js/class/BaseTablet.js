export class BaseDataTable {

    constructor(selector, config) {
        this.selector = selector;
        this.url = config.url;
        // this.columns = config.columns || [];
        this.columnDefs = config.columnDefs || [];
        this.pageLength = config.pageLength || 5;
        this.instance = null;
        this.dom = config.dom;
        this.init();
    }
    init() {
        this.instance = new DataTable(this.selector, {
            responsive: true,
            serverSide: true,
            processing: true,
            deferRender: true,
            searching: false,
            lengthChange: true,
            paging: true,
            lengthChange: false,
            lengthMenu: [5, 10, 25, 50],
            pageLength: this.pageLength,
            // Configuración visual estandarizada
            dom: this.dom,
            ajax: {
                url: this.url,
                type: "POST"
            },
            // Paginación con iconos estandarizados
            language: {

                url: "./IdiomaEspañol.json",

            },
            // columns: this.columns,
            columnDefs: this.columnDefs

        });

    }

    // Método para recargar la tabla manualmente si es necesario
    reload() {
        if (this.instance) this.instance.ajax.reload();
    }

    // Método para conectar un buscador externo
    bindSearch(inputSelector) {
        document.querySelector(inputSelector).addEventListener('keyup', (e) => {
            this.instance.search(e.target.value).draw();
        });

    }
    // Método para cambiar la longitud de página
    pageLengthChange(newLength) {
        this.instance.page.len(parseInt(newLength)).draw();
    }
}