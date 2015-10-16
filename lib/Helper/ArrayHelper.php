<?php

namespace Tacone\Bees\Helper;

class ArrayHelper
{
    public static function undot($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            array_set($result, $key, $value);
        }

        return $result;
    }
}
