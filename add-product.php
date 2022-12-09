

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/main.css">
    <title>Product Add</title>
</head>

<body>

    <header class="header">
        <div class="main-heading">
            <h1> Product Add </h1>
        </div>
        <div class="btns">

            <div class="save-btn">
                <button class="save" name="submitbutton" type="submit" form="product_form"> Save </button>

                <!-- <button class="save" type="submit" form="product_form">
                    <a href="./list-product.html">Save</a></button> -->
            </div>
            <div class="cancel-btn">
                <button class="cancel" type="reset"><a href="./index.php">Cancel</a></button>
            </div>
        </div>
    </header>
    <main class="main">

        <form method="post" id="product_form" action="./index.php">
            <div class="info">
                <label for="SKU">SKU </label>
                <input type="text" id="sku" placeholder="SKU" name="sku" required>
                <br>

                <label for="NAME"> Name </label>
                <input type="text" id="name" placeholder="NAME" name="name" required><br>
                 
                <label for="PRICE"> PRICE ($) </label>
                <input type="number" id="price" placeholder="PRICE" name="price" required><br>
            </div>

            <div class="switcher">
                <label class="switch-label"  for="SWITCHER"> Type Switcher </label>
                <select id="productType" required name="SWITCHER">
                    <option value="" disabled selected id="switcher">Type Switcher</option>
                    <option value="dvd" id="Dvd">DVD</option>
                    <option value="furniture" id="Furniture">Furniture</option>
                    <option value="book" id="Book">Book</option>
                </select><br>

            </div>
            <div id="product-forms" class="switch-form-hide">

            </div>

        </form>


    </main>

    <footer class="footer">
        <span>Scandiweb Test assignment</span>
    </footer>

    <script src="./src/utils/add-product.js"></script>

</body>

</html>