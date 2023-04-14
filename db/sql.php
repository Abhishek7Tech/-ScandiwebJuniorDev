<?php

namespace database;

use Exception;
use mysqli;

require_once __DIR__ . '../../vendor/autoload.php';
// require_once realpath("./vendor/autoload.php");
require __DIR__ . "../../vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "../../");
$dotenv->load();

// N@9ovO1eJMxmM5J)
// handles DELETE INSERT AND GETDATA OPERATIONS //
class Database
{
    // RECIVED DATA //
    public $data;

    // SETS CONNECTION TO DATABASE //
    public function setConnection()
    {
        //DEV-ENV-VARIABLES
        $hostName = $_ENV["HOST_NAME"];
        $admin = $_ENV["NAME"];
        $password = $_ENV["PASSWORD"];
        $dbName = $_ENV["DB_NAME"];

        // // PROD_ENV_VARIABLES//
        // $hostName = $_ENV["PROD_HOST_NAME"];
        // $admin = $_ENV["PROD_NAME"];
        // $password = $_ENV["PROD_PASSWORD"];
        // $dbName = $_ENV["PROD_DB_NAME"];

        //Production Environment
        // $connection =  new mysqli($hostName, $admin, $password, $dbName);

        //Local Environment//
        // $connection =  new mysqli($hostName, $admin, $password);

        $connection =  new mysqli($hostName, $admin, $password, $dbName);
        if ($connection->connect_error) {
            die("Failed to connect: Try again Later");
            echo "<h1> Falied to connect to database! Contact Admin </h1> <br>";
        }

        return $connection;
    }

    // SETS DATA
    public function setData($data)
    {
        $defaultData = ["sku" => "0", "name" => "0", "price" => "0", "size" => "0", "height" => "0", "width" => "0", "length" => "0", "weight" => "0"];
        // echo "<br>DATA BEFORe<br>";
        // echo "<br>";
        // var_dump($data);

        $this->data = array_replace($defaultData, $data);
        // echo "<br>DATA AFTER<br>";
        // var_dump($this->data);
    }

    // INSERT DATA
    public function insertData()
    {
        return $this->insertProducts();
    }

    // GET DATA//
    public function getData()
    {
        return $this->retriveProducts();
    }

    // DELETE DATA//
    public function getDel($array)
    {
        return $this->deleteProduct($array);
    }

    public function getSKU()
    {
        return $this->skuExsist();
    }

    // USED TO CREATE TABLE ON DATABASE //
    // public function createTable()
    // {
    //     $connection = $this->setConnection();
    //     $sql = "CREATE TABLE products (
    //         id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //         sku varchar(255) NOT NULL UNIQUE,
    //         name varchar(255) NOT NULL,
    //         price INT NOT NULL,
    //         size INT DEFAULT '0',
    //         height INT DEFAULT '0',
    //         width INT DEFAULT '0',
    //         length INT DEFAULT '0',
    //         weight INT DEFAULT '0',
    //         reg_date TIMESTAMP DEFAULT
    //         CURRENT_TIMESTAMP ON UPDATE
    //         CURRENT_TIMESTAMP
    //     )";

    //     $connection->query($sql);
    // }

    // Checks if SKU exsist //
    protected function skuExsist()
    {
        $sku = $this->data["sku"];
        $connection = $this->setConnection();
        $sql = $connection->prepare("SELECT sku FROM products WHERE sku = ('$sku')");
        $sql->execute();
        $sql->bind_result($sku);
        $result = $sql->get_result();
        $sku = $result->fetch_assoc();
        $sql->close();
        $connection->close();
        return $sku;
    }

    // FUNCTION TO INSERT PRODUCT TO DATABASE USING MYSQLI  //
    protected function insertProducts()
    {

        // CREATES PLACEHOLDERS DYNAMICALLY //
        $placeholder = $this->getMap("?", array_values($this->data));

        // CREATES STRING PARAMETERS FOR BINDING //
        $itemType = $this->getMap("s", array_values($this->data));

        // CHANGE ARRAY TO STRING //
        $key = implode("`,`", array_keys($this->data));
        $value =  array_values($this->data);
        $placeholderValue = implode(" , ", $placeholder);
        $itemTypeValue = implode("", $itemType);
        // echo "VALUES <br>";
        // var_dump($value);
        try {
            $connection = $this->setConnection();
            $sql = $connection->prepare("INSERT INTO products (`$key`) VALUES ($placeholderValue)");
            $sql->bind_param("$itemTypeValue", $sku, $name, $price, $size, $height, $length, $width, $weight);
            $sku = $value[0];
            $name = $value[1];
            $price = $value[2];
            $size = $value[3];
            $height = $value[4];
            $length = $value[5];
            $width = $value[6];
            $weight = $value[7];
            $sql->execute();
            $sql->close();
            $connection->close();
            $value = array();
        } catch (Exception $e) {
            // SHOWS ALERT FOR DUPLICATE VALUES AND REDIRECT USER TO ADD PRODUCT PAGE//
            $message = json_encode($e->getMessage());
            if ($message) {
                echo "<script>
                console.log('Haya');
                // window.location.replace('./add-product.php');
                // alert($message);
                console.log($message);
                </script>";
            }
        }
    }

    // GET DATA FROM DATABASE TO DISPLAY ON LIST PRODUCT PAGE//
    protected function retriveProducts()
    {
        try {
            $connection = $this->setConnection();
            $sql = $connection->prepare("SELECT sku, name, price, size, height, length, width, weight FROM products");



            $sql->bind_result($sku, $name, $price, $size, $height, $length, $width, $weight);
            $sql->execute();
            $result = $sql->get_result();
            $products = $result->fetch_all(MYSQLI_ASSOC);
            $sql->close();
            $connection->close();
            return $products;
        } catch (Exception $e) {
            $message = json_encode($e->getMessage());
            echo " <br> $message . <br>";
        }
    }

    // DELETES PRODUCT FROM DATABSE //
    protected function deleteProduct($array)
    {
        $ids = $array;

        $itemType = $this->getMap("s", $ids);
        $placeholder = $this->getMap("?", $ids);

        $placeholderValue = implode(" , ", $placeholder);
        $itemTypeValue = implode("", $itemType);

        var_dump($ids);
        $connection = $this->setConnection();
        $sku = 'sku';

        try {
            $connection = $this->setConnection();
            $sql = $connection->prepare("DELETE FROM products WHERE ($sku) IN ($placeholderValue)");
            $sql->bind_param("$itemTypeValue", ...$ids);
            $sql->execute();
            $sql->close();
            $connection->close();
        } catch (Exception $e) {
            $message = json_encode($e->getMessage());
            echo "<br> $message <br>";
        }
    }

    // HELPER FUNCTION TO CREATE PLACEHOLDERS AND TYPES ACCORDINGLY//
    protected function getMap($input, $array)
    {
        return array_map(function ($a) use ($input) {
            return $a = $input;
        }, $array);
    }
}
