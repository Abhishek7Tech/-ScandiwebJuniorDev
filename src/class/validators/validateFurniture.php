<?php

namespace validate;

class FurnitureValidation extends Validation
{
    public $height;
    public $width;
    public $length;

    public function __construct($input)
    {
        if (array_key_exists('height', $input) && array_key_exists('width', $input) && array_key_exists('length', $input)) {
            $this->sku = $input['sku'];
            $this->name = $input['name'];
            $this->price = $input['price'];
            $this->height = $input['height'];
            $this->width = $input['width'];
            $this->length = $input['length'];
        }
    }

    public function check()
    {
        if ($this->height && $this->width && $this->length) {
            $this->testInput($this->height);
            $this->testInput($this->width);
            $this->testInput($this->length);
            echo "CHECKING FURNITURE";

        }
    }
}
