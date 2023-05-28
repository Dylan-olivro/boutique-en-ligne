console.log("connecté");

// Je sélectionne et je stocke
// la DIV switch
const icon = document.getElementById("icon");
const switchBox = document.querySelector(".switch");
console.log(switchBox);
// la DIV btn (le cercle)
const btn = document.querySelector(".btn");
console.log(btn);
// l'icône
const icone = document.querySelector("i");
console.log(icone);
// la DIV container
const container = document.querySelector(".container");
console.log(container);
// le titre
const titre = document.querySelector("h1");
console.log(titre);

// Je soumets la DIV switch à une action au clic
switchBox.addEventListener("click", function () {
  console.log("DIV cliquée !");

  // Je déplace le cercle
  //btn.style.left = "60px";

  // J'utilise .classList.toggle
  btn.classList.toggle("btn-change");
  // Je change l'icône
  icon.classList.toggle("fa-moon");
  icon.classList.toggle("fa-sun");
//   icone.classList.add("fa-sun");
  // La DIV switch change de couleur de fond
  switchBox.classList.toggle("switch-change");
  // La DIV container change de couleur de fond
  container.classList.toggle("container-change");

  // Je modifie le texte du titre
  if (titre.innerText === "DARK MODE") {
    titre.innerText = "LIGHT MODE";
  } else {
    titre.innerText = "DARK MODE";
  }
});
