// BUSCADOR DE CAPITULOS

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search_series");
    const searchResults = document.getElementById("search_series_results");
    const seasonsSelect = document.getElementById("seasons_select");
    const episodesSelect = document.getElementById("episodes_select");
    const seasonsContainer = document.getElementById("seasons_container");
    const episodesContainer = document.getElementById("episodes_container");

    const apiKey = "572048c03066a9b129b919b78cc7e6fc";
    if (
        searchInput &&
        searchResults &&
        seasonsSelect &&
        episodesSelect &&
        seasonsContainer &&
        episodesContainer
    ) {
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
        // Función para mostrar los resultados de la búsqueda de series
        function displaySeriesResults(series) {
            searchResults.innerHTML = "";

            series.forEach((serie) => {
                const li = document.createElement("li");
                li.classList.add("list-group-item");
                li.textContent = serie.name;

                li.addEventListener("click", function () {
                    fetchSeasons(serie.id); // Pasar el id de la serie a fetchSeasons
                    clearSeriesSelection(); // Ocultar el desplegable del buscador al seleccionar una serie
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
    }
});
