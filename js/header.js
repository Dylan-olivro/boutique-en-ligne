// permet à la searchBar (en burger) de prendre tout le main pour bien voir les résultats.
let searchBarBurger = document.getElementById("searchBarBurger");
let searchBurgerDiv = document.getElementById("searchBurgerDiv");
let searchBar = document.getElementById("searchBar");
let darkMode = document.getElementById("darkMode");
let darkModeState = false;
let searchBarBurgerValue = searchBarBurger.value;
let allBody = document.body;

darkMode.addEventListener("click", () => {
  if (darkModeState == false) {
    allBody.classList.toggle("dark-mode");
    darkMode.src = "./assets/img_darkMode/sun.png";
    darkModeState = true;
  } else {
    allBody.classList.toggle("dark-mode");
    darkMode.src = "./assets/img_darkMode/moon.png";
    darkModeState = false;
  }
});

$(searchBarBurger).keyup(function () {
  if (searchBarBurger.value != "") {
    // console.log(searchBarBurger.value.length);
    searchBurgerDiv.classList.add("searchBarBurgerCSS");
  } else {
    // console.log(searchBarBurger.value);
    searchBurgerDiv.classList.remove("searchBarBurgerCSS");
  }
});
// fin de la searchBar en burger

// ! à ne pas utiliser mais c'est, pour info, une autre façon, en JS, de passer la searchbar dans le burger en déplaçant des div dans d'autres div au moment voulu (fonction addListener obsolète). La méthode utilisée finalement est en CSS avec une DIV 'display block' et une 'none'.
// let iconSite = document.getElementById("iconSite");
// let searchDiv = document.getElementById("searchDiv");
// var burger = window.matchMedia("(max-width: 991px)");
// function myFunction() {
//   if (burger.matches) {
//     $("#searchBar").prependTo("#navCategories");
//     searchDiv.style.display = "none";
//     console.log("YELLOW");
//   } else {
//     searchDiv.style.display = "block";
//     $("#searchBar").prependTo("#searchDiv");
//     console.log("PINK");
//   }
// }
// myFunction();
// burger.addListener(myFunction);
// ! fin de la fonction pour le burger
