const formProduct = document.querySelector("#formProduct");
const messageProduct = document.querySelector("#messageProduct");

formProduct.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formProduct);
  const imageInput = document.querySelector("#image");
  const imageFile = imageInput.files[0];
  formData.append("image", imageFile);

  fetch("../traitement/traitement_modifyProduct.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      if (data.PRODUCT_ERROR) {
        messageProduct.innerHTML = data.PRODUCT_ERROR;
      } else {
        window.location.href = `${getURL()}php/admin.php`;
        messageProduct.style.color = "green";
        messageProduct.innerHTML = data.PRODUCT_SUCCES;
        formProduct.reset();
      }
    })
    .catch((error) => console.log(error));
});
