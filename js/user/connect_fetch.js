const formEl = document.querySelector("#formLogin");
const message = document.querySelector("#message");

const password = document.querySelector("#password");
const buttonShow = document.getElementById("showPassword");

formEl.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formEl);
  const data = Object.fromEntries(formData);

  fetch("traitement/traitement_connect.php", {
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
      console.log(data);
      // message.style.color = "";
      if (data.erreur) {
        //   // message.style.display = "flex";
        message.innerHTML = data.erreur;
      } else {
        window.location.href = "http://localhost/boutique-en-ligne/index.php";
        //   // message.style.display = "flex";
        message.style.color = "green";
        message.innerHTML = data.succes;
        formEl.reset();
      }
    })
    .catch((error) => console.log(error));
});

showPassword(buttonShow, password);
