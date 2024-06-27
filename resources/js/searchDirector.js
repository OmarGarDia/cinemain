function handleSearchChange(input) {
    const query = input.value.trim();
    const searchResults = document.getElementById("search_results");

    fetch(`/search-director?query=${encodeURIComponent(query)}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            displayResults(data.results);
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
            searchResults.innerHTML =
                '<li class="list-group-item">Error fetching data</li>';
        });
}

// Opcional: Define otras funciones necesarias (displayResults, fillForm, etc.)
function displayResults(results) {
    const searchResults = document.getElementById("search_results");
    searchResults.innerHTML = "";

    results.forEach((result) => {
        const li = document.createElement("li");
        li.classList.add("list-group-item");
        li.textContent = result.name;
        li.addEventListener("click", () => fillForm(result));
        searchResults.appendChild(li);
    });
}

function fillForm(director) {
    document.getElementById("nombre").value = director.name;
    document.getElementById("fecha_nac").value = director.birthdate;
    document.getElementById("lugar_nac").value = director.place_of_birth;
    // Puedes añadir más campos según sea necesario
}
