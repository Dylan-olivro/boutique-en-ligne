const email = document.querySelector("#email");
const password = document.querySelector("#password");
const message = document.querySelector("#message");
const formLogin = document.querySelector("#formLogin");
const buttonShow = document.getElementById("showPassword");

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

showPassword(buttonShow, password);
