let allItems = document.getElementById("allItems");
let categoryChild = document.querySelectorAll("input[type='radio']");
let categoryParent = document.querySelectorAll(".resultParent");

// * afficher ou cacher les child dans le parent correspondant au click du parent
categoryParent.forEach((element) => {
  element.addEventListener("click", () => {
    let childElement = document.querySelectorAll(
      "#categoryChildDiv" + element.getAttribute("id")
    );
    childElement[0].classList.toggle("categoryChildDivBlock");
  });
});

// * générer les enfants dans le parent correspondant
for (let i = 0; i < categoryChild.length; i++) {
  categoryChild[i].addEventListener("click", () => {
    allItems.innerHTML = "";
    // console.log(`traitement_filter.php?subCategory=` + inputRadio[i].id);
    fetch(`traitement_filter.php?subCategory=` + categoryChild[i].id)
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        data.forEach((element) => {
          let li = document.createElement("li");
          let itemImg = document.createElement("img");

          itemImg.className = "resultsImg";

          itemImg.src = `.${
            getPage()[1]
          }/assets/img_item/CorsairK55RGBPRO.webp`;

          li.append(itemImg, element.name, element.description, element.price);
          allItems.append(li);
        });
      });
  });
}
