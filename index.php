<?php

namespace database;
namespace  validate;

ob_start();

use database\Database;
use validate\Validation;
use validate\DvdValidation;
use validate\FurnitureValidation;

use function PHPSTORM_META\type;

require './src/validators/validate.php';
require './src/validators//validateDVD.php';
require './src/validators//validateFurniture.php';
require './src/validators//validateBooks.php';
require_once './db/sql.php';


// when user hits add in the add products all values are recived here//
if (isset($_POST["submitbutton"])) {
    $formInputs = new Validation(
        $_POST
    );


    // var_dump($formInputs->getInput());

    if ($_POST['SWITCHER'] === 'dvd') {
        $formInputs = new DvdValidation($_POST);
        $formInputs->check();
    }

    if ($_POST['SWITCHER'] === 'furniture') {
        $formInputs = new FurnitureValidation($_POST);
        $formInputs->check();
    }


    if ($_POST['SWITCHER'] === 'book') {
        $formInputs = new BookValidation($_POST);
        $formInputs->check();
    }
    $formData = (array)$formInputs;
    $formData = array_filter($formData, fn ($i) => $i !== 'input', ARRAY_FILTER_USE_KEY);
    // uses database class to insert data to database //
    $createDatabase = new Database();
    $createDatabase->setConnection();
    $createDatabase->setData($formData);

    // Shows alert based on sku sent by server. A little bit slow!//
    $skuExsist = $createDatabase->getSKU();

    if ($skuExsist !== null) {
        // echo "<script>
        // console.log('Haya');
        // window.location.replace('./add-product.php');
        // alert('SKU already exsist. Try something Unique 👍👍');
        // console.log('Caught you copy');
        // </script>";
    } else {
        $createDatabase->insertData();
        header("Location: index.php");
    }
}

?>

<?php
require_once __DIR__ . "/src/utils/product-list.php";
return;
