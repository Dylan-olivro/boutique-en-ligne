function isEmpty($a) {
  return $a == "" ? true : false;
}
function isSame($a, $b) {
  return $a == $b ? true : false;
}
// FUNCTION POUR OBLIGER L'UTILISATEUR A METTRE QUE DES LETTRES
function isLetter(inputtxt) {
  let letters = /^[A-Za-z]+$/;
  if (inputtxt.value.match(letters)) {
    return true;
  }
  return false;
}

// FUNCTION POUR OBLIGER L'UTILISATEUR A METTRE QUE DES NOMBRES
function isNumber(inputnumber) {
  let numbers = /^\d*(.\d{0,2})?$/;
  if (inputnumber.value.match(numbers)) {
    return true;
  }
  return false;
}

// LES FONCTIONS checkEmail ET validate SERVENT A VERIFIER SI L'EMAIL EST CONFORME
function checkEmail(email) {
  let regex =
    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,10}))$/;
  return regex.test(email.value);
}

function validate() {
  if (checkEmail(email)) {
    return true;
  } else {
    message.innerText = "Adresse e-mail non valide";
    return false;
  }
}

// Pour adapter le chemin de la page OU de l'image par rapport à la page actuelle
// ! modifier pour le plesk ET/OU pour chacun suivant son dossier racine
function getPage() {
  let url = window.location.href;
  let page = url.split("/")[5];
  // console.log(page);
  if (page == "php") {
    let php = "";
    let image = ".";
    return [php, image];
  } else {
    let php = "php/";
    let image = "";
    return [php, image];
  }
}

// FONCTION POUR MONTER OU CACHER LE MOT DE PASSE
function showPassword(button, password) {
  button.addEventListener("click", () => {
    if (password.type == "password") {
      password.type = "text";
      button.innerHTML = '<i class="fa-solid fa-eye"></i>';
    } else {
      password.type = "password";
      button.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
    }
  });
}
