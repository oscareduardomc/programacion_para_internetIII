document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('formTicket');

    formulario.addEventListener('submit', function (evento) {
        const titulo = formulario.titulo.value.trim();
        const descripcion = formulario.descripcion.value.trim();
        const prioridad = formulario.prioridad.value;

        if (titulo === '' || descripcion === '' || prioridad === '') {
            evento.preventDefault();
            alert('Complete todos los campos obligatorios');
        }
    });
});