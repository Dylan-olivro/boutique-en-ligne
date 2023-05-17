let searchResultsInput = document.getElementById("searchBar"); //le input desktop
let searchInputBurger = document.getElementById("searchBarBurger"); //le input dans le burger
let searchResults = document.getElementById("searchResults"); //la div des résultats

console.log("hello Autocompletion");

// if (searchResultsInput) {
    searchResultsInput.addEventListener("keyup", () => {
      // console.log(searchResultsInput.value);
      if (searchResultsInput.value == "") {
      searchResults.innerHTML = ""; 
      searchResults.style.display = "none";
      searchResults.style.color = "green";
    } else {
      searchResults.style.color = "red";
      searchResults.style.display = "block";
    //   console.log("./php/autocompletion.php/?search=" + searchResultsInput.value);
      fetch("./php/autocompletion.php/?search=" + searchResultsInput.value)
        .then(response => {
        return response.json();
        })
        .then(data => {
            // console.log(data);
        //   data.forEach((element) => {
            // console.log(data);
            let searchResultsP = document.createElement("p");
            searchResultsP.innerHTML = 'TEST results';
            searchResults.append(searchResultsP);
        //   });
        });
    }
  });
// }
