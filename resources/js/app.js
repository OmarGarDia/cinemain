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

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search_movie");
    const searchResults = document.getElementById("search_results");
    const searchMovieUrlMeta = document.querySelector(
        'meta[name="search-movie-url"]'
    );

    if (!searchInput || !searchResults || !searchMovieUrlMeta) {
        // Si alguno de los elementos o meta tags no se encuentra, no hacer nada
        return;
    }

    const searchMovieUrl = searchMovieUrlMeta.getAttribute("content");
    const axiosConfig = {
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    };

    let timeout = null;

    searchInput.addEventListener("input", function () {
        clearTimeout(timeout);
        const query = searchInput.value.trim();

        if (query.length > 2) {
            timeout = setTimeout(() => {
                axios
                    .post(searchMovieUrl, { query: query }, axiosConfig)
                    .then((response) => {
                        const movies = response.data.results;
                        searchResults.innerHTML = "";

                        movies.forEach((movie) => {
                            const li = document.createElement("li");
                            li.classList.add("list-group-item");
                            li.textContent = movie.title;
                            li.addEventListener("click", () => fillForm(movie));
                            searchResults.appendChild(li);
                        });
                    })
                    .catch((error) => {
                        console.error("Error fetching data:", error);
                    });
            }, 200); // Espera 200ms después de la última pulsación de tecla para enviar la solicitud
        } else {
            searchResults.innerHTML = "";
        }
    });

    function fillForm(movie) {
        document.getElementById("titulo").value = movie.title;
        document.getElementById("anio").value =
            movie.release_date.split("-")[0];
        document.getElementById("sinopsis").value = movie.overview;
        document.getElementById("idioma").value =
            movie.original_language === "en" ? "Inglés" : "Español";
        document.getElementById("duracion").value = movie.runtime;
        document.getElementById("pais").value = movie.production_countries
            .map((country) => country.name)
            .join(", ");
        document.getElementById("genero").value = movie.genres
            .map((genre) => genre.name)
            .join(", ");
        const calificacion = parseFloat(movie.vote_average).toFixed(1);
        document.getElementById("calificacion").value = calificacion;
        document.getElementById("fecha_estreno").value = movie.release_date;

        // Obtener información del director
        axios
            .get(`https://api.themoviedb.org/3/movie/${movie.id}/credits`, {
                params: {
                    api_key: "572048c03066a9b129b919b78cc7e6fc", // Reemplaza con tu clave de API
                },
            })
            .then((response) => {
                const directorName = response.data.crew.find(
                    (member) => member.job === "Director"
                )?.name;

                // Verificar si el nombre del director está en el select de directores
                const directorSelect = document.getElementById("director_id");
                if (directorSelect) {
                    const directorOption = [...directorSelect.options].find(
                        (option) => option.text === directorName
                    );
                    if (directorOption) {
                        directorSelect.value = directorOption.value;
                    }
                }
            })
            .catch((error) => {
                console.error("Error fetching director data:", error);
            });

        searchResults.innerHTML = "";
    }
});
