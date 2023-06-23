const formEl = document.querySelector("#formUser");
const message = document.querySelector("#message");

formEl.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formEl);
  const data = Object.fromEntries(formData);

  fetch("../traitement/traitement_modifyUser.php", {
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
      if (data.USER_ERROR) {
        message.innerHTML = data.USER_ERROR;
      } else {
        formEl.reset();
        // window.location.href = `${getURL()}php/admin.php`;
        message.style.color = "green";
        message.innerHTML = data.USER_SUCCES;
      }
    })
    .catch((error) => console.log(error));
});

