<?php

namespace Tacone\Bees\Helper;

class Error
{
    public static function missingMethod($object, $methodName)
    {
        // the method does not exist or it hasn't been exposed
        return new \BadMethodCallException(
            'Method \''.get_class($object)."::$methodName' does not exist"
        );
    }
}
