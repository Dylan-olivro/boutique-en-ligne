let parentElement = document.querySelectorAll(".categoryParentDiv");
let categoryParentDiv = document.querySelector(".categoryParentDiv");
// let categoryParent = document.querySelector(".categoryParent");
// let categoryChildDiv = document.querySelector(".categoryChildDiv");
let resultParent = document.querySelectorAll(".resultParent");
let categoryChildDiv = document.getElementById("categoryChildDiv");
let allItems = document.getElementById("allItems");
let inputRadio = document.querySelectorAll("input[type='radio']");
// let arrayRadio = [];
// console.log(inputRadio);


for (let i = 0; i < inputRadio.length; i++) {
  inputRadio[i].addEventListener("click", () => {
    allItems.innerHTML = "";
    // console.log(`traitement_filter.php?subCategory=` + inputRadio[i].id);
    fetch(`traitement_filter.php?subCategory=` + inputRadio[i].id)
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
          console.log(element);
          //       data.forEach((element) => {
          // });
        });
      });
  });
}

// if (element.id_parent != 0) {
// if (element.id_parent == element.id) {
// let p = document.createElement("p");
// p.append(element.name);
// categoryChildDiv.append(p);
// console.log(element.id);
// }
// }

// parentElement.forEach((parent) => {
//   const enfants = parent.querySelectorAll(".categoryChildDiv");
//   const id = parent.getAttribute("data-parent-id");
//   parent.addEventListener("click", () => {
//     // console.log("Id parent : ", id);
//   });

//   enfants.forEach((enfant) => {
//     const parentID = enfant.getAttribute("data-parent-id");
//     enfant.addEventListener("click", () => {
//       // console.log("Id correspondant au parent : ", parentID);
//     });
//   });
// });

// for (i = 0; i <= categoryParent.childNodes.length; i++) {
//   categoryChild[i].addEventListener("click", () => {
//     console.log(categoryChild[i].innerText);
//   });
// }
// for(i=0; i <= categoryParent.length; i++){
// categoryParent[i].addEventListener("click", () => {
//   console.log('PARENTTTT');
// });
// }
