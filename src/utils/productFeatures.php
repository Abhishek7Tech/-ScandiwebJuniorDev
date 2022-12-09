<?php

namespace features;

class Feature
{
    //  1.) filters array to get height widtth lenght weight etc..//
    public function featureDetails($array)
    {
        $features = array_filter($array, fn ($key) => $key !== 'sku' && $key !== 'name' && $key !== 'price', ARRAY_FILTER_USE_KEY);
        return $features;
    }

    // 2.) sets keys name to dimensions when property is furniture //

    public function featureName($array)
    {
        $property = array_keys($array);
        $keys = implode(" ", $property);
        $keys === "height length width" ? $keys = "dimensions" : $keys;
        return ucfirst($keys);
    }

    // 3. adds MB KG OR X to values according to size , weight and dimensions//

    public function featureValues($array)
    {
        $values = array_values($array);
        $keys = $this->featureName($array);
        $val = " ";
        $keys === "Size" ? $val = implode(" ", $values) . " MB" : '';
        $keys === "Weight" ? $val = implode(" ", $values) .  " Kg" : ' ';
        $keys === "Dimensions" ? $val = implode(" x ", $values) : ' ';
        return $val;
    }
}
