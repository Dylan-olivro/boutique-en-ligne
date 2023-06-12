let stock = document.querySelectorAll(".stock");
stock.forEach((element) => {
  checkStock(element.textContent, element);
});
