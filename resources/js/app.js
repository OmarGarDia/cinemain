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

// BUSCADOR DE PELICULAS

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
    let genresMap = {};

    // Llamada inicial para obtener los nombres de géneros en español
    axios
        .get("https://api.themoviedb.org/3/genre/movie/list", {
            params: {
                api_key: "572048c03066a9b129b919b78cc7e6fc",
                language: "es-ES",
            },
        })
        .then((response) => {
            genresMap = response.data.genres.reduce((acc, genre) => {
                acc[genre.id] = genre.name;
                return acc;
            }, {});

            console.log("Genres map:", genresMap);

            // Luego de obtener los géneros desde la API, procedemos a llenar el formulario
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

                            searchResults.innerHTML =
                                "<p>Cargando resultados...</p>";

                            axios
                                .get(
                                    `https://api.themoviedb.org/3/search/movie`,
                                    {
                                        params: {
                                            api_key:
                                                "572048c03066a9b129b919b78cc7e6fc",
                                            query: query,
                                            language: "es-ES",
                                        },
                                        cancelToken: cancelToken.token,
                                    }
                                )
                                .then((response) => {
                                    const movies = response.data.results;
                                    cache.set(query, movies);
                                    displayResults(movies);
                                })
                                .catch((error) => {
                                    if (axios.isCancel(error)) {
                                        console.log(
                                            "Request canceled:",
                                            error.message
                                        );
                                    } else {
                                        console.error(
                                            "Error fetching data:",
                                            error
                                        );
                                    }
                                })
                                .finally(() => {
                                    searchResults.innerHTML = "";
                                });
                        }
                    }, 500);
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

                    movieInfoContainer.addEventListener("click", () =>
                        fillForm(movie)
                    );
                });
            }

            async function fillForm(movie) {
                console.log(movie);
                document.getElementById("titulo").value = movie.title || "";
                document.getElementById("anio").value = movie.release_date
                    ? movie.release_date.split("-")[0]
                    : "";
                document.getElementById("sinopsis").value =
                    movie.overview || "";
                document.getElementById("idioma").value = getLanguage(
                    movie.original_language
                );

                // Obtener duración y país de producción
                try {
                    const movieDetails = await getMovieDetails(movie.id);
                    if (movieDetails) {
                        document.getElementById("pais").value =
                            getProductionCountries(
                                movieDetails.production_countries
                            );
                        document.getElementById("calificacion").value =
                            parseFloat(movieDetails.vote_average).toFixed(1) ||
                            "";
                        document.getElementById("fecha_estreno").value =
                            movieDetails.release_date || "";
                        document.getElementById("duracion").value =
                            movieDetails.runtime || "";

                        // Obtener nombres de géneros
                        const genreNames = movie.genre_ids.map(
                            (genreId) => genresMap[genreId]
                        );

                        // Seleccionar géneros correspondientes
                        selectGenres(genreNames);

                        searchResults.innerHTML = "";
                    }
                } catch (error) {
                    console.error("Error fetching movie details:", error);
                }

                axios
                    .get(
                        `https://api.themoviedb.org/3/movie/${movie.id}/credits`,
                        {
                            params: {
                                api_key: "572048c03066a9b129b919b78cc7e6fc",
                            },
                        }
                    )
                    .then((response) => {
                        const directorName = response.data.crew.find(
                            (member) => member.job === "Director"
                        )?.name;
                        const directorSelect =
                            document.getElementById("director_id");
                        if (directorSelect) {
                            const directorOption = [
                                ...directorSelect.options,
                            ].find((option) => option.text === directorName);
                            if (directorOption) {
                                directorSelect.value = directorOption.value;
                            }
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching director data:", error);
                    });
            }

            function getMovieDetails(movieId) {
                return axios
                    .get(`https://api.themoviedb.org/3/movie/${movieId}`, {
                        params: {
                            api_key: "572048c03066a9b129b919b78cc7e6fc",
                        },
                    })
                    .then((response) => {
                        return response.data;
                    })
                    .catch((error) => {
                        throw error;
                    });
            }

            function getLanguage(originalLanguage) {
                const languageMap = {
                    en: "Inglés",
                    es: "Español",
                };
                return languageMap[originalLanguage] || "Desconocido";
            }

            function getProductionCountries(countries) {
                if (!countries || countries.length === 0) {
                    return "";
                }

                const countryCodes = {
                    US: "Estados Unidos",
                    CA: "Canadá",
                    MX: "México",
                };

                return countries
                    .map(
                        (country) =>
                            countryCodes[country.iso_3166_1] || country.name
                    )
                    .join(", ");
            }

            function selectGenres(genreNames) {
                console.log(genreNames);
                const genreSelect = document.getElementById("generos");
                if (genreSelect) {
                    const genreOptions = [...genreSelect.options];

                    // Iterar sobre los nombres de género de la película y seleccionar los correspondientes
                    genreNames.forEach((genreName) => {
                        const genreOption = genreOptions.find(
                            (option) => option.text === genreName
                        );
                        if (genreOption) {
                            genreOption.selected = true;
                        }
                    });
                }
            }
        })
        .catch((error) => {
            console.error("Error fetching genres:", error);
        });
});

