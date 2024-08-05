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
                        });
                }
            }, 2000); // Aumenta el tiempo de espera a 2 segundos
        } else {
            searchResults.innerHTML = "";
        }
    });

    function displayResults(directors) {
        searchResults.innerHTML = "";

        if (!directors || directors.length === 0) {
            searchResults.innerHTML = "<p>No se encontraron resultados.</p>";
            return;
        }

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
