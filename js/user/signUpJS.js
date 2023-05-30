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
    message.innerText = "Champ lastname invalid";
    return false;
  }
  // PASSWORD AND CONFIRM PASSWORD
  else if (isEmpty(password.value)) {
    message.innerText = "Empty password field";
    return false;
  } else if (isEmpty(cpassword.value)) {
    message.innerText = "Empty confirm password field";
    return false;
  } else if (!isSame(password.value, cpassword.value)) {
    message.innerText = "Different password";
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
