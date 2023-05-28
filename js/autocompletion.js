let searchResultsInput = document.getElementById("searchBar"); //le input desktop
let searchInputBurger = document.getElementById("searchBarBurger"); //le input dans le burger
let searchResultsDesktopDiv = document.getElementById(
  "searchResultsDesktopDiv"
); //la div globale
// let searchResults = document.getElementById("searchResultsDesktop"); //la div des résultats

// todo : creer une fonction de recherche article avec le nom
//findItem(ItemName):[]

// if (searchResultsInput) {
searchResultsInput.addEventListener("keyup", () => {
  // console.log(searchResultsInput.value);
  searchResultsDesktopDiv.innerHTML = "";
  if (searchResultsInput.value == "") {
    searchResultsDesktopDiv.style.display = "none";
  } else {
    searchResultsDesktopDiv.style.display = "block";
    // console.log(getPage());
    fetch(
      `./${getPage()[0]}autocompletion.php/?search=${searchResultsInput.value}`
    )
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        if (data.length == 0) {
          let noResult = document.createElement("p");
          noResult.innerText = "Aucun résultat trouvé";
          searchResultsDesktopDiv.append(noResult);
        }
        data.forEach((element) => {
          // console.log(searchResultsInput);
          // console.log(element.name);
          let resultsDiv = document.createElement("div");
          let resultsImgDiv = document.createElement("div");
          let resultsNameDescDiv = document.createElement("div");
          // let resultsDescDiv = document.createElement("div");
          let resultsImg = document.createElement("img");
          let resultsName = document.createElement("p");
          let resultsDesc = document.createElement("p");
          let resultsLink = document.createElement("a");

          resultsDiv.className = "resultsDiv";
          resultsImgDiv.className = "resultsImgDiv";
          resultsNameDescDiv.className = "resultsNameDiv";
          // resultsDescDiv.className = "resultsDescDiv";
          resultsImg.className = "resultsImg";
          resultsName.className = "resultsName";
          resultsDesc.className = "resultsDesc";
          resultsLink.className = "resultsLink";

          resultsImg.src = `.${
            getPage()[1]
          }/assets/img_item/CorsairK55RGBPRO.webp`;
          resultsName.innerText = element.name;
          resultsDesc.innerText = element.description;
          resultsLink.href = `./${getPage()[0]}detail.php?id=${element.id}`;
          // console.log("hello");

          // for(i=0; i < 5 ; i++){
          if (searchResultsDesktopDiv.children.length < 5) {
            resultsImgDiv.append(resultsImg);
            resultsNameDescDiv.append(resultsName, resultsDesc);
            resultsDiv.append(resultsImgDiv, resultsNameDescDiv);
            resultsLink.append(resultsDiv);
            searchResultsDesktopDiv.append(resultsLink);
          }
          // console.log(typeof element);
          // }

          // let searchResultsP = document.createElement("p");
          // searchResultsP.innerHTML = 'TEST results';
          // searchResults.append(searchResultsP);
        });
      });
  }
});
// }

// Permet de faire disparaitre la div des results quand on clique en dehors
window.addEventListener("click", function (e) {
  if (searchBar.contains(e.target) && searchResultsInput.value != "") {
    searchResultsDesktopDiv.style.display = "block";
    // Clicked in box
  } else {
    searchResultsDesktopDiv.style.display = "none";
    // Clicked outside the box
  }
});
