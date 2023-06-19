// function getID() {
//   let url = window.location.href;
//   let id = url.split("=")[1];
//   return id;
// }
// fetch(`traitement/traitement_detail.php?id=${getID()}`)
//   .then((response) => {
//     return response.json();
//   })
//   .then((data) => {
//     // console.log(data);
//     data.forEach((element) => {
//       console.log(element);
//     });
//   });

//! TEST POUR LA CROIX D'UN INPUT SEARCH
// const input = document.getElementById("test");
// console.log(input);
// input.addEventListener("change", () => {
//   console.log("ok");
//   console.log(input.value.length);
// });

let stock = document.querySelectorAll("#stock");
stock.forEach((element) => {
  checkStock(element.textContent, element);
});

let textarea = document.getElementById("TextareaComment");
let count = document.getElementById("count");

console.log(textarea.value);
textarea.addEventListener("keyup", () => {
  count.innerText = `${textarea.value.length}/2000`;
  if (textarea.value.length > 2000) {
    count.style.color = "#c7161d";
  } else {
    count.style.color = "";
  }
});
