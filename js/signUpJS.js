let email = document.querySelector("#email");
let lastname = document.querySelector("#lastname");
let firstname = document.querySelector("#firstname");
let password = document.querySelector("#password");
let cpassword = document.querySelector("#confirm_password");
let formSignUp = document.querySelector("#signup");
let message = document.querySelector("#message");
// console.log(lastname.value);
// laplateforme.io 15 carac
function checkEmail(email) {
  let re =
    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,10}))$/;
  return re.test(email.value);
}

function validate() {
  // let email = document.getElementById("email").value;

  if (checkEmail(email)) {
    message.innerText = "Adresse e-mail valide";
    return true;
  } else {
    message.innerText = "Adresse e-mail non valide";
    return false;
  }
}
function allLetter(inputtxt) {
  let letters = /^[A-Za-z]+$/;
  if (inputtxt.value.match(letters)) {
    return true;
  }
  return false;
}
function isSignUp() {
  // console.log(allLetter(lastname));
  // console.log("TEST");
  // console.log(email);
  // console.log(validate(email));
  // console.log(email.value);
  if (email.value == "") {
    message.innerText = "Empty email field";
    return false;
  } else if (validate() == false) {
    return false;
  } else if (firstname.value == "") {
    message.innerText = "Empty firstname field";
    return false;
  } else if (allLetter(firstname) == false) {
    message.innerText = "Champ firstname invalid";
    return false;
  } else if (lastname.value == "") {
    message.innerText = "Empty lastname field";
    return false;
  } else if (allLetter(lastname) == false) {
    message.innerText = "Champ lastname invalid";
    return false;
  } else if (password.value == "") {
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
    // console.log("tetet");
    e.preventDefault();
  }
});
