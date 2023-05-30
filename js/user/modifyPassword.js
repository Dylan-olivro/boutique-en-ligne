let password = document.querySelector("#password");
let newPassword = document.querySelector("#new_password");
let message = document.querySelector("#message");
let formUpdatePassword = document.querySelector("#formUpdatePassword");

function updatePassword() {
  if (isEmpty(password.value)) {
    message.innerText = "Empty password field";
    return false;
  } else if (isEmpty(newPassword.value)) {
    message.innerText = "Empty new password field";
    return false;
  } else {
    return true;
  }
}

formUpdatePassword.addEventListener("submit", (e) => {
  if (!updatePassword()) {
    e.preventDefault();
  }
});
