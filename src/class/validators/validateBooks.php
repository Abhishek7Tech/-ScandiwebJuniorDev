<?php

namespace validate;

class BookValidation extends Validation
{
    public $weight;
    public function __construct($input)
    {
        $this->sku = $input['sku'];
        $this->name = $input['name'];
        $this->price = $input['price'];
        $this->weight = $input['weight'];
    }
    public function check()
    {
        $this->testInput($this->weight);
    }
}
