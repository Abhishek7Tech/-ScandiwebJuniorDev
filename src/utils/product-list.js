"use strict";
const massDel = document.querySelector("#delete-product-btn");
const checked = document.querySelectorAll(".delete-checkbox");

let ids = [];
const cookies = document.cookie;
// listen to when user clicks check on each product card and push it to ids array//
checked.forEach((check) => {
  check.addEventListener("click", (event) => {
    const id = check.id;
    const idExists = ids.includes(id);

    //   //checks if id already exsist //
    if (idExists === true) {
      ids = ids.filter((i) => i !== id);
      return ids;
    }

    //   // if id exsist remove it else push ids //
    idExists === true ? (ids = ids.filter((i) => i !== id)) : ids.push(id);
  });
});

const getSkuArray = (cookie) => {
  const cookies = cookie.slice(4, cookie.length);
  const skuArray = cookies.split(" ");
  return skuArray;
};

let cookieArray = getSkuArray(cookies);
// listen to when user clicks delete button //
massDel.addEventListener("click", (event) => {
  event.preventDefault();
  ids.forEach((id) => {
    let newCookieArray = cookieArray.filter((sku) => sku !== id);
    cookieArray = newCookieArray;
    document.getElementById(id).parentElement.parentElement.remove();
  });

  // return if not checked //
  if (ids.length === 0) return;
  const jsonString = JSON.stringify(ids);
  // send ids to be deleted //
  fetch("src/utils/product-list.php", {
    method: "POST",
    mode: "same-origin",
    headers: { "Content-type": "application/json; charset=UTF-8" },
    body: jsonString,
  }).then((response) => response.text().then((id) => id));

  const newCookies = cookieArray.join(" ");
  console.log("New", newCookies);
  document.cookie = `sku=${newCookies}`;
   ids.splice(0, ids.length);
   
});
