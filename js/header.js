let chevronRight = document.querySelectorAll(".chevronRight");
let dropdownContent = document.querySelectorAll(".dropdown-content");
let backToCategories = document.querySelectorAll(".backToCategories");
let iconBurger = document.querySelector(".iconBurger");
let categoriesNav = document.querySelector(".categoriesNav");
let userIcon = document.querySelector(".userIcon");
let userLink = document.querySelector(".userLink");
let cartIcon = document.getElementById("cart-icon");

function burger(div) {
  div.classList.toggle("change");
}
iconBurger.addEventListener("click", () => {
  categoriesNav.classList.toggle("flexClass");
});

// window.addEventListener("click", function (e) {
//   if (userIcon.contains(e.target)) {
//     userLink.style.display = "flex";
//   } else {
//     userLink.style.display = "none";
//   }
// });

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

// * Dark mode
let allBody = document.body;
let darkModeIcon = document.getElementById("darkModeIcon");
let darkMode = document.getElementById("darkMode");

// * change l'icone dark/light mode au click
darkMode.addEventListener("click", () => {
  darkModeIcon.classList.toggle("fa-moon");
  darkModeIcon.classList.toggle("fa-sun");
});

//* On change le thème dans le localStorage pour qu'il soit mémorisé
(function () {
  let currentTheme = localStorage.getItem("theme") || null;
  allBody.classList.add(currentTheme);
})();

//* on alterne entre le dark mode et light mode au click de l'icone
function themeToggle() {
  allBody.classList.toggle("dark-mode");
  let theme = localStorage.getItem("theme");
  if (theme && theme === "dark-mode") {
    // darkModeIcon.classList.toggle("fa-sun");
    localStorage.setItem("theme", "");
  } else {
    // darkModeIcon.classList.toggle("fa-moon");
    localStorage.setItem("theme", "dark-mode");
  }
}
// * fin dark mode
