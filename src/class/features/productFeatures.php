<?php

namespace features;

class Feature
{

    public function getFeatureDetails($array)
    {
        return $this->featureDetails($array);
    }

    public function getFeatureName($array)
    {
        return $this->featureName($array);
    }


    public function getFeatureValues($array)
    {
        return $this->featureValues($array);
    }

    //  1.) filters array to get height widtth lenght weight etc..//
    protected function featureDetails($array)
    {
        $features = array_filter($array, fn ($key) => $key !== 'sku' && $key !== 'name' && $key !== 'price', ARRAY_FILTER_USE_KEY);
        return $features;
    }

    // 2.) sets keys name to dimensions when property is furniture //

    protected function featureName($array)
    {
        $property = array_keys($array);
        $keys = implode(" ", $property);
        $keys === "height length width" ? $keys = "dimensions" : $keys;
        return ucfirst($keys);
    }

    // 3. adds MB KG OR X to values according to size , weight and dimensions//

    protected function featureValues($array)
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
