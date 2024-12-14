const app = () => {
    const buscarFecha = () => {
        const fechaInput = document.querySelector('#fecha');
        fechaInput.addEventListener('input', e => {
            window.location = '/admin?fecha=' + fechaInput.value;
        })
    }

    buscarFecha();
}

document.addEventListener('DOMContentLoaded', e => {
    app();
})