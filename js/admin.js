let test = document.getElementById("test");
let tableProducts = document.querySelector(".tableProducts");
let closeButton = document.querySelector("#close");

test.addEventListener("click", () => {
  tableProducts.style.display = "block";
});

closeButton.addEventListener("click", () => {
  tableProducts.style.display = "none";
});

