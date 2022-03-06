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

    // Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach( (input) => input.addEventListener("click", mostrarMetodosContacto));

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

const mostrarMetodosContacto = (e) => {
    const contactoDIV = document.querySelector("#contacto");
    
    if(e.target.value === "telefono"){
        contactoDIV.innerHTML = `
        <label for="telefono">Número Teléfono</label>
        <input data-cy="input-telefono" type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">
        <p>Elija la fecha y la hora para la llamada</p>

        <label for="fecha">Fecha:</label>
        <input data-cy="input-fecha" type="date" id="fecha" name="contacto[fecha]">

        <label for="hora">Hora:</label>
        <input data-cy="input-hora" type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    }
    else{
        contactoDIV.innerHTML = `
        <label for="email">E-mail</label>
        <input data-cy="input-email" type="email" placeholder="Tu Email" id="email" name="contacto[email]" >
        `;
    }
}