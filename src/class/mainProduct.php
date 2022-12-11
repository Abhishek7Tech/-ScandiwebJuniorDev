<?php

namespace product;

abstract class Product
{
    // 1. PRODUCTS AND VALIDATION LOGIC

    // // Get input Values //
    abstract public function __construct($input);

    abstract protected function testInput($data);

    abstract public function check();
}
