function getID() {
  let url = window.location.href;
  let id = url.split("=")[1];
  return id;
}
fetch(`./traitement_detail.php?id=${getID()}`)
  .then((response) => {
    return response.json();
  })
  .then((data) => {
    // console.log(data);
    data.forEach((element) => {
      console.log(element);
    });
  });
