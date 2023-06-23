const formEl = document.querySelector("#FormUpdateAddress");
const message = document.querySelector("#message");

formEl.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formEl);
  const data = Object.fromEntries(formData);

  fetch("../traitement/traitement_modifyAddress.php", {
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
      if (data.UPDATE_ADDRESS_ERROR) {
        message.innerHTML = data.UPDATE_ADDRESS_ERROR;
      } else {
        window.location.href = `${getURL()}php/profil.php`;
        message.style.color = "green";
        message.innerHTML = data.UPDATE_ADDRESS_SUCCES;
        formEl.reset();
      }
    })
    .catch((error) => console.log(error));
});
