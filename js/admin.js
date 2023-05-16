const titleUser = document.getElementById("titleUser");
const titleItem = document.getElementById("titleItem");
const titleCategory = document.getElementById("titleCategory");

const container = document.getElementById("container");
const divUser = document.getElementById("divUser");
const divItem = document.getElementById("divItem");
const divCategory = document.getElementById("divCategory");
const formItem = document.getElementById("formItem");
const formUser = document.getElementById("formUser");

let url = window.location.href;
console.log(url);
// console.log(divCategory);

// const stateObj = { foo: "bar" };
// window.history.replaceState(stateObj, "user", "admin.php?page=user");

divItem.style.display = "none";
divCategory.style.display = "none";

titleUser.addEventListener("click", () => {
  //   const stateObj = { foo: "bar" };
  //   window.history.replaceState(stateObj, "user", "admin.php?page=user");

  divUser.style.display = "block";
  divItem.style.display = "none";
  divCategory.style.display = "none";
});

titleItem.addEventListener("click", () => {
  //   const stateObj = { foo: "bar" };
  //   window.history.replaceState(stateObj, "item", "admin.php?page=item");

  divUser.style.display = "none";
  divItem.style.display = "block";
  divCategory.style.display = "none";
});

titleCategory.addEventListener("click", () => {
  //   const stateObj = { foo: "bar" };
  //   window.history.replaceState(stateObj, "category", "admin.php?page=category");

  divUser.style.display = "none";
  divItem.style.display = "none";
  divCategory.style.display = "block";
});

// formUser.addEventListener("submit", () => {
//   const stateObj = { foo: "bar" };
//   window.history.replaceState(stateObj, "item", "admin.php?page=item");

//   window.location = "boutique-en-ligne/php/admin.php?page=item";
// });
