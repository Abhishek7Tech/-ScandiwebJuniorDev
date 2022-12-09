<?php

namespace validate;

class FurnitureValidation extends Validation
{
    public $height;
    public $width;
    public $length;

    public function __construct($input)
    {
        $this->sku = $input['sku'];
        $this->name = $input['name'];
        $this->price = $input['price'];
        $this->height = $input['height'];
        $this->width = $input['width'];
        $this->length = $input['length'];
    }

    public function check()
    {
        $this->testInput($this->height);
        $this->testInput($this->width);
        $this->testInput($this->length);
    }
}
