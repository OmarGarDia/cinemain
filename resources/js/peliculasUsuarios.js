document.addEventListener("DOMContentLoaded", function () {
    const leerMasLinks = document.querySelectorAll(".leer-mas");

    leerMasLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const sinopsis = this.parentElement.querySelector("p");
            sinopsis.classList.toggle("truncate");
            this.textContent = sinopsis.classList.contains("truncate")
                ? "Leer más"
                : "Leer menos";
        });
    });
});
