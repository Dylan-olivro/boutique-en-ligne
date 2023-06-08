const formEl = document.querySelector("#signup");
const message = document.querySelector("#message");

let cpassword = document.querySelector("#confirm_password");
let password = document.querySelector("#password");

const buttonShow = document.getElementById("showPassword");
const buttonShow2 = document.getElementById("showConfirmPassword");

formEl.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formEl);
  const data = Object.fromEntries(formData);

  fetch("traitement/traitement_signup.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json;charset=UTF-8",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      message.style.color = "";
      if (data.erreur) {
        // message.style.display = "flex";
        message.innerHTML = data.erreur;
      } else {
        window.location.href = `${getURL()}php/connectFetch.php`;
        // message.style.display = "flex";
        message.style.color = "green";
        message.innerHTML = data.succes;
        formEl.reset();
      }
    })
    .catch((error) => console.log(error));
});

showPassword(buttonShow, password);
showPassword(buttonShow2, cpassword);
