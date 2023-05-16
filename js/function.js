// FUNCTION POUR OBLIGER L'UTILISATEUR A METTRE QUE DES LETTRES
function allLetter(inputtxt) {
  let letters = /^[A-Za-z]+$/;
  if (inputtxt.value.match(letters)) {
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
