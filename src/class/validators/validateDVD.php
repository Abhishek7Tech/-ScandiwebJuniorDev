<?php

namespace validate;

class DvdValidation extends Validation
{
    public $size;

    public function __construct($input)
    {
        $this->sku = $input['sku'];
        $this->name = $input['name'];
        $this->price = $input['price'];
        $this->size = $input['size'];
    }

    public function check()
    {
        $this->testInput($this->size);
    }
}