// BUSCADOR DE ACTORES

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search_actor");
    const searchResults = document.getElementById("search_actor_results");

    const apiKey = "572048c03066a9b129b919b78cc7e6fc"; // API Key de TMDb

    if (!searchInput || !searchResults) {
        return;
    }

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

                    searchResults.innerHTML = "<p>Cargando resultados...</p>";

                    axios
                        .get(`https://api.themoviedb.org/3/search/person`, {
                            params: {
                                api_key: apiKey,
                                query: query,
                                language: "es-ES",
                            },
                            cancelToken: cancelToken.token,
                        })
                        .then((response) => {
                            const actors = response.data.results;
                            cache.set(query, actors);
                            displayResults(actors);
                        })
                        .catch((error) => {
                            if (axios.isCancel(error)) {
                                console.log("Request canceled:", error.message);
                            } else {
                                console.error("Error fetching data:", error);
                            }
                        })
                        .finally(() => {
                            searchResults.innerHTML = "";
                        });
                }
            }, 300);
        }
    });

    function displayResults(actors) {
        searchResults.innerHTML = "";

        actors.forEach((actor) => {
            const li = document.createElement("li");
            li.classList.add("list-group-item");

            const actorInfoContainer = document.createElement("div");
            actorInfoContainer.classList.add(
                "actor-info-container",
                "flex",
                "items-center"
            );

            const name = document.createElement("div");
            name.textContent = actor.name;
            name.classList.add("actor-name", "flex-grow");
            actorInfoContainer.appendChild(name);

            if (actor.profile_path) {
                const img = document.createElement("img");
                img.src = `https://image.tmdb.org/t/p/w45${actor.profile_path}`;
                img.alt = actor.name;
                img.classList.add("actor-poster", "ml-2", "rounded-full");
                actorInfoContainer.appendChild(img);
            }

            li.appendChild(actorInfoContainer);
            searchResults.appendChild(li);

            actorInfoContainer.addEventListener("click", () => fillForm(actor));
        });
    }

    function fillForm(actor) {
        console.log(actor);
        document.getElementById("nombre").value = actor.name || "";

        axios
            .get(`https://api.themoviedb.org/3/person/${actor.id}`, {
                params: {
                    api_key: apiKey,
                    language: "es-ES",
                },
            })
            .then((response) => {
                const actorDetails = response.data;
                document.getElementById("nombre").value =
                    actorDetails.name || "";
                document.getElementById("fecha_nac").value =
                    actorDetails.birthday || "";
                document.getElementById("lugar_nac").value =
                    actorDetails.place_of_birth || "";
                document.getElementById("bio").value =
                    actorDetails.biography || "";

                searchResults.innerHTML = "";
            })
            .catch((error) => {
                console.error("Error fetching actor details:", error);
            });
    }
});

// BUSCADOR DE DIRECTORES

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search_director");
    const searchResults = document.getElementById("search_results");
    const searchDirectorUrlMeta = document.querySelector(
        'meta[name="search-director-url"]'
    );

    if (!searchInput || !searchResults || !searchDirectorUrlMeta) {
        return;
    }

    const searchDirectorUrl = searchDirectorUrlMeta.getAttribute("content");
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

                    searchResults.innerHTML = "<p>Cargando resultados...</p>";

                    axios
                        .post(
                            searchDirectorUrl,
                            { query: query },
                            { cancelToken: cancelToken.token, ...axiosConfig }
                        )
                        .then((response) => {
                            const directors = response.data.results;
                            cache.set(query, directors);
                            displayResults(directors);
                        })
                        .catch((error) => {
                            if (axios.isCancel(error)) {
                                console.log("Request canceled:", error.message);
                            } else {
                                console.error("Error fetching data:", error);
                            }
                        })
                        .finally(() => {
                            searchResults.innerHTML = "";
                        });
                }
            }, 300);
        }
    });

    function displayResults(directors) {
        searchResults.innerHTML = "";

        directors.forEach((director) => {
            const li = document.createElement("li");
            li.classList.add("list-group-item");

            const directorInfoContainer = document.createElement("div");
            directorInfoContainer.classList.add(
                "director-info-container",
                "flex",
                "items-center"
            );

            const name = document.createElement("div");
            name.textContent = director.name;
            name.classList.add("director-name", "flex-grow");
            directorInfoContainer.appendChild(name);

            if (director.profile_path) {
                const img = document.createElement("img");
                img.src = `https://image.tmdb.org/t/p/w45${director.profile_path}`;
                img.alt = director.name;
                img.classList.add("director-poster", "ml-2", "rounded-full");
                directorInfoContainer.appendChild(img);
            }

            li.appendChild(directorInfoContainer);
            searchResults.appendChild(li);

            directorInfoContainer.addEventListener("click", () =>
                fillForm(director)
            );
        });
    }

    function fillForm(director) {
        console.log(director);
        document.getElementById("nombre").value = director.name || "";

        axios
            .get(`https://api.themoviedb.org/3/person/${director.id}`, {
                params: {
                    api_key: "572048c03066a9b129b919b78cc7e6fc",
                    language: "es-ES",
                },
            })
            .then((response) => {
                const directorDetails = response.data;
                document.getElementById("nombre").value =
                    directorDetails.name || "";
                document.getElementById("fecha_nac").value =
                    directorDetails.birthday || "";
                document.getElementById("lugar_nac").value =
                    directorDetails.place_of_birth || "";
                // Aquí puedes agregar más campos si es necesario

                searchResults.innerHTML = "";
            })

            .catch((error) => {
                console.error("Error fetching director details:", error);
            });
    }
});

