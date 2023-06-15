let searchResultsInput = document.getElementById("searchBar"); //le input desktop
let categoriesUlDiv = document.getElementById("categoriesUlDiv");
let sectionNav = document.getElementById("sectionNav");
let searchBarBurgerDiv = document.getElementById("searchBarBurgerDiv"); //le input desktop
let searchInputBurger = document.getElementById("searchBarBurger"); //le input dans le burger
// let categoriesNav = document.getElementById("categoriesNav");
let searchResultsDesktopDiv = document.getElementById(
  "searchResultsDesktopDiv"
); //la div globale
let searchResultsBurgerDiv = document.getElementById("searchResultsBurgerDiv"); //la div globale
// let searchResults = document.getElementById("searchResultsDesktop"); //la div des résultats
// console.log(document.body.clientWidth);

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
        console.log(data);
        if (data.length == 0) {
          let noResult = document.createElement("p");
          noResult.innerText = "Aucun résultat trouvé";
          searchResultsDesktopDiv.append(noResult);
        }
        data.forEach((element) => {
          // console.log(element);
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

          resultsImg.src =
            `.${getPage()[1]}/assets/img_item/` + element.image_name;
          resultsName.innerText = element.product_name;
          resultsDesc.innerText = element.product_description;
          resultsLink.href = `./${getPage()[0]}detail.php?id=${
            element.product_id
          }`;
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

// window.addEventListener("resize", () => {
  // * autocomplétion concernant le burger
  if (document.body.clientWidth <= 768) {
    console.log(document.body.clientWidth);
    searchInputBurger.addEventListener("keyup", () => {
      console.log('keyup');
      searchResultsBurgerDiv.innerHTML = "";
      if (searchInputBurger.value == "") {
        searchResultsBurgerDiv.style.display = "none";
        categoriesUlDiv.style.display = "block";
      } else {
        categoriesUlDiv.style.display = "none";
        searchResultsBurgerDiv.style.display = "block";
        categoriesNav.style.position = "absolute";
        searchBarBurgerDiv.classList.add("searchBarBurgerDivChecked");
        fetch(
          `./${getPage()[0]}autocompletion.php/?search=${
            searchInputBurger.value
          }`
        )
          .then((response) => {
            return response.json();
          })
          .then((data) => {
            // console.log(data);
            if (data.length == 0) {
              let noResult = document.createElement("p");
              noResult.innerText = "Aucun résultat trouvé";
              searchResultsBurgerDiv.append(noResult);
            }
            data.forEach((element) => {
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

              resultsImg.src =
                `.${getPage()[1]}/assets/img_item/` + element.image_name;
              resultsName.innerText = element.product_name;
              resultsDesc.innerText = element.product_description;
              resultsLink.href = `./${getPage()[0]}detail.php?id=${
                element.product_id
              }`;

              if (searchResultsBurgerDiv.children.length < 5) {
                resultsImgDiv.append(resultsImg);
                resultsNameDescDiv.append(resultsName, resultsDesc);
                resultsDiv.append(resultsImgDiv, resultsNameDescDiv);
                resultsLink.append(resultsDiv);
                searchResultsBurgerDiv.append(resultsLink);
              }
            });
          });
      }
    });
  } else {
    searchResultsBurgerDiv.innerHTML = "";
    categoriesUlDiv.style.display = "";
  }
// });
