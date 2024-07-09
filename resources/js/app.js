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

            serieInfoContainer.addEventListener("click", () => {
                fillForm(serie);
                searchResults.innerHTML = ""; // Ocultar la lista de resultados al seleccionar una serie
            });
        });

        // Agregar evento para ocultar la lista de resultados al hacer clic fuera de ella
        document.addEventListener("click", function (event) {
            const isClickInside = searchResults.contains(event.target);
            const isClickInput = event.target === searchInput;

            if (!isClickInside && !isClickInput) {
                searchResults.innerHTML = "";
            }
        });
    }

    function fillForm(serie) {
        console.log(serie);

        // Llenar el formulario con los datos básicos de la serie
        document.getElementById("titulo").value = serie.name || "";
        document.getElementById("fecha_estreno").value = serie.first_air_date
            ? serie.first_air_date.split("-")[0]
            : "";
        document.getElementById("descripcion").value = serie.overview || "";

        // Obtener nombres de géneros de la serie
        const genreNames = serie.genres.map((genre) => genre.name);

        // Función para seleccionar los géneros correspondientes en el select
        selectGenres(genreNames);

        // Obtener detalles adicionales de la serie, incluyendo el director
        axios
            .get(`https://api.themoviedb.org/3/tv/${serie.id}`, {
                params: {
                    api_key: "572048c03066a9b129b919b78cc7e6fc",
                    language: "es-ES",
                },
            })
            .then((response) => {
                const serieDetails = response.data;

                // Obtener nombres de los directores
                const directorNames = serieDetails.created_by.map(
                    (director) => director.name
                );

                // Seleccionar el director correspondiente en el select
                selectDirector(directorNames);

                // Aquí puedes manejar más detalles si los necesitas
                console.log("Detalles adicionales de la serie:", serieDetails);
            })
            .catch((error) => {
                console.error("Error al obtener detalles de la serie:", error);
            });
    }

    function selectGenres(genreNames) {
        const select = document.getElementById("generos");
        const options = select.options;

        for (let i = 0; i < options.length; i++) {
            if (genreNames.includes(options[i].textContent)) {
                options[i].selected = true;
            } else {
                options[i].selected = false;
            }
        }
    }

    function selectDirector(directorNames) {
        const directorSelect = document.getElementById("director_id");
        const options = directorSelect.options;

        for (let i = 0; i < options.length; i++) {
            if (directorNames.includes(options[i].textContent.trim())) {
                directorSelect.selectedIndex = i;
                break;
            }
        }
    }
});

