document.addEventListener('DOMContentLoaded', function() {

    eventListeners();
});

function eventListeners() {
    //Selecciono el boton
    const mobileMenu = document.querySelector('.mobile-menu');

    //Al darle clic ejecutara navegacionResponsive
    mobileMenu.addEventListener('click', navegacionResponsive);
    mobileMenu.addEventListener('click', ajustarMenu)
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    //Si tiene la clase mostrar la quita, si no la agrega
    navegacion.classList.toggle('mostrar');
}
//Este evento esta pendiente al cambio de pantalla y aplica la funcion de ajustarMenu
window.addEventListener('resize', ajustarMenu);

function ajustarMenu() {
    const navegacion = document.querySelector('.navegacion');
    const barra = document.querySelector('.barra');

    // Verifica si barra y navegacion existen
    if (barra) {
        // Verifica si la pantalla es móvil
        if (window.matchMedia("(max-width: 768px)").matches) {
            if (navegacion.classList.contains('mostrar')) {
                console.log('Menu desplegado en móvil');
                barra.style.height = '30rem';
            } else {
                console.log('Menu cerrado en móvil');
                barra.style.height = '12rem';
            }
        } else {
            // Pantalla grande, restablece el height
            barra.style.height = '';
        }
    }
}