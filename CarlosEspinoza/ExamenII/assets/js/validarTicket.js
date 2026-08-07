document.getElementById("formTicket").addEventListener("submit", function (event) {

    const titulo = document.getElementById("titulo").value.trim();
    const descripcion = document.getElementById("descripcion").value.trim();
    const departamento = document.getElementById("departamento").value.trim();
    const prioridad = document.getElementById("prioridad").value;

    let mensaje = "";

    if (titulo === "") {
        mensaje = "El título es obligatorio.";
    } else if (descripcion === "") {
        mensaje = "La descripción es obligatoria.";
    } else if (departamento === "") {
        mensaje = "El departamento es obligatorio.";
    } else if (prioridad === "") {
        mensaje = "Seleccione una prioridad.";
    }

    if (mensaje !== "") {
        event.preventDefault();
        document.getElementById("errorTicket").innerHTML = mensaje;
        document.getElementById("errorTicket").style.display = "block";
    }

});
