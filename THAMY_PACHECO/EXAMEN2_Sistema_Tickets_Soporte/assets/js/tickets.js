document.addEventListener("DOMContentLoaded", function () {
    const formTicket = document.getElementById("formNuevoTicket");

    if (formTicket) {
        formTicket.addEventListener("submit", function (e) {
            const titulo = document.getElementById("titulo") ? document.getElementById("titulo").value.trim() : "";
            const departamento = document.getElementById("departamento") ? document.getElementById("departamento").value.trim() : "";
            const prioridad = document.getElementById("prioridad") ? document.getElementById("prioridad").value.trim() : "";
            const descripcion = document.getElementById("descripcion") ? document.getElementById("descripcion").value.trim() : "";

            let errores = [];

            if (titulo === "") {
                errores.push("El título de la incidencia es obligatorio.");
            }

            if (departamento === "") {
                errores.push("Debe ingresar o seleccionar un departamento.");
            }

            if (prioridad === "") {
                errores.push("Debe seleccionar el nivel de prioridad (Baja, Media, Alta).");
            }

            if (descripcion === "") {
                errores.push("Debe proporcionar una descripción detallada del problema.");
            }

            if (errores.length > 0) {
                e.preventDefault();

                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        icon: "warning",
                        title: "Campos Obligatorios Incompletos",
                        html: "<ul style='text-align:left; margin-bottom:0;'>" + 
                              errores.map(err => "<li>" + err + "</li>").join("") + 
                              "</ul>",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#0d6efd"
                    });
                } else {
                    alert("Por favor complete los campos obligatorios:\n- " + errores.join("\n- "));
                }
                return false;
            }
        });
    }
});
