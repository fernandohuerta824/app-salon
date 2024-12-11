document.addEventListener('DOMContentLoaded', e => {
    const tabs = document.querySelector('.tabs');
    const paginacion = document.querySelector('.paginacion');
    const paginaInicial = 1;
    const paginaFinal = 3;

    let paso = 1;
    
    const cambiarVentana = () => {
        const seccionAnterior = document.querySelector('.seccion.mostrar');
        
        seccionAnterior.classList.remove('mostrar');
        seccionAnterior.classList.add('ocultar');
 
        const seccion = document.querySelector('#paso-' + paso);

        seccion.classList.remove('ocultar');
        seccion.classList.add('mostrar');
    }

    const cambiarEstiloBoton = () => {
        const buttonAnterior = tabs.querySelector('button.actual');

        buttonAnterior.classList.remove('actual');

        const button = document.querySelector(`button[data-paso="${paso}"]`);

        button.classList.add('actual');
    }

    const mostrarPaginacion = () => {
        const buttonSiguiente = document.querySelector('#siguiente');
        const buttonAnterior = document.querySelector('#anterior');

        if(paso === 1) {
            buttonAnterior.classList.add('ocultar');
            buttonSiguiente.classList.remove('ocultar');
        }

        if(paso === 2) {
            buttonAnterior.classList.remove('ocultar');
            buttonSiguiente.classList.remove('ocultar');
        }

        if(paso === 3) {
            buttonAnterior.classList.remove('ocultar');
            buttonSiguiente.classList.add('ocultar');
        }
    }

    const cambiarSeccion = pasoTab => {
        if(pasoTab < paginaInicial) paso = paginaInicial;
        else if(pasoTab > paginaFinal) paso = paginaFinal;
        else paso = pasoTab;

        cambiarVentana();
        cambiarEstiloBoton();
        mostrarPaginacion();
    }
    
    tabs.addEventListener('click', e => {
        const pasoTab = +e.target.getAttribute('data-paso');

        if(!pasoTab) return;

        cambiarSeccion(pasoTab);
    })

    paginacion.addEventListener('click', e => {
        const button = e.target;

        if(!button.classList.contains('boton')) return;

        const action = button.id;
        if(action === 'siguiente') cambiarSeccion(paso + 1);
        if(action === 'anterior') cambiarSeccion(paso - 1);
    })
})