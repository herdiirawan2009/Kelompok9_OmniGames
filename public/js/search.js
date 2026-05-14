function getSearchKeyword() {
  const params = new URLSearchParams(window.location.search);
  return (params.get("q") || "").toLowerCase().trim();
}

function filterGames(keyword) {
  const cards = document.querySelectorAll(".game-card");
  let totalVisible = 0;

  cards.forEach((card) => {
    const title = card.querySelector("h4")?.textContent.toLowerCase() || "";
    const genre = card.querySelector(".genre")?.textContent.toLowerCase() || "";
    const specs = card.querySelector(".specs")?.textContent.toLowerCase() || "";
    const isMatch =
      title.includes(keyword) ||
      genre.includes(keyword) ||
      specs.includes(keyword);

    card.style.display = isMatch ? "" : "none";
    if (isMatch) totalVisible += 1;
  });

  const emptyMessage = document.getElementById("empty-search-message");
  if (emptyMessage) {
    emptyMessage.style.display = totalVisible === 0 ? "block" : "none";
  }
}

function handleSearch() {
  const input = document.getElementById("searchInput");
  const keyword = input.value.trim();

  if (keyword === "") {
    alert("Masukkan judul game atau genre terlebih dahulu.");
    return;
  }

  window.location.href = `katalog?q=${encodeURIComponent(keyword)}`;
}

document.addEventListener("DOMContentLoaded", () => {
  const searchButton = document.getElementById("searchButton");
  const searchInput = document.getElementById("searchInput");

  if (searchButton && searchInput) {
    searchButton.addEventListener("click", handleSearch);
    searchInput.addEventListener("keydown", (event) => {
      if (event.key === "Enter") handleSearch();
    });
  }

  const keyword = getSearchKeyword();
  if (keyword !== "") {
    if (searchInput) searchInput.value = keyword;
    filterGames(keyword);
  }
});
