let email = document.querySelector("#email");
let lastname = document.querySelector("#lastname");
let firstname = document.querySelector("#firstname");
let password = document.querySelector("#password");
let cpassword = document.querySelector("#confirm_password");
let formSignUp = document.querySelector("#signup");
let message = document.querySelector("#message");
const buttonShow = document.getElementById("showPassword");
const buttonShow2 = document.getElementById("showConfirmPassword");

// FONCTION INSCRIPTION
function isSignUp() {
  // EMAIL
  if (isEmpty(email.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Email est vide.';
    return false;
  } else if (!validate()) {
    message.innerHTML =
      "<i class=\"fa-solid fa-circle-exclamation\"></i>&nbspL'adresse mail n'est pas valide.";
    return false;
  }
  // FIRSTNAME
  else if (isEmpty(firstname.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Firstname est vide';
    return false;
  } else if (!isLetter(firstname)) {
    // ! TROUVER UN REGEX POUR LES PRENOMS COMPOSER + ACCENTS + ENTRE 2/3 ET 30 CARACTERES
    message.innerHTML = "Champ firstname invalid";
    return false;
  }
  // LASTNAME
  else if (isEmpty(lastname.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Lastname est vide';
    return false;
  } else if (!isLetter(lastname)) {
    // ! TROUVER UN REGEX POUR LES PRENOMS COMPOSER + ACCENTS + ENTRE 2/3 ET 30 CARACTERES
    message.innerHTML = "Champ lastname invalid";
    return false;
  }
  // PASSWORD AND CONFIRM PASSWORD
  else if (isEmpty(password.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Password est vide';
    return false;
  } else if (isEmpty(cpassword.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i>&nbspLe champ Confirm Password est vide';
    return false;
  } else if (!isSame(password.value, cpassword.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i>&nbspLes champs password sont différents.';
    return false;
  } else {
    return true;
  }
}

formSignUp.addEventListener("submit", (e) => {
  if (!isSignUp()) {
    e.preventDefault();
  }
});

showPassword(buttonShow, password);
showPassword(buttonShow2, cpassword);
