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
                        });
                }
            }, 2000); // Aumenta el tiempo de espera a 2 segundos
        } else {
            searchResults.innerHTML = "";
        }
    });

    function displayResults(actors) {
        searchResults.innerHTML = "";

        if (!actors || actors.length === 0) {
            searchResults.innerHTML = "<p>No se encontraron resultados.</p>";
            return;
        }

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
