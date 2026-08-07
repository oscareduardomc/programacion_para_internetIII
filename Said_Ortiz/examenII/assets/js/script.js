document.addEventListener("DOMContentLoaded", function () {
    const btnMenu = document.getElementById("btnMenu");

    if (btnMenu) {
        btnMenu.addEventListener("click", function () {
            document.querySelector(".sidebar").classList.toggle("cerrado");
            document.querySelector(".navbar").classList.toggle("expandido");
            document.querySelector(".content").classList.toggle("expandido");
        });
    }
});
