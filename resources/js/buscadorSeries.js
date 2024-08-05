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
                        });
                }
            }, 2000); // Aumenta el tiempo de espera a 2 segundos
        } else {
            searchResults.innerHTML = "";
        }
    });

    function displayResults(series) {
        searchResults.innerHTML = "";

        if (!series || series.length === 0) {
            searchResults.innerHTML = "<p>No se encontraron resultados.</p>";
            return;
        }

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
                // Obtener nombres de los directores
                const directorNames = serieDetails.created_by.map(
                    (director) => director.name
                );

                // Clear search results
                searchResults.innerHTML = "";
                // Seleccionar el director correspondiente en el select
                selectDirector(directorNames);
            })
            .catch((error) => {
                console.error("Error fetching series details:", error);
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
