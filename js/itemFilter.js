let allItems = document.getElementById("allItems");
let chevronCat = document.querySelectorAll(".chevronCat");
let chevronCatIcon = document.querySelectorAll(".chevronCatIcon");
let triSelect = document.getElementById("triSelect");
let triCategories = document.getElementById("triCategories");
// let triCategoriesOptions = document.querySelectorAll("option[name='optionCat'");
let categoryChildDiv = document.querySelectorAll(".categoryChildDiv");
let categoryChild = document.querySelectorAll("input[name='subCategory']");
let resultParent = document.querySelectorAll(".resultParent");
let subCategoryName = document.querySelectorAll(".subCategoryName");
let subCategory = document.querySelectorAll(".subCategory");
let categoryParentRadio = document.querySelectorAll(
  "input[name='categoryParentRadio']"
);
let categoryParentName = document.querySelectorAll(".categoryParentName");
let urlGet = window.location.href;
let urlGetSplit = urlGet.split("?");
console.log(urlGetSplit);

let urlGetId;

if (urlGetSplit[1] != null) {
  urlGetId = "&subCategory=" + urlGetSplit[1].split("=")[1];
} else {
  urlGetId = "";
}
let fetchFilter = "traitement/traitement_filter.php";
let fetchTri = "traitement/traitement_tri.php";
triCategories.addEventListener("change", () => {
  let triCategoriesID = $("#triCategories option:selected").val();
  allItems.innerHTML = "";
  fetchItems(fetchFilter + `?categories=` + triCategoriesID);
});

// // * autre option d'affichage des filtres, pas par un select/option mais par des boutons
// let priceTri = document.getElementById("priceTri");
// let state = 1;
// $(priceTri).click(() => {
//   allItems.innerHTML = "";
//   if ((state == 1)) {
//     fetchItems(fetchTri + "?croissant");
//     state = 2;
//   } else if (state == 2) {
//     fetchItems(fetchTri + "?decroissant");
//     state = 1;
//   }
// });

/**
 * Système de filtre par tri, prix, etc
 */
$(triSelect).change(function () {
  let triSelected = $("#triSelect option:selected").text();
  if (triSelected) {
    allItems.innerHTML = "";
    switch (triSelected) {
      case "Popularité":
        fetchItems(fetchTri + "?populaire" + urlGetId);
        break;
      case "Nouveauté":
        fetchItems(fetchTri + "?nouveau" + urlGetId);
        break;
      case "Du - cher au + cher":
        fetchItems(fetchTri + "?croissant" + urlGetId);
        break;
      case "Du + cher au - cher":
        fetchItems(fetchTri + "?decroissant" + urlGetId);
        break;
      case "Alphabétique A-Z":
        fetchItems(fetchTri + "?aZ" + urlGetId);
        break;
      case "Alphabétique Z-A":
        fetchItems(fetchTri + "?zA" + urlGetId);
        break;
      case "Disponibilité":
        fetchItems(fetchTri + "?dispo" + urlGetId);
        break;

      default:
        break;
    }
    // * autre façon, pas avec SWITCH mais avec des if/else classiques
    //   if (triSelected == "Popularité") {
    //     fetchItems(fetchTri + "?populaire");
    //   } else if (triSelected == "Nouveauté") {
    //     fetchItems(fetchTri + "?nouveau");
    //   } else if (triSelected == "Du - cher au + cher") {
    //     fetchItems(fetchTri + "?croissant");
    //   } else if (triSelected == "Du + cher au - cher") {
    //     fetchItems(fetchTri + "?decroissant");
    //   } else if (triSelected == "Alphabétique A-Z") {
    //     fetchItems(fetchTri + "?aZ");
    //   } else if (triSelected == "Alphabétique Z-A") {
    //     fetchItems(fetchTri + "?zA");
    //   } else if (triSelected == "Disponibilité") {
    //     fetchItems(fetchTri + "?dispo");
    //   }
  }
});

/**
 * ! Système de filtre par catégories A EFFACER !!!!!!!!!!!!
 */
$(triCategories).change(function () {
  let triSelected = $("#triCategories option:selected").text();
  if (triSelected) {
    allItems.innerHTML = "";
    switch (triSelected) {
      case "1":
        fetchItems(fetchTri + "?populaire");
        break;
      case "2":
        fetchItems(fetchTri + "?nouveau");
        break;
      case "3":
        fetchItems(fetchTri + "?croissant");
        break;
      case "Du + cher au - cher":
        fetchItems(fetchTri + "?decroissant");
        break;
      case "Alphabétique A-Z":
        fetchItems(fetchTri + "?aZ");
        break;
      case "Alphabétique Z-A":
        fetchItems(fetchTri + "?zA");
        break;
      case "Disponibilité":
        fetchItems(fetchTri + "?dispo");
        break;

      default:
        break;
    }
  }
});

// * afficher ou cacher les child dans le parent correspondant au click du parent
for (let i = 0; i < categoryParentRadio.length; i++) {
  resultParent[i].addEventListener("click", () => {
    chevronCatIcon[i].classList.toggle("fa-chevron-down");
    chevronCatIcon[i].classList.toggle("fa-chevron-up");
    let childElement = document.querySelectorAll(
      "#categoryChildDiv" + categoryParentName[i].getAttribute("id")
    );
    childElement[0].classList.toggle("categoryChildDivBlock");
    allItems.innerHTML = "";
    fetchItems(fetchFilter + `?categoryParent=` + categoryParentRadio[i].id);
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
      data.forEach((element) => {
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

        // appele la fonction qui affiche le stock
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
if (urlGetSplit.length > 1) {
  let urlGetName = urlGetSplit[1].split("=")[0];
  let urlGetId = urlGetSplit[1].split("=")[1];
  if (urlGetName == "subCategory") {
    fetchItems(fetchFilter + `?subCategory=` + urlGetId);
    for (let i = 0; i < categoryChild.length; i++) {
      if (urlGetId == categoryChild[i].id) {
        categoryChild[i].setAttribute("checked", true);
        categoryChild[i].parentElement.parentElement.classList.toggle(
          "categoryChildDivBlock"
        );
      }
    }
  } else if (urlGetName == "categoryParent") {
    fetchItems(fetchFilter + `?categoryParent=` + urlGetId);
    for (let i = 0; i < categoryParentRadio.length; i++) {
      if (urlGetId == categoryParentRadio[i].id) {
        categoryParentRadio[i].setAttribute("checked", true);
        // categoryChildDiv[i].style.display = "block";
        categoryChildDiv[i].classList.toggle("categoryChildDivBlock");
      }
    }
  }
} else {
  //* exécution de la fonction fetchItems dès lors qu'on arrive sur la page
  fetchItems(fetchFilter);
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
    fetchItems(fetchFilter + `?subCategory=` + categoryChild[i].id);
  });
}

for (let i = 0; i < categoryParentRadio.length; i++) {
  categoryParentName[i].addEventListener("click", () => {
    allItems.innerHTML = "";
    categoryParentRadio[i].checked = true;
    let urlGetSplitCategorie = urlGet.split("?");
    let urlGetCategorie = urlGetSplitCategorie[0];

    //* permet de changer l'url pour rester cohérent avec l'id de la subcategory choisie
    history.pushState(
      {},
      "",
      urlGetCategorie + "?categoryParent=" + categoryParentRadio[i].id
    );
    // window.history.pushState({urlPath:'/page1'},"",'/page1')

    //* exécution de la fonction fetchItems dès lors qu'on clique sur une catégorie parent
    fetchItems(fetchFilter + `?categoryParent=` + categoryParentRadio[i].id);
  });
}