// BUSCADOR DE SERIES

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search_serie");
    const searchResults = document.getElementById("search_serie_result");
    const searchSeriesUrlMeta = document.querySelector(
        'meta[name="search-series-url"]'
    );

    if (!searchInput || !searchResults || !searchSeriesUrlMeta) {
        return;
    }

    const searchSeriesUrl = searchSeriesUrlMeta.getAttribute("content");
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

                    searchResults.innerHTML = "<p>Cargando resultados...</p>";

                    axios
                        .post(
                            searchSeriesUrl,
                            { query: query },
                            { cancelToken: cancelToken.token, ...axiosConfig }
                        )
                        .then((response) => {
                            const series = response.data.results.slice(0, 10); // Limitar a los primeros 10 resultados
                            cache.set(query, series);
                            displayResults(series);
                        })
                        .catch((error) => {
                            if (axios.isCancel(error)) {
                                console.log("Request canceled:", error.message);
                            } else {
                                console.error("Error fetching data:", error);
                            }
                        })
                        .finally(() => {
                            searchResults.innerHTML = "";
                        });
                }
            }, 200); // Reducir el tiempo de espera inicial
        } else {
            searchResults.innerHTML = "";
        }
    });

    function displayResults(series) {
        searchResults.innerHTML = "";

        series.forEach((serie) => {
            const li = document.createElement("li");
            li.classList.add("list-group-item");

            const serieInfoContainer = document.createElement("div");
            serieInfoContainer.classList.add(
                "serie-info-container",
                "flex",
                "items-center"
            );

            const name = document.createElement("div");
            name.textContent = serie.name;
            name.classList.add("serie-name", "flex-grow");
            serieInfoContainer.appendChild(name);

            if (serie.poster_path) {
                const img = document.createElement("img");
                img.src = `https://image.tmdb.org/t/p/w45${serie.poster_path}`;
                img.alt = serie.name;
                img.classList.add("serie-poster", "ml-2", "rounded-full");
                serieInfoContainer.appendChild(img);
            }

            li.appendChild(serieInfoContainer);
            searchResults.appendChild(li);

            serieInfoContainer.addEventListener("click", () => fillForm(serie));
        });
    }

    function fillForm(serie) {
        console.log(serie);
        document.getElementById("titulo").value = serie.name || "";

        axios
            .get(`https://api.themoviedb.org/3/tv/${serie.id}`, {
                params: {
                    api_key: "572048c03066a9b129b919b78cc7e6fc",
                    language: "es-ES",
                },
                timeout: 60000, // Asegúrate de que el timeout esté configurado aquí si es necesario
            })
            .then((response) => {
                const serieDetails = response.data;
                document.getElementById("titulo").value =
                    serieDetails.name || "";

                const firstAirDate = serieDetails.first_air_date
                    ? serieDetails.first_air_date.split("-")[0]
                    : "";
                document.getElementById("fecha_estreno").value = firstAirDate;

                document.getElementById("descripcion").value =
                    serieDetails.overview || "";

                // Clear previous selection
                const directorSelect = document.getElementById("director_id");
                directorSelect.value = "";

                // Find and select the director in the dropdown by name
                const directors = serieDetails.created_by;
                if (directors.length > 0) {
                    for (let i = 0; i < directors.length; i++) {
                        const directorName = directors[i].name;
                        // Check if directorName exists in the options of the select
                        for (
                            let j = 0;
                            j < directorSelect.options.length;
                            j++
                        ) {
                            if (
                                directorSelect.options[j].text === directorName
                            ) {
                                directorSelect.selectedIndex = j;
                                break;
                            }
                        }
                    }
                }

                // Clear search results
                searchResults.innerHTML = "";
            })
            .catch((error) => {
                console.error("Error fetching series details:", error);
            });
    }
});
