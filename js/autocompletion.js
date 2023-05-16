let searchResultsInput = document.getElementById("searchBar"); //le input desktop
let searchInputBurger = document.getElementById("searchBarBurger"); //le input dans le burger
let searchResults = document.getElementById("searchResults"); //la div des résultats

console.log("hello Autocompletion");

// if (searchResultsInput) {
    searchResultsInput.addEventListener("keyup", () => {
      console.log(searchResultsInput.value);
//     searchResults.innerHTML = "";
//     if (searchResultsInput.value == "") {
//       searchResults.style.display = "none";
//     } else {
//       searchResults.style.display = "block";
    //   console.log("./php/autocompletion.php/?search=" + searchResultsInput.value);
      fetch("./php/autocompletion.php/?search=" + searchResultsInput.value)
        .then((response) => {
          return response.json();
        })
        .then((data) => {
            // console.log(data);
        //   data.forEach((element) => {
            console.log("element.nom");
            let searchResultsP = document.createElement("p");
            searchResultsP.innerHTML = 'TEST results';
            searchResults.appendChild(searchResultsP);
        //   });
        });
    // }
  });
// }
