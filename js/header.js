// $(document).ready(function() {
//     $("button").click(function() {
//         $("#submit").appendTo("#container");
//     })
// });

let iconSite = document.getElementById("iconSite");
var burger = window.matchMedia("(max-width: 768px)");

$("#iconSite").on("click", function () {
  $("#navCategories").prependTo("#testDiv");
});

console.log("hello");

function myFunction() {
  if (burger.matches) {
    // If media query matches
    $("#searchBar").prependTo("#navCategories");
} else {
    $("#searchBar").prependTo("#navPrincipale");
    iconSite.style.backgroundColor = "pink";
    console.log("PINK");
  }
}

myFunction(); // Call listener function at run time
burger.addListener(myFunction); // Attach listener function on state changes
