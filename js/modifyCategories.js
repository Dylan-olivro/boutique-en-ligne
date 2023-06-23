const formEl = document.querySelector("#FormCategories");
const message = document.querySelector("#messageCategories");

formEl.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formEl);
  const data = Object.fromEntries(formData);

  fetch("../traitement/traitement_modifyCategories.php", {
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
      if (data.CATEGORY_ERROR) {
        message.innerHTML = data.CATEGORY_ERROR;
      } else {
        formEl.reset();
        window.location.href = `${getURL()}php/admin.php`;
        message.style.color = "green";
        message.innerHTML = data.CATEGORY_SUCCES;
      }
    })
    .catch((error) => console.log(error));
});

