import "./bootstrap";
import "./misFunciones";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

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

// ======= MOSTRAR U OCULTAR CAMPO PASSWORD ========
// const passwordInput = document.getElementById("password_edit");
// //const togglePasswordIcon = document.getElementById("hidePasswordIcon");

// togglePassword.addEventListener("click", function () {
//     if (passwordInput.type === "password") {
//         passwordInput.type = "text";
//         togglePasswordIcon.classList.remove("mdi-eye");
//         togglePasswordIcon.classList.add("mdi-eye-off");
//     } else {
//         passwordInput.type = "password";
//         togglePasswordIcon.classList.remove("mdi-eye-off");
//         togglePasswordIcon.classList.add("mdi-eye");
//     }
// });

// ===== EVENTOS VARIOS =====
