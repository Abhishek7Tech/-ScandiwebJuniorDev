<?php

namespace validate;

class DvdValidation extends Validation
{
    public $size;

    public function __construct($input)
    {
        if (array_key_exists('size', $input)) {
            $this->sku = $input['sku'];
            $this->name = $input['name'];
            $this->price = $input['price'];
            $this->size = $input['size'];
        }
    }

    public function check()
    {
        if ($this->size) {
            $this->testInput($this->size);
            echo "CHECKING DVDDDD";
        }
    }
}
