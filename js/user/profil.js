let email = document.querySelector("#email");
let firstname = document.querySelector("#firstname");
let lastname = document.querySelector("#lastname");
let password = document.querySelector("#password");
let message = document.querySelector("#message");
let formProfil = document.querySelector("#formProfil");
const buttonShow = document.getElementById("showPassword");

function updateUser() {
  // EMAIL
  if (isEmpty(email.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i> Le champ Email est vide.';
    return false;
  } else if (!validate()) {
    message.innerHTML =
      "<i class=\"fa-solid fa-circle-exclamation\"></i> L'adresse mail n'est pas valide.";
    return false;
  }
  // FIRSTNAME
  else if (isEmpty(firstname.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i> Le champ Firstname est vide';
    return false;
  } else if (!isLetter(firstname)) {
    // ! TROUVER UN REGEX POUR LES PRENOMS COMPOSER + ACCENTS + ENTRE 2/3 ET 30 CARACTERES
    message.innerHTML = "Champ firstname invalid";
    return false;
  }
  // LASTNAME
  else if (isEmpty(lastname.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i> Le champ Lastname est vide';
    return false;
  } else if (!isLetter(lastname)) {
    // ! TROUVER UN REGEX POUR LES PRENOMS COMPOSER + ACCENTS + ENTRE 2/3 ET 30 CARACTERES
    message.innerHTML = "Champ lastname invalid";
    return false;
  }
  // PASSWORD
  else if (isEmpty(password.value)) {
    message.innerHTML =
      '<i class="fa-solid fa-circle-exclamation"></i> Le champ Password est vide';
    return false;
  } else {
    return true;
  }
}

formProfil.addEventListener("submit", (e) => {
  if (!updateUser()) {
    e.preventDefault();
  }
});

showPassword(buttonShow, password);
