<?php

namespace validate;

class BookValidation extends Validation
{
    public $weight;
    public function __construct($input)
    {
        if (array_key_exists('weight', $input)) {
            $this->sku = $input['sku'];
            $this->name = $input['name'];
            $this->price = $input['price'];
            $this->weight = $input['weight'];
        }
    }
    public function check()
    {
        if ($this->weight) {
            $this->testInput($this->weight);
            echo "CHECKING Books";

        }
    }
}
