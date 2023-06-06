const email = document.querySelector("#email");
const password = document.querySelector("#password");
const message = document.querySelector("#message");
const formLogin = document.querySelector("#formLogin");
const buttonShow = document.getElementById("showPassword");

function isLogin() {
  if (isEmpty(email.value)) {
    message.innerText = "Empty email field";
    return false;
  } else if (isEmpty(password.value)) {
    message.innerText = "Empty password field";
    return false;
  } else {
    return true;
  }
}

formLogin.addEventListener("submit", (e) => {
  if (!isLogin()) {
    e.preventDefault();
  }
});

showPassword(buttonShow, password);
