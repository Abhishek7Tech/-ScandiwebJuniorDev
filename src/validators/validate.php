<?php

namespace validate;

/**  validates and set user input
 * CHecks for common fields like
 * SKU ,NAME, PRICE
 *  */
class Validation
{
    public $input;
    public $sku;
    public $name;

    // Get input Values //
    public function __construct($input)
    {
        $this->input = $input;
        $this->sku = $input['sku'];
        $this->name = $input['name'];
        $this->price = $input['price'];
    }

    protected function testInput($data)
    {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function check()
    {

        $this->testInput($this->sku);
        $this->testInput($this->name);
        $this->testInput($this->price);
    }
}
