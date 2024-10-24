const cardNodes = document.querySelectorAll('.card-container');
const perspecNodes = document.querySelectorAll('.perspec');
const perspec = document.querySelector('.perspec');
const card = document.querySelector('.card');   


// Función para generar un número aleatorio
function randomIntFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

// Después de la animación de inclinación, inicia la animación de explosión
card.addEventListener('animationend', function () {
    perspecNodes.forEach(function (elem, index) {
        elem.classList.add('explode');
    });
});

// Después de la animación de explosión, realiza varias acciones
perspec.addEventListener('animationend', function (e) {
    if (e.animationName === 'explode') {
        cardNodes.forEach(function (elem, index) {
            // Genera un número aleatorio de líneas de código entre 4 y 10 y agrégalo a cada tarjeta
            let numLines = randomIntFromInterval(5, 10);

            // Recorre las líneas y agrégalas al DOM
            for (let index = 0; index < numLines; index++) {
                let lineLength = randomIntFromInterval(25, 97);
                var node = document.createElement("li");
                node.classList.add('node-' + index);
                elem.querySelector('.code ul').appendChild(node).setAttribute('style', '--linelength: ' + lineLength + '%;');

                // Dibuja las líneas de código una por una
                if (index == 0) {
                    elem.querySelector('.code ul .node-' + index).classList.add('writeLine');
                } else {
                    elem.querySelector('.code ul .node-' + (index - 1)).addEventListener('animationend', function (e) {
                        elem.querySelector('.code ul .node-' + index).classList.add('writeLine');   

                    });
                }
            }
        });
    }
});