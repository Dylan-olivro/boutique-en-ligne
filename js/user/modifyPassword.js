let password = document.querySelector("#password");
let newPassword = document.querySelector("#new_password");
const buttonShow = document.getElementById("showPassword");
const buttonShow2 = document.getElementById("showNewPassword");

let message = document.querySelector("#message");
let formUpdatePassword = document.querySelector("#FormUpdatePassword");

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

showPassword(buttonShow, password);
showPassword(buttonShow2, newPassword);
