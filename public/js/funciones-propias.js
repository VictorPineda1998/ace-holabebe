function deslizar(p) {
    var cambio2Element = document.getElementById(p);

    // Obtener la posición del botón respecto a la ventana
    var elementPosition = cambio2Element.getBoundingClientRect().top;

    // Calcular la posición actual de la ventana
    var startingY = window.pageYOffset;

    // Calcular la posición final
    var targetY = startingY + elementPosition;

    // Duración de la animación en milisegundos
    var totalTime = 500;
    var currentTime = 0;

    // Intervalo de tiempo entre cada fotograma
    var increment = 20;

    // Función de animación
    function animateScroll() {
        currentTime += increment;

        // Calcular la posición actual
        var easedPosition = easeInOut(currentTime, startingY, elementPosition, totalTime);
        window.scrollTo(0, easedPosition);

        // Continuar la animación si no ha alcanzado la posición final
        if (currentTime < totalTime) {
            requestAnimationFrame(animateScroll);
        }
    }

    // Función de facilidad (puede ajustar según necesidades)
    function easeInOut(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t + b;
        t--;
        return -c / 2 * (t * (t - 2) - 1) + b;
    }

    // Iniciar la animación
    animateScroll();
}

let formRegistrar = document.getElementById('formRegistrar');

if (formRegistrar) {
    formRegistrar.addEventListener('submit', function () {
        // Deshabilita el botón para evitar clics múltiples
        document.getElementById('guardarConsultaBtn').setAttribute('disabled', 'true');
    });
}

// var clicado = false;

// document.getElementById('guardarConsultaBtn').addEventListener('click', function() {
//     // Verifica si el botón ya ha sido clicado
//     if (clicado) {
//         // Deshabilita el botón para evitar clics múltiples
//         this.setAttribute('disabled', 'true');

//         clicado = false;

//     }
//     clicado = true;
// });
