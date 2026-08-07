document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formTicket");

    if (!formulario) {
        return;
    }

    formulario.addEventListener("submit", function (evento) {
        const errores = [];
        const titulo = document.getElementById("titulo").value.trim();
        const descripcion = document.getElementById("descripcion").value.trim();
        const departamento = document.getElementById("departamento").value;
        const prioridad = document.getElementById("prioridad").value;

        if (titulo === "") {
            errores.push("El título es obligatorio.");
        }

        if (descripcion === "") {
            errores.push("La descripción es obligatoria.");
        }

        if (departamento === "") {
            errores.push("Debe seleccionar un departamento.");
        }

        if (prioridad === "") {
            errores.push("Debe seleccionar una prioridad.");
        }

        const contenedorErrores = document.getElementById("erroresValidacion");
        const listaErrores = document.getElementById("listaErrores");

        if (errores.length > 0) {
            evento.preventDefault();
            listaErrores.innerHTML = errores.map(function (error) {
                return "<li>" + error + "</li>";
            }).join("");
            contenedorErrores.classList.add("visible");
        } else {
            contenedorErrores.classList.remove("visible");
            listaErrores.innerHTML = "";
        }
    });
});
