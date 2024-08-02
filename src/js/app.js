document.addEventListener('DOMContentLoaded', function() {

    eventListeners();
});

function eventListeners() {
    //Selecciono el boton
    const mobileMenu = document.querySelector('.mobile-menu');

    //Al darle clic ejecutara navegacionResponsive
    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const  navegacion = document.querySelector('.navegacion');

    //Si tiene la clase mostrar la quita, si no la agrega
    navegacion.classList.toggle('mostrar');
}