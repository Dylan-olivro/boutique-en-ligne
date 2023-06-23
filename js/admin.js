// * Tout les Boutons SHOW
let showProducts = document.getElementById("showProducts");
let showCategories = document.getElementById("showCategories");
let showUsers = document.getElementById("showUsers");
// * Tout les Boutons HIDE
let hideProducts = document.getElementById("hideProducts");
let hideCategories = document.getElementById("hideCategories");
let hideUsers = document.getElementById("hideUsers");
// * Tout les Tableaux
let tableProducts = document.querySelector(".tableProducts");
let tableCategories = document.querySelector(".tableCategories");
let tableUsers = document.querySelector(".tableUsers");

// * HIDE and SHOW Products
showProducts.addEventListener("click", () => {
  tableProducts.style.display = "block";
  tableCategories.style.display = "none";
  tableUsers.style.display = "none";
});
hideProducts.addEventListener("click", () => {
  tableProducts.style.display = "none";
});

// * HIDE and SHOW Categories
showCategories.addEventListener("click", () => {
  tableCategories.style.display = "block";
  tableProducts.style.display = "none";
  tableUsers.style.display = "none";
});
hideCategories.addEventListener("click", () => {
  tableCategories.style.display = "none";
});

// * HIDE and SHOW Users
showUsers.addEventListener("click", () => {
  tableUsers.style.display = "block";
  tableProducts.style.display = "none";
  tableCategories.style.display = "none";
});
hideUsers.addEventListener("click", () => {
  tableUsers.style.display = "none";
});

// * STATS
let countUser = document.getElementById("countUser");
let countProduct = document.getElementById("countProduct");
let countOrder = document.getElementById("countOrder");
let avgOrder = document.getElementById("avgOrder");
let salesRevenues = document.getElementById("salesRevenues");

// setInterval(() => {
  fetchCount("product", countProduct, 1);
  fetchCount("user", countUser, 1);
  fetchCount("order", countOrder, 1);
  fetchCount("orderAverage", avgOrder, 2);
  fetchCount("salesRevenues", salesRevenues, 3);
// }, 1000);

function fetchCount(table, countDiv, sql) {
  fetch(`traitement/traitement_stats.php?${table}`)
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      if (sql == 1) {
        countDiv.innerText = data[0].nb;
      } else if (sql == 2) {
        let res = Math.round(data[0].avg * 100) / 100;
        countDiv.innerText = `${res}€`;
      } else if (sql == 3) {
        countDiv.innerText = `${data[0].sum}€`;
      }
    });
}

const formProduct = document.querySelector("#formProduct");
const messageProduct = document.querySelector("#messageProduct");

formProduct.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formProduct);
  const imageInput = document.querySelector("#image");
  const imageFile = imageInput.files[0];
  formData.append("image", imageFile);

  fetch("traitement/traitement_addProduct.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      if (data.PRODUCT_ERROR) {
        messageProduct.innerHTML = data.PRODUCT_ERROR;
      } else {
        messageProduct.style.color = "green";
        messageProduct.innerHTML = data.PRODUCT_SUCCES;
        formProduct.reset();
      }
    })
    .catch((error) => console.log(error));
});


const formCategories = document.querySelector("#FormCategories");
const messageCategories = document.querySelector("#messageCategories");


formCategories.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formCategories);
  const data = Object.fromEntries(formData);

  fetch("traitement/traitement_addCategories.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json;charset=UTF-8",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      if (data.CATEGORY_ERROR) {
        messageCategories.innerHTML = data.CATEGORY_ERROR;
      } else {
        messageCategories.style.color = "green";
        messageCategories.innerHTML = data.CATEGORY_SUCCES;
        formCategories.reset();
      }
    })
    .catch((error) => console.log(error));
});



//   fetch(`./stats.php?product`)
//     .then((response) => {
//       return response.json();
//     })
//     .then((data) => {
//       countProduct.innerText = data[0].nb;
//       return fetch(`./stats.php?user`)
//         .then((response) => {
//           return response.json();
//         })
//         .then((userData) => {
//           countUser.innerText = userData[0].nb;
//           console.log(userData);
//           return fetch(`./stats.php?order`)
//             .then((response) => {
//               return response.json();
//             })
//             .then((orderData) => {
//               countOrder.innerText = orderData[0].nb;
//             });
//         });
//     });
