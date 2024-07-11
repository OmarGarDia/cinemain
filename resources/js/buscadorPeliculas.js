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
