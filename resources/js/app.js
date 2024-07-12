import "./bootstrap";
import "./misFunciones";
// import "./buscadorPeliculas";
// import "./buscadorActores";
// import "./buscadorDirectores";
// import "./buscadorSeries";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Inicializa DataTables en la tabla con el id "miTabla"
$(document).ready(function () {
    $("#tabla_usuarios").DataTable({
        lengthChange: false,
    });

    $(document).ready(function () {
        var table = $("#tabla_peliculas").DataTable({
            lengthMenu: [20],
            lengthChange: false,
            initComplete: function () {
                $("#tabla_peliculas thead th").addClass("text-center");
            },
        });

        $("#tabla_peliculas").on("draw.dt", function () {
            $("#tabla_peliculas tbody td").addClass("text-center");
        });
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
