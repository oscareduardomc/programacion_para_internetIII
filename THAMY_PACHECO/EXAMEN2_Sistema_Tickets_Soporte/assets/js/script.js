document.addEventListener("DOMContentLoaded", function () {
    const btnMenu = document.getElementById("btnMenu");
    if (btnMenu) {
        btnMenu.addEventListener("click", function () {
            const sidebar = document.querySelector(".sidebar");
            const navbar = document.querySelector(".navbar");
            const content = document.querySelector(".content");

            if (sidebar) sidebar.classList.toggle("cerrado");
            if (navbar) navbar.classList.toggle("expandido");
            if (content) content.classList.toggle("expandido");
        });
    }
});
