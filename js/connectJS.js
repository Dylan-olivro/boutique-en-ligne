let email = document.querySelector("#email");
let password = document.querySelector("#password");
let message = document.querySelector("#message");
let formLogin = document.querySelector("#formLogin");

function isLogin() {
  if (email.value == "") {
    message.innerText = "Empty email field";
    return false;
  } else if (password.value == "") {
    message.innerText = "Empty password field";
    return false;
  } else {
    return true;
  }
}
formLogin.addEventListener("submit", (e) => {
  if (isLogin() == false) {
    e.preventDefault();
  }
});
