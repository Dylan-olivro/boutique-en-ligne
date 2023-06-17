const formEl = document.querySelector("#FormProfil");
const message = document.querySelector("#message");

let password = document.querySelector("#password");

const buttonShow = document.getElementById("showPassword");

formEl.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formEl);
  const data = Object.fromEntries(formData);

  fetch("traitement/traitement_profil.php", {
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
      if (data.UPDATE_ERROR) {
        // message.style.display = "flex";
        message.innerHTML = data.UPDATE_ERROR;
      } else {
        // message.style.display = "flex";
        message.style.color = "green";
        message.innerHTML = data.UPDATE_SUCCES;
        formEl.reset();
      }
    })
    .catch((error) => console.log(error));
});

showPassword(buttonShow, password);
