<?php

namespace Tacone\Bees\Transformator;

class TypeCaster
{
    public static function toString()
    {
        return function ($value) {
            return (string) $value;
        };
    }
    public static function toInteger()
    {
        return function ($value) {
            return (int) $value;
        };
    }
    public static function toFloat()
    {
        return function ($value) {
            return (float) $value;
        };
    }
}
