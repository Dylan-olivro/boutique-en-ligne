let email = document.querySelector("#email");
let firstname = document.querySelector("#firstname");
let lastname = document.querySelector("#lastname");
let password = document.querySelector("#password");
let message = document.querySelector("#message");
let formProfil = document.querySelector("#formProfil");

function updateUser() {
  // EMAIL
  if (email.value == "") {
    message.innerText = "Empty email field";
    return false;
  } else if (validate() == false) {
    return false;
  }
  // FIRSTNAME
  else if (firstname.value == "") {
    message.innerText = "Empty firstname field";
    return false;
  } else if (allLetter(firstname) == false) {
    message.innerText = "Champ firstname invalid";
    return false;
  }
  // LASTNAME
  else if (lastname.value == "") {
    message.innerText = "Empty lastname field";
    return false;
  } else if (allLetter(lastname) == false) {
    message.innerText = "Champ firstname invalid";
    return false;
  }
  // PASSWORD
  else if (password.value == "") {
    message.innerText = "Empty password field";
    return false;
  } else {
    return true;
  }
}

formProfil.addEventListener("submit", (e) => {
  if (updateUser() == false) {
    e.preventDefault();
  }
});
