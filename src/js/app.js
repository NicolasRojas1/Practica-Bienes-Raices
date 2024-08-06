document.addEventListener('DOMContentLoaded', function() {

    eventListeners();
    darkMode();
});

//funcion para cambiar el tema
function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    //console.log(prefiereDarkMode.matches);
    //Por medio de este codigo añade el dark mode segun la preferencia del usuario con su navegador
    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');

    }
    //Si el usuario cambia las preferencias en el navegador, este evento escuchara la respuesta y aplicará el codigo segun lo seleccionado
    prefiereDarkMode.addEventListener('change', function() {
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
    
        }
    })
    

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function() {
        //lo agregará en el body
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    //Selecciono el boton
    const mobileMenu = document.querySelector('.mobile-menu');

    //Al darle clic ejecutara navegacionResponsive
    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    //Si tiene la clase mostrar la quita, si no la agrega
    navegacion.classList.toggle('mostrar');
}


