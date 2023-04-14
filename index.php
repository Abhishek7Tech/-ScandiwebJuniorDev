<?php

namespace database;
namespace  validate;

ob_start();

use database\Database;
use validate\Validation;
use validate\DvdValidation;
use validate\FurnitureValidation;

use function PHPSTORM_META\type;

require './src/class/validators/validate.php';
require './src/class/validators//validateDVD.php';
require './src/class/validators//validateFurniture.php';
require './src/class/validators//validateBooks.php';
require_once './db/sql.php';



// when user hits add in the add products all values are recived here//
if (isset($_REQUEST["submitbutton"])) {
    $formInputs = new Validation(
        $_POST
    );

    // var_dump($formInputs->productType());

    // var_dump($_POST);

    // if ($_POST['SWITCHER'] === 'dvd') {
    //     $formInputs = new DvdValidation($_POST);
    //     $formInputs->check();
    // }

    // if ($_POST['SWITCHER'] === 'furniture') {
    //     $formInputs = new FurnitureValidation($_POST);
    //     $formInputs->check();
    // }


    // if ($_POST['SWITCHER'] === 'book') {
    //     $formInputs = new BookValidation($_POST);
    //     $formInputs->check();
    // }
    $formInputs->check();

    $dvdInput = new DvdValidation($_POST);
    $dvdInput->check();

    $furnitureInput =  new FurnitureValidation($_POST);
    $furnitureInput->check();

    $booksInput = new BookValidation($_POST);
    $booksInput->check();

    $formData = (array)$formInputs;
    $formData = array_filter($formData['input'], fn ($i) => $i !== 'submitbutton' && $i !== 'SWITCHER', ARRAY_FILTER_USE_KEY);


    // uses database class to insert data to database //
    $createDatabase = new Database();
    $createDatabase->setConnection();
    $createDatabase->setData($formData);

    // Shows alert based on sku sent by server. A little bit slow!//
    // $skuExsist = $createDatabase->getSKU();


    $createDatabase->insertData();
    header("Location: index.php");
}

?>

<?php
require_once __DIR__ . "/src/utils/product-list.php";
return;
