let email = document.querySelector("#email");
let firstname = document.querySelector("#firstname");
let lastname = document.querySelector("#lastname");
let password = document.querySelector("#password");
let message = document.querySelector("#message");
let formProfil = document.querySelector("#formProfil");

function updateUser() {
  // EMAIL
  if (isEmpty(email.value)) {
    message.innerText = "Empty email field";
    return false;
  } else if (!validate()) {
    return false;
  }
  // FIRSTNAME
  else if (isEmpty(firstname.value)) {
    message.innerText = "Empty firstname field";
    return false;
  } else if (!isLetter(firstname)) {
    message.innerText = "Champ firstname invalid";
    return false;
  }
  // LASTNAME
  else if (isEmpty(lastname.value)) {
    message.innerText = "Empty lastname field";
    return false;
  } else if (!isLetter(lastname)) {
    message.innerText = "Champ firstname invalid";
    return false;
  }
  // PASSWORD
  else if (isEmpty(password.value)) {
    message.innerText = "Empty password field";
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
