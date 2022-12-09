"use strict";
const sku = document.querySelector("#sku");
const names = document.querySelector("#name");
const price = document.querySelector("#price");
const switcherType = document.querySelector("#productType");
const switchForm = document.querySelector(".switch-form-hide");
const showProductForm = document.querySelector("#product-forms");
const save = document.querySelector(".save");
const form = document.getElementById("product_form");

let product;

// get user input is it dvd furniture or book and display inputs accordingly //
switcherType.addEventListener("change", function (event) {
  product = event.target.value;

  // checks if product equal to any of these 3 - dvd ,furniture,book//
  switchForm.innerHTML = "";
  product === "dvd" ? setDvdOptions() : "";
  product === "furniture" ? setFurnitureOptions() : "";
  product === "book" ? setBooksOptions() : "";

  showProductForm.className = "switch-form";
});

// set dvd options//
const setDvdOptions = () => {
  const Html = `<label for="Dvd"> Size (MB) </label>
                   <input id="size" type="number" placeholder="SIZE"  name="size" min="1" max="4500" jump=1 required><br>
                   <p class="description"><span> * <span> Size must be in MB. </p>`;

  switchForm.insertAdjacentHTML("afterbegin", Html);
};

// set furniture options //
const setFurnitureOptions = () => {
  const Html = `<label  for="Height"> Height (CM) </label>
                 <input id="height" type="number" min="1" placeholder="HEIGHT" name="height" required><br>
    
                <label  for="Width"> Width (CM) </label>
                <input id="width" type="number" placeholder="WIDTH" min="1" name="width" required><br>
    
                <label  for="Length"> Length (CM) </label>
                <input id="length" placeholder="LENGTH" type="number" min="1" name="length" required><br>
    
                <p class="description"> <span> * <span> Dimensions must be in CM. In HxWxL Format. </p>`;

  switchForm.insertAdjacentHTML("afterbegin", Html);
};

//set book options //
const setBooksOptions = () => {
  const Html = `<label for="Weight">Weight (KG) </label>
                <input id="weight" type="number" min="1" max="500" placeholder="WEIGHT" name="weight" required><br>
                
                <p class="description"> <span> * </span> Weight should be in KG. </p>`;

  switchForm.insertAdjacentHTML("afterbegin", Html);
};

// checks if form input are valid//
const switchFormInputs = (inputID) => {
  const isValid = inputID.map((e) => e.length > 0).filter((e) => e === true);
  return isValid.length === inputID.length;
};

// checks if sku contains only valid input//
const isValidSku = (str) => {
  const isValid = /^[A-Za-z0-9-]*$/.test(str);
  if (isValid === false) {
    alert(" 👺👺 Only letters , - and numbers allowed as SKU ⛔");
  }
  return isValid;
};

// checks if name contains only valid input//

const isValidName = (str) => {
  const isValid = /^[a-zA-Z0-9 ]*$/.test(str);
  if (isValid === false) {
    alert("👺👺 Only letters numbers and spaces are allowed as Name ⛔");
  }
  return isValid;
};

const skuExsist = (cookie) => {
  const cookies = cookie.slice(4, cookie.length);
  const skuArray = cookies.split(" ");
  if (skuArray.includes(sku.value)) {
    alert("⛔ Sku already exsist! Try something unique 👍👍");
    return true;
  }
  return false;
};

// // Save button Settings //
save.addEventListener("click", function (event) {
  const skuCookie = document.cookie;

  const size = switchForm.querySelector("#size");
  const height = switchForm.querySelector("#height");
  const width = switchForm.querySelector("#width");
  const length = switchForm.querySelector("#length");
  const weight = switchForm.querySelector("#weight");

  const parameters = [];

  // skuExsist(skuCookie);

  if (skuExsist(skuCookie) === true) {
    event.preventDefault();
    return;
  }

  // if sku is invalid return//
  if (isValidSku(sku.value) === false) {
    event.preventDefault();
    return;
  }

  // if name is invalid return//

  if (isValidName(names.value) === false) {
    event.preventDefault();
    return;
  }

  // insert paramneters according to products selected //
  if (product === "furniture") {
    parameters.push(height.value, width.value, length.value);
    return;
  }
  if (product === "dvd") {
    parameters.push(size.value);
    return;
  }
  if (product === "book") {
    parameters.push(weight.value);
    return;
  }
  // checks if input are valid and redirects user to product list page //
  sku.value.length &&
  price.value.length &&
  names.value.length > 0 &&
  product !== undefined &&
  switchFormInputs(parameters)
    ? (window.location = "index.php")
    : alert("Input is required");

});
