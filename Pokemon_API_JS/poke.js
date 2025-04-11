document.addEventListener("DOMContentLoaded", function () {
  let cards; 
  let buttonsContainer = document.querySelector(".header");
  let showAllButton = document.getElementById("showAll");
  let favoritesButton = document.querySelector("button[type='button']"); 

  async function fetchPokemon() {
    try {
      let response = await fetch("https://pokeapi.co/api/v2/pokemon?limit=30");
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return await response.json();
    } catch (error) {
      console.error("Failed to fetch Pokémon:", error);
    }
  }

  async function fetchTypes() {
    try {
      let response = await fetch("https://pokeapi.co/api/v2/type");
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return await response.json();
    } catch (error) {
      console.error("Failed to fetch Pokémon types:", error);
    }
  }

  async function displayPokemon() {
    const data = await fetchPokemon();
    if (!data || !data.results) return;

    const cardsContainer = document.querySelector(".cardsContainer");
    cardsContainer.innerHTML = ""; 

    for (let i = 0; i < data.results.length; i++) {
      const pokemon = data.results[i];


      let detailsResponse = await fetch(pokemon.url);
      let details = await detailsResponse.json();

      const card = document.createElement("li");
      card.classList.add("cards");
      card.innerHTML = `
            <div class="pokemon">
              <h2>${pokemon.name}</h2>
              <img src="${details.sprites.front_default}" alt="${pokemon.name}" />
            </div>
          </a>
          <button class="favorite-btn">Favorite</button>`
          ;

      // ajoute ou enlève la classe favorite à la carte
      details.types.forEach((type) => {
        card.classList.add(type.type.name);
      });

      const favoriteBtn = card.querySelector(".favorite-btn");
      favoriteBtn.addEventListener("click", () => {
        card.classList.toggle("favorite");
        if (card.classList.contains("favorite")) {
          favoriteBtn.textContent = "Remove from Favorites";
        } else {
          favoriteBtn.textContent = "Add to Favorites";
        }
      });

      cardsContainer.appendChild(card);
    }

    // met à jour la variable cards pour inclure les nouvelles cartes
    cards = document.querySelectorAll(".cards");
  }

  async function displayTypeButtons() {
    const typesData = await fetchTypes();
    if (!typesData || !typesData.results) return;

    typesData.results.forEach((type) => {
      let typeButton = document.createElement("button");
      typeButton.textContent = type.name;
      typeButton.addEventListener("click", () => {
        filterCards(type.name);
      });
      buttonsContainer.appendChild(typeButton);
    });
  }
 // la fonciton qui permet de filtrer les cartese en mettant display none à celle qui ne nous intéresse pas
  function filterCards(filter) {
    cards.forEach((card) => {
      if (filter === "all") {
        card.style.display = "block";
      } else if (filter === "favorites") {
        if (card.classList.contains("favorite")) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      } else {
        if (card.classList.contains(filter)) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      }
    });
  }

  displayTypeButtons();
  displayPokemon();

  showAllButton.addEventListener("click", () => {
    filterCards("all");
  });

  // event listener pour le bouton favorite
  favoritesButton.addEventListener("click", () => {
    filterCards("favorites");
  });
});
