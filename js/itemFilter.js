let allItems = document.getElementById("allItems");
let categoryChild = document.querySelectorAll("input[type='radio']");
let resultParent = document.querySelectorAll(".resultParent");
let categoryParentRadio = document.querySelectorAll(
  "input[name='categoryParentRadio']"
);
let categoryParentName = document.querySelectorAll(".categoryParentName");
let urlGet = window.location.href;
let urlGetSplit = urlGet.split("=");
let urlGetId = urlGetSplit[1];
console.log(categoryParentRadio);

// * afficher ou cacher les child dans le parent correspondant au click du parent
categoryParentName.forEach((element) => {
  element.addEventListener("click", () => {
    let childElement = document.querySelectorAll(
      "#categoryChildDiv" + element.getAttribute("id")
    );
    childElement[0].classList.toggle("categoryChildDivBlock");
    // console.log(childElement);
  });
});
for (let i = 0; i < categoryParentRadio.length; i++) {
  categoryParentRadio[i].addEventListener("click", () => {
    console.log(categoryParentRadio[i].id);
    fetchItems(`traitement_filter.php?categoryParent=` + categoryParentRadio[i].id);
  });
}

/**
 * Fonction permettant l'affichage du contenu
 * @param url : requete visée dans la page traitement_filter.php
 */
function fetchItems(url) {
  fetch(url)
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      // console.log(data);
      data.forEach((element) => {
        // console.log(element);
        let divImg = document.createElement("div");
        let divNameDesc = document.createElement("div");
        let divImgNameDesc = document.createElement("div");
        let divPrice = document.createElement("div");
        let divGlobal = document.createElement("div");
        let li = document.createElement("li");
        let itemImg = document.createElement("img");
        let itemName = document.createElement("p");
        let itemDesc = document.createElement("p");
        let itemLink = document.createElement("a");
        let itemPrice = document.createElement("p");
        let itemStock = document.createElement("p");

        itemName.className = "itemName";
        itemDesc.className = "itemDesc";
        divImg.className = "divImg";
        itemImg.className = "itemImg";
        divNameDesc.className = "divNameDesc";
        divImgNameDesc.className = "divImgNameDesc";
        divPrice.className = "divPrice";
        divGlobal.className = "divGlobal";
        itemPrice.className = "itemPrice";
        itemStock.className = "itemStock";

        itemImg.src = `../assets/img_item/` + element.image_name;
        itemLink.href = `./${getPage()[0]}detail.php?id=${element.product_id}`;

        itemName.innerText = element.product_name;
        itemDesc.innerText = element.product_description;
        itemPrice.innerText = element.product_price + " €";

        // appele la fonction qui affihce le stock
        checkStock(element.product_stock, itemStock);

        divImg.append(itemImg);
        divNameDesc.append(itemName, itemDesc);
        divPrice.append(itemPrice, itemStock);
        itemLink.append(divImg, divNameDesc, divPrice);
        divGlobal.append(itemLink);
        li.append(divGlobal);
        allItems.append(li);
      });
    });
}

/**
 * Afficher les produits de la catégorie visée dans la nav
 */
if (urlGetId != null) {
  //  console.log(urlGetId);
  fetchItems(`traitement_filter.php?subCategory=` + urlGetId);
  for (let i = 0; i < categoryChild.length; i++) {
    if (urlGetId == categoryChild[i].id) {
      categoryChild[i].setAttribute("checked", true);
    }
  }
} else {
  console.log("pas d'id");
  //* exécution de la fonction fetchItems dès lors qu'on arrive sur la page
  fetchItems(`traitement_filter.php`);
}

// * générer les enfants dans le parent correspondant
for (let i = 0; i < categoryChild.length; i++) {
  categoryChild[i].addEventListener("click", () => {
    allItems.innerHTML = "";
    // console.log(`traitement_filter.php?subCategory=` + inputRadio[i].id);
    //* exécution de la fonction fetchItems dès lors qu'on clique sur une catégorie enfant
    fetchItems(`traitement_filter.php?subCategory=` + categoryChild[i].id);
    // console.log(categoryChild[i].id);
  });
}
