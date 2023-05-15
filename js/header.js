// $(document).ready(function() {
//     $("button").click(function() {
//         $("#submit").appendTo("#container");
//     })
// });

let iconSite = document.getElementById("iconSite");
let searchDiv = document.getElementById("searchDiv");
var burger = window.matchMedia("(max-width: 991px)");

$("#iconSite").on("click", function () {
  $("#navCategories").prependTo("#testDiv");
});

console.log("hello");

function myFunction() {
  if (burger.matches) {
    // If media query matches
    $("#searchBar").prependTo("#navCategories");
    searchDiv.style.display = "none";
    iconSite.style.backgroundColor = "yellow";
    console.log("YELLOW");
  } else {
    searchDiv.style.display = "block";
    $("#searchBar").prependTo("#searchDiv");
    iconSite.style.backgroundColor = "pink";
    console.log("PINK");
  }
}

myFunction(); // Call listener function at run time
burger.addListener(myFunction); // Attach listener function on state changes
