let searchResultsInput = document.getElementById("searchBar"); //le input desktop
let searchInputBurger = document.getElementById("searchBarBurger"); //le input dans le burger
let searchResultsDesktopDiv = document.getElementById(
  "searchResultsDesktopDiv"
); //la div globale
// let searchResults = document.getElementById("searchResultsDesktop"); //la div des résultats

console.log("hello Autocompletion");

// if (searchResultsInput) {
searchResultsInput.addEventListener("keyup", () => {
  // console.log(searchResultsInput.value);
  searchResultsDesktopDiv.innerHTML = "";
  if (searchResultsInput.value == "") {
    searchResultsDesktopDiv.style.display = "none";
  } else {
    searchResultsDesktopDiv.style.display = "block";
    fetch("./php/autocompletion.php/?search=" + searchResultsInput.value)
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        console.log(data);
        data.forEach((element) => {
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

          resultsImg.src = element.image;
          resultsName.innerText = element.name;
          resultsDesc.innerText = element.description;
          resultsLink.href = "./php/item=" + element.id + ".php";

          resultsImgDiv.append(resultsImg);
          resultsNameDescDiv.append(resultsName, resultsDesc);
          resultsDiv.append(resultsImgDiv, resultsNameDescDiv);
          resultsLink.append(resultsDiv);
          searchResultsDesktopDiv.append(resultsLink);

          // let searchResultsP = document.createElement("p");
          // searchResultsP.innerHTML = 'TEST results';
          // searchResults.append(searchResultsP);
        });
      });
  }
});
// }
