export class ExportButton {
    constructor(options = {}) {
        this.mainBtnSelector = options.mainBtn || '#mainExportBtn';
        this.closeBtnSelector = options.closeBtn || '.close-trigger';
        this.actionIconsSelector = options.actionIcons || '.icon-action';
        this.init();
    }

    init() {
        const btn = document.querySelector(this.mainBtnSelector);
        const closeBtn = document.querySelector(this.closeBtnSelector);
        const actionIcons = document.querySelectorAll(this.actionIconsSelector);

        if (!btn) {
            console.error(`Botón principal no encontrado: ${this.mainBtnSelector}`);
            return;
        }

        // 1. Abrir el menú (Subir texto)
        btn.addEventListener('click', (e) => {
            if (!btn.classList.contains('is-active')) {
                btn.classList.add('is-active');
            }
        });

        // 2. Cerrar el menú (Bajar texto)
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                btn.classList.remove('is-active');
            });
        }

        // 3. Manejo de clics en iconos (Acciones de exportación)
        actionIcons.forEach(icon => {
            icon.addEventListener('click', (e) => {
                e.stopPropagation();
                const type = icon.getAttribute('data-type');
                console.log(`Iniciando exportación a: ${type.toUpperCase()}`);
                
                // Feedback visual moderno con clase CSS
                icon.classList.add('clicked');
                setTimeout(() => icon.classList.remove('clicked'), 200);
            });
        });
    }
}


