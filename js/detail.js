let stock = document.querySelectorAll("#stock");
stock.forEach((element) => {
  checkStock(element.textContent, element);
});

let textarea = document.getElementById("TextareaComment");
let count = document.getElementById("count");

textarea.addEventListener("keyup", () => {
  count.innerText = `${textarea.value.length}/2000`;
  if (textarea.value.length > 2000) {
    count.style.color = "#c7161d";
  } else {
    count.style.color = "";
  }
});