// BUSCADOR DE CAPITULOS

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search_series");
    const searchResults = document.getElementById("search_series_results");
    const seasonsSelect = document.getElementById("seasons_select");
    const episodesSelect = document.getElementById("episodes_select");
    const seasonsContainer = document.getElementById("seasons_container");
    const episodesContainer = document.getElementById("episodes_container");

    const apiKey = "572048c03066a9b129b919b78cc7e6fc";

    // Listener para buscar series al escribir en el input de búsqueda
    searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            searchSeries(query);
        } else {
            clearSeriesSelection();
        }
    });

    // Función para buscar series en la API de TMDb
    function searchSeries(query) {
        const url = `https://api.themoviedb.org/3/search/tv?api_key=${apiKey}&query=${query}`;

        axios
            .get(url)
            .then((response) => {
                const series = response.data.results;
                displaySeriesResults(series);
            })
            .catch((error) => {
                console.error("Error fetching series:", error);
            });
    }

    // Función para mostrar los resultados de la búsqueda de series
    function displaySeriesResults(series) {
        searchResults.innerHTML = "";

        series.forEach((serie) => {
            const li = document.createElement("li");
            li.classList.add("list-group-item");
            li.textContent = serie.name;

            li.addEventListener("click", function () {
                fetchSeasons(serie.id); // Pasar el id de la serie a fetchSeasons
            });

            searchResults.appendChild(li);
        });
    }

    // Función para obtener las temporadas de una serie
    function fetchSeasons(serieId) {
        const url = `https://api.themoviedb.org/3/tv/${serieId}?api_key=${apiKey}&language=es-ES`;

        axios
            .get(url)
            .then((response) => {
                const seasons = response.data.seasons;
                displaySeasons(seasons, serieId); // Pasar el serieId a displaySeasons
            })
            .catch((error) => {
                console.error("Error fetching seasons:", error);
            });
    }

    // Función para mostrar las temporadas en un select
    function displaySeasons(seasons, serieId) {
        seasonsSelect.innerHTML =
            "<option value=''>Selecciona una temporada</option>";

        seasons.forEach((season) => {
            const option = document.createElement("option");
            option.textContent = `Temporada ${season.season_number}`;
            option.value = season.season_number;
            seasonsSelect.appendChild(option);
        });

        // Mostrar el select de temporadas y ocultar el de episodios
        seasonsContainer.style.display = "block";
        episodesContainer.style.display = "none";
        clearFormFields();

        // Guardar el serieId seleccionado para usarlo en fetchEpisodes
        seasonsSelect.dataset.serieId = serieId;
    }

    // Listener para cambiar de temporada y cargar los episodios
    seasonsSelect.addEventListener("change", function () {
        const selectedSeasonNumber = seasonsSelect.value;
        const serieId = seasonsSelect.dataset.serieId; // Obtener el serieId guardado
        if (selectedSeasonNumber && serieId) {
            fetchEpisodes(serieId, selectedSeasonNumber); // Pasar el serieId y selectedSeasonNumber
        } else {
            clearEpisodesSelection();
            clearFormFields();
        }
    });

    // Función para obtener los episodios de una temporada específica
    function fetchEpisodes(serieId, seasonNumber) {
        const url = `https://api.themoviedb.org/3/tv/${serieId}/season/${seasonNumber}?api_key=${apiKey}&language=es-ES`;

        axios
            .get(url)
            .then((response) => {
                const episodes = response.data.episodes;
                displayEpisodes(episodes);
            })
            .catch((error) => {
                console.error("Error fetching episodes:", error);
            });
    }

    // Función para mostrar los episodios en un select
    // Función para mostrar los episodios en un select
    // Función para mostrar los episodios en un select
    function displayEpisodes(episodes) {
        episodesSelect.innerHTML =
            "<option value=''>Selecciona un episodio</option>";

        episodes.forEach((episode) => {
            const option = document.createElement("option");
            option.textContent = `Episodio ${episode.episode_number}: ${episode.name}`;
            option.value = episode.episode_number;

            // Guardar los datos del episodio en atributos data-
            option.dataset.title = episode.name;
            option.dataset.sinopsis = episode.overview;
            option.dataset.fechaEstreno = episode.air_date;
            option.dataset.episodeNumber = episode.episode_number; // Añadir el número de episodio

            episodesSelect.appendChild(option);
        });

        // Mostrar el select de episodios y limpiar los campos del formulario
        episodesContainer.style.display = "block";
        clearFormFields();
    }

    // Listener para cambiar de episodio y llenar el formulario automáticamente
    episodesSelect.addEventListener("change", function () {
        const selectedOption =
            episodesSelect.options[episodesSelect.selectedIndex];
        if (selectedOption) {
            document.getElementById("title").value =
                selectedOption.dataset.title || "";
            document.getElementById("sinopsis").value =
                selectedOption.dataset.sinopsis || "";
            document.getElementById("fecha_estreno").value =
                selectedOption.dataset.fechaEstreno || "";
            document.getElementById("episode").value =
                selectedOption.dataset.episodeNumber || "";
        } else {
            clearFormFields(); // Limpia los campos del formulario si no se selecciona un episodio válido
        }
    });

    // Función para limpiar la selección de series y temporadas
    function clearSeriesSelection() {
        searchResults.innerHTML = "";
        seasonsSelect.innerHTML =
            "<option value=''>Selecciona una temporada</option>";
        seasonsContainer.style.display = "none";
        clearEpisodesSelection();
        clearFormFields();
    }

    // Función para limpiar la selección de episodios y ocultar el select
    function clearEpisodesSelection() {
        episodesSelect.innerHTML =
            "<option value=''>Selecciona un episodio</option>";
        episodesContainer.style.display = "none";
    }

    // Función para limpiar los campos del formulario
    function clearFormFields() {
        // Puedes limpiar otros campos del formulario aquí si es necesario
    }
});
