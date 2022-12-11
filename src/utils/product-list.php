<?php

use database\Database;
use features\Feature;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/main.css">
    <title>Product List</title>
</head>

<body>
    <header class="header">
        <div class="main-heading">
            <h1> Product List </h1>
        </div>

        <div class="btns">
            <div class="add-btn">
                <a href="add-product.php"> <button class="add" name="add-product" type="button">ADD</button></a>
            </div>
            <div class="delete-btn">
                <button class="delete" id="delete-product-btn" name="delete-product" type="submit">MASS DELETE</button>
            </div>
        </div>

    </header>

    <main class="main">
        <?php

        require_once __DIR__ . '../../../db/sql.php';
        require_once __DIR__ . '../../class/features/productFeatures.php';


        $createDatabase = new Database();
        $createDatabase->setConnection();
        $product = $createDatabase->getData();

        $feature = new Feature();

        // get ids from the product-list.js //
        $ids = trim(file_get_contents('php://input'));
        $idsArr = json_decode($ids, true);

        $skuArray = [];

        // html to display products on the list-product page //
        foreach ($product as $i) {
            $product = array_filter($i, fn ($val) => $val !== 0, ARRAY_FILTER_USE_BOTH);
            $sku = $product["sku"];
            $name = $product["name"];
            $price = $product["price"];

            array_push($skuArray, $sku);

            // $properties = featureDetails($product);
            $properties = $feature->getFeatureDetails($product);
            $keys = $feature->getFeatureName($properties);
            $values = $feature->getFeatureValues($properties);

            echo  '<div class="product-card" id =" ' . $sku . ' ">
            <div class="check">
            <input type="checkbox" id ="' . $sku . '" class="delete-checkbox">
            </div> 
            <div class="product-details">
            <h3 class="sku-text detail">' . strtoupper($sku) . '</h3>
            <span class="name-text detail">' . $name . '</h3>
            <span class="price-text detail">' . $price . ' $ </span>
            <span class="features detail ">' . $keys . ':' . $values . '</span>
            </div>   
            </div>';
        }
        $skuCookies = implode(" ", $skuArray);
        // checks if array is null //
        if ($idsArr !== null) {
            // pass id values to getDEl function to be deleted //
            $createDatabase->getDel($idsArr);
        }
        echo "<script>
                document.cookie = 'sku=$skuCookies';
            </script>
        ";

        ?>
    </main>

    <footer class="footer">
        <span>Scandiweb Test assignment</span>
    </footer>
    <script type="text/javascript" src="./src/utils/product-list.js"></script>
</body>

</html>