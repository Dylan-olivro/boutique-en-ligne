let allItems = document.getElementById("allItems");
let categoryChild = document.querySelectorAll("input[name='subCategory']");
let resultParent = document.querySelectorAll(".resultParent");
let subCategoryName = document.querySelectorAll(".subCategoryName");
let subCategory = document.querySelectorAll(".subCategory");
let categoryParentRadio = document.querySelectorAll(
  "input[name='categoryParentRadio']"
);
let categoryParentName = document.querySelectorAll(".categoryParentName");
let urlGet = window.location.href;
let urlGetSplit = urlGet.split("=");
let urlGetId = urlGetSplit[1];

// * afficher ou cacher les child dans le parent correspondant au click du parent
for (let i = 0; i < categoryParentRadio.length; i++) {
  categoryParentName[i].addEventListener("click", () => {
    let childElement = document.querySelectorAll(
      "#categoryChildDiv" + categoryParentName[i].getAttribute("id")
    );
    childElement[0].classList.toggle("categoryChildDivBlock");
    allItems.innerHTML = "";
    fetchItems(
      `traitement_filter.php?categoryParent=` + categoryParentRadio[i].id
    );
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
  // console.log("pas d'id");
  //* exécution de la fonction fetchItems dès lors qu'on arrive sur la page
  fetchItems(`traitement_filter.php`);
}

// * générer les contenu de la catégorie enfant sélectionnée
for (let i = 0; i < categoryChild.length; i++) {
  subCategoryName[i].addEventListener("click", () => {
    allItems.innerHTML = "";
    categoryChild[i].checked = true;
    let urlGetSplitCategorie = urlGet.split("?");
    let urlGetCategorie = urlGetSplitCategorie[0];

    //* permet de changer l'url pour rester cohérent avec l'id de la subcategory choisie
    history.pushState(
      {},
      "",
      urlGetCategorie + "?subCategory=" + categoryChild[i].id
    );
    // window.history.pushState({urlPath:'/page1'},"",'/page1')

    //* exécution de la fonction fetchItems dès lors qu'on clique sur une catégorie enfant
    fetchItems(`traitement_filter.php?subCategory=` + categoryChild[i].id);
    // console.log(categoryChild[i].id);
  });
}
