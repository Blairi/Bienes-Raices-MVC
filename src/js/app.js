document.addEventListener('DOMContentLoaded', () => {
    eventListeners();

    darkMode();
});

const darkMode = () => {

    const prefiereDarkmode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkmode.matches);
    if(prefiereDarkmode.matches){
        document.body.classList.add('dark-mode');
    }
    else{
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkmode.addEventListener('change', () => {
        if(prefiereDarkmode.matches){
            document.body.classList.add('dark-mode');
        }
        else{
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
    });
}

const eventListeners = () => {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);
}

const navegacionResponsive = () => {
    const navegacion = document.querySelector('.navegacion');

    if(navegacion.classList.contains('mostrar')){
        navegacion.classList.remove('mostrar');
    }
    else{
        navegacion.classList.add('mostrar');
    }
}