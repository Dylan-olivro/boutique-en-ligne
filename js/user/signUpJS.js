let email = document.querySelector("#email");
let lastname = document.querySelector("#lastname");
let firstname = document.querySelector("#firstname");
let password = document.querySelector("#password");
let cpassword = document.querySelector("#confirm_password");
let formSignUp = document.querySelector("#signup");
let message = document.querySelector("#message");

// FONCTION INSCRIPTION
function isSignUp() {
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
    message.innerText = "Champ lastname invalid";
    return false;
  }
  // PASSWORD
  else if (password.value == "") {
    message.innerText = "Empty password field";
    return false;
  } else if (cpassword.value == "") {
    message.innerText = "Empty confirm password field";
    return false;
  } else if (password.value !== cpassword.value) {
    message.innerText = "Different password";
    return false;
  } else {
    return true;
  }
}

formSignUp.addEventListener("submit", (e) => {
  if (isSignUp() == false) {
    e.preventDefault();
  }
});
