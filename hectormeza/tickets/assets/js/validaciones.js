document.getElementById("formTicket").addEventListener("submit", function (evento) {

    let valido = true;

    const titulo = document.getElementById("titulo");
    const descripcion = document.getElementById("descripcion");
    const departamento = document.getElementById("departamento");
    const prioridad = document.getElementById("prioridad");

    // Limpiar validaciones anteriores
    [titulo, descripcion, departamento, prioridad].forEach(function (campo) {
        campo.classList.remove("is-invalid");
    });

    if (titulo.value.trim() === "") {
        titulo.classList.add("is-invalid");
        document.getElementById("errorTitulo").textContent = "El titulo es obligatorio.";
        valido = false;
    }

    if (descripcion.value.trim() === "") {
        descripcion.classList.add("is-invalid");
        document.getElementById("errorDescripcion").textContent = "La descripcion es obligatoria.";
        valido = false;
    }

    if (departamento.value === "") {
        departamento.classList.add("is-invalid");
        document.getElementById("errorDepartamento").textContent = "Debe seleccionar un departamento.";
        valido = false;
    }

    if (prioridad.value === "") {
        prioridad.classList.add("is-invalid");
        document.getElementById("errorPrioridad").textContent = "Debe seleccionar una prioridad.";
        valido = false;
    }

    if (!valido) {
        evento.preventDefault();
    }

});
