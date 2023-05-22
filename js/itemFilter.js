let parentElement = document.querySelectorAll(".categoryParentDiv");
let categoryParentDiv = document.querySelector(".categoryParentDiv");
// let categoryParent = document.querySelector(".categoryParent");
// let categoryChildDiv = document.querySelector(".categoryChildDiv");
let resultParent = document.querySelectorAll(".resultParent");
let categoryChildDiv = document.getElementById("categoryChildDiv");

// console.log(categoryChildDiv);

fetch(`../php/traitement_filter.php/`)
  .then((response) => {
    return response.json();
  })
  .then((data) => {
    // console.log(data);
    data.forEach((element) => {
      if (element.id_parent != 0) {
        // if (element.id_parent == element.id) {
        let p = document.createElement("p");

        // p.append(element.name);
        // categoryChildDiv.append(p);
        //   console.log(element);
        // }
      }
    });
  });
  
parentElement.forEach((parent) => {
  const enfants = parent.querySelectorAll(".categoryChildDiv");
  const id = parent.getAttribute("data-parent-id");
  parent.addEventListener("click", () => {
    console.log("Id parent : ", id);
  });

  enfants.forEach((enfant) => {
    const parentID = enfant.getAttribute("data-parent-id");
    enfant.addEventListener("click", () => {
      console.log("Id correspondant au parent : ", parentID);
    });
  });
});

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
