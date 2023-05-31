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

function fetchItems(url) {
  fetch(url)
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      console.log(data);
      data.forEach((element) => {
        console.log(element);
        let div1 = document.createElement("div");
        let div2 = document.createElement("div");
        let div3 = document.createElement("div");
        let div4 = document.createElement("div");
        let li = document.createElement("li");
        let itemImg = document.createElement("img");
        let itemName = document.createElement("p");
        let itemDesc = document.createElement("p");
        let itemLink = document.createElement("a");
        let itemPrice = document.createElement("p");

        itemImg.className = "resultsImg";

        itemImg.src = `../assets/img_item/` + element.name_image;

        li.append(itemImg, element.name, element.description, element.price);
        allItems.append(li);
      });
    });
}

fetchItems(`traitement_filter.php`);

// * générer les enfants dans le parent correspondant
for (let i = 0; i < categoryChild.length; i++) {
  categoryChild[i].addEventListener("click", () => {
    allItems.innerHTML = "";
    // console.log(`traitement_filter.php?subCategory=` + inputRadio[i].id);
    fetchItems(`traitement_filter.php?subCategory=` + categoryChild[i].id);
  });
}
