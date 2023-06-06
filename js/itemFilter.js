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

        itemImg.src = `../assets/img_item/` + element.name_image;
        itemLink.href = `./${getPage()[0]}detail.php?id=${element.id}`;

        itemName.innerText = element.name;
        itemDesc.innerText = element.description;
        itemPrice.innerText = element.price + " €";

        // appeler fonction stock ici
        checkStock(element.stock, itemStock);

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

fetchItems(`traitement_filter.php`);

// * générer les enfants dans le parent correspondant
for (let i = 0; i < categoryChild.length; i++) {
  categoryChild[i].addEventListener("click", () => {
    allItems.innerHTML = "";
    // console.log(`traitement_filter.php?subCategory=` + inputRadio[i].id);
    fetchItems(`traitement_filter.php?subCategory=` + categoryChild[i].id);
  });
}

