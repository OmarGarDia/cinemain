import "./bootstrap";
import "./misFunciones";
// import "./buscadorPeliculas";
// import "./buscadorActores";
// import "./buscadorDirectores";
// import "./buscadorSeries";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document
    .getElementById("user-menu-button")
    .addEventListener("click", function (event) {
        event.stopPropagation();
        var userMenu = document.getElementById("user-menu");
        if (
            userMenu.style.display === "none" ||
            userMenu.style.display === ""
        ) {
            userMenu.style.display = "block";
        } else {
            userMenu.style.display = "none";
        }
    });

document.addEventListener("click", function (event) {
    var userMenu = document.getElementById("user-menu");
    var isClickInside = document
        .getElementById("user-menu-button")
        .contains(event.target);
    if (!isClickInside) {
        userMenu.style.display = "none";
    }
});

// Inicializa DataTables en la tabla con el id "miTabla"
$(document).ready(function () {
    $("#tabla_usuarios").DataTable({
        lengthChange: false,
    });
    $("#tabla_peliculas").DataTable({
        lengthMenu: [20],
        lengthChange: false,
    });

    $("#tabla_directores").DataTable({
        lengthMenu: [20],
        lengthChange: false,
    });

    $("#tabla_peliculas_vistas").DataTable({
        lengthMenu: [10],
        lengthChange: false,
    });

    $("#tabla_peliculas_pendiente").DataTable({
        lengthMenu: [10],
        lengthChange: false,
    });

    $("#peliculas_director").DataTable({
        lengthMenu: [10],
        lengthChange: false,
    });

    $("#tabla_actores").DataTable({
        lengthMenu: [10],
        lengthChange: false,
    });
});
