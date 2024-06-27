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
    let cancelToken = axios.CancelToken.source();
    const cache = new Map();

    searchInput.addEventListener("input", function () {
        clearTimeout(timeout);
        const query = searchInput.value.trim();

        if (query.length > 2) {
            timeout = setTimeout(() => {
                if (cache.has(query)) {
                    displayResults(cache.get(query));
                } else {
                    cancelToken.cancel("New request initiated");
                    cancelToken = axios.CancelToken.source();

                    // Mostrar feedback visual de carga
                    searchResults.innerHTML = "<p>Cargando resultados...</p>";

                    axios
                        .get(`https://api.themoviedb.org/3/search/movie`, {
                            params: {
                                api_key: "572048c03066a9b129b919b78cc7e6fc",
                                query: query,
                                language: "es-ES", // Agregar el parámetro language para obtener resultados en español
                            },
                            cancelToken: cancelToken.token,
                        })
                        .then((response) => {
                            const movies = response.data.results;
                            cache.set(query, movies);
                            displayResults(movies);
                        })
                        .catch((error) => {
                            if (axios.isCancel(error)) {
                                console.log("Request canceled:", error.message);
                            } else {
                                console.error("Error fetching data:", error);
                            }
                        })
                        .finally(() => {
                            // Limpiar feedback visual de carga
                            searchResults.innerHTML = "";
                        });
                }
            }, 500); // Reducir el tiempo de espera del debouncing si es necesario
        } else {
            searchResults.innerHTML = "";
        }
    });

    function displayResults(movies) {
        searchResults.innerHTML = "";

        movies.forEach((movie) => {
            const li = document.createElement("li");
            li.classList.add("list-group-item");

            const movieInfoContainer = document.createElement("div");
            movieInfoContainer.classList.add("movie-info-container");

            const titleYear = document.createElement("div");
            titleYear.textContent = `${movie.title} (${
                movie.release_date
                    ? movie.release_date.split("-")[0]
                    : "Fecha desconocida"
            })`;
            titleYear.classList.add("movie-title");
            movieInfoContainer.appendChild(titleYear);

            if (movie.poster_path) {
                const img = document.createElement("img");
                img.src = `https://image.tmdb.org/t/p/w45${movie.poster_path}`;
                img.alt = movie.title;
                img.classList.add("movie-poster");
                movieInfoContainer.appendChild(img);
            }

            li.appendChild(movieInfoContainer);
            searchResults.appendChild(li);

            movieInfoContainer.addEventListener("click", () => fillForm(movie));
        });
    }

    function fillForm(movie) {
        console.log(movie);
        document.getElementById("titulo").value = movie.title || "";
        document.getElementById("anio").value = movie.release_date
            ? movie.release_date.split("-")[0]
            : "";
        document.getElementById("sinopsis").value = movie.overview || "";
        document.getElementById("idioma").value = getLanguage(
            movie.original_language
        );
        document.getElementById("pais").value = getProductionCountries(
            movie.production_countries
        );
        document.getElementById("genero").value = movie.genres
            ? movie.genres.map((genre) => genre.name).join(", ")
            : "";
        const calificacion = parseFloat(movie.vote_average).toFixed(1);
        document.getElementById("calificacion").value = isNaN(calificacion)
            ? ""
            : calificacion;
        document.getElementById("fecha_estreno").value =
            movie.release_date || "";

        axios
            .get(`https://api.themoviedb.org/3/movie/${movie.id}`, {
                params: {
                    api_key: "572048c03066a9b129b919b78cc7e6fc",
                },
            })
            .then((response) => {
                const runtime = response.data.runtime;
                document.getElementById("duracion").value = runtime || "";
            })
            .catch((error) => {
                console.error("Error fetching movie details:", error);
                // Si hay un error, manejarlo apropiadamente
            });

        axios
            .get(`https://api.themoviedb.org/3/movie/${movie.id}/credits`, {
                params: {
                    api_key: "572048c03066a9b129b919b78cc7e6fc",
                },
            })
            .then((response) => {
                const directorName = response.data.crew.find(
                    (member) => member.job === "Director"
                )?.name;
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
    }

    // Función para obtener el idioma en español o inglés
    function getLanguage(originalLanguage) {
        // Mapeo manual de idiomas
        const languageMap = {
            en: "Inglés",
            es: "Español",
            // Agrega más idiomas según sea necesario
        };
        return languageMap[originalLanguage] || "Desconocido";
    }

    // Función para obtener el nombre completo del país a partir de los códigos de país
    function getProductionCountries(countries) {
        if (!countries || countries.length === 0) {
            return "";
        }

        // Mapeo manual de códigos de país a nombres de país
        const countryCodes = {
            US: "Estados Unidos",
            CA: "Canadá",
            MX: "México",
            // Agrega más códigos según sea necesario
        };

        return countries
            .map((country) => countryCodes[country.iso_3166_1] || country.name)
            .join(", ");
    }
});
