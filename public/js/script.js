document.addEventListener("DOMContentLoaded", function () {
    const rubriques = document.querySelectorAll(".rubrique");

    rubriques.forEach(rubrique => {
        rubrique.addEventListener("click", function () {
            const sousRubriques = this.querySelector(".sous-rubriques");
            if (sousRubriques) {
                const isDisplayed = sousRubriques.style.display === "block";
                sousRubriques.style.display = isDisplayed ? "none" : "block";
            }
        });
    });
});
