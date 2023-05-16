let password = document.querySelector("#password");
let newPassword = document.querySelector("#new_password");
let message = document.querySelector("#message");
let formUpdatePassword = document.querySelector("#formUpdatePassword");

function updatePassword() {
  //   console.log(password.value);
  if (password.value == "") {
    message.innerText = "Empty password field";
    return false;
  } else if (newPassword.value == "") {
    message.innerText = "Empty new password field";
    return false;
  } else {
    return true;
  }
}

formUpdatePassword.addEventListener("submit", (e) => {
  if (updatePassword() == false) {
    e.preventDefault();
  }
});
