let chevronRight = document.querySelectorAll(".chevronRight");
let dropdownContent = document.querySelectorAll(".dropdown-content");
let backToCategories = document.querySelectorAll(".backToCategories");
let iconBurger = document.querySelector(".iconBurger");
let categoriesNav = document.querySelector(".categoriesNav");
let userIcon = document.querySelector(".userIcon");
let userLink = document.querySelector(".userLink");

function burger(div) {
  div.classList.toggle("change");
}
iconBurger.addEventListener("click", () => {
  // categoriesNav.toggle.style.display = "flex";
  categoriesNav.classList.toggle("flexClass");
});

// userIcon.addEventListener("click", () => {
//   userLink.classList.toggle("flexClass"); //en JS
//   // $(".userLink").toggle(); //en jquery
// });
window.addEventListener("click", function (e) {
  if (userIcon.contains(e.target)) {
    userLink.style.display = "flex";
  } else {
    userLink.style.display = "none";
  }
});

chevronRight.forEach((element) => {
  element.addEventListener("click", () => {
    dropdownContent.forEach((element2) => {
      if (element === element2.previousElementSibling) {
        element2.style.display = "block";
      }
    });
  });
});

backToCategories.forEach((backToCategoriesElement) => {
  backToCategoriesElement.addEventListener("click", () => {
    dropdownContent.forEach((element2) => {
      element2.style.display = "none";
    });
  });
});

let allBody = document.body;
let allHeader = document.header;
let darkMode = document.getElementById("darkMode");

darkMode.addEventListener("click", () => {
  let actualTheme = allBody.className;
  allBody.classList.toggle("dark-mode");
  localStorage.setItem("Mytheme", actualTheme);
});
if (localStorage.getItem("Mytheme")) {
  allBody.classList.toggle(localStorage.getItem("Mytheme"));
}
