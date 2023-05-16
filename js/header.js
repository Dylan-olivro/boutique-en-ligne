// permet à la searchBar (en burger) de prendre tout le main pour bien voir les résultats.
let searchBarBurger = document.getElementById("searchBarBurger");
let searchBurgerDiv = document.getElementById("searchBurgerDiv");

$(searchBarBurger).keyup(function () {
  console.log(searchBarBurger.value);
  if(searchBarBurger.value != ""){
    searchBurgerDiv.style.backgroundColor = "green";
    searchBurgerDiv.style.position = "absolute";
    searchBurgerDiv.style.margin = "0";
    searchBurgerDiv.style.padding = "0";
    searchBurgerDiv.style.top = "4em";
    searchBurgerDiv.style.left = "0";
    searchBurgerDiv.style.zIndex = "2";
    searchBurgerDiv.style.width = "100vw";
    searchBurgerDiv.style.height = "100vh"; 
  }else{
    searchBurgerDiv.style.backgroundColor = "yellow";
    searchBurgerDiv.style.position = "";
    searchBurgerDiv.style.margin = "";
    searchBurgerDiv.style.padding = "";
    searchBurgerDiv.style.top = "";
    searchBurgerDiv.style.left = "";
    searchBurgerDiv.style.zIndex = "";
    searchBurgerDiv.style.width = "";
    searchBurgerDiv.style.height = ""; 
}
});
// fin de la searchBar en burger

// ! à ne pas utiliser mais c'est, pour info, une autre façon, en JS, de passer la searchbar dans le burger (fonction addListener obsolète). La méthode utilisée finalement est en CSS avec une DIV 'display block' et une 'none'.
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
