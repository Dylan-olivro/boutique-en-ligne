const formEl = document.querySelector("#FormConnect");
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
      if (data.CONNECT_ERROR) {
        message.innerHTML = data.CONNECT_ERROR;
      } else {
        window.location.href = `${getURL()}index.php`;
        message.style.color = "green";
        message.innerHTML = data.CONNECT_SUCCES;
        formEl.reset();
      }
    })
    .catch((error) => console.log(error));
});

showPassword(buttonShow, password);
