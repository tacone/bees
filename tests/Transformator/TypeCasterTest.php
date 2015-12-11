<?php

namespace Tacone\Bees\Test;

use Tacone\Bees\Transformator\TypeCaster;

class TypeCasterTest extends BaseTestCase
{
    protected $baseUrl = '/';

    public function testToString()
    {
        $func = TypeCaster::toString();
        assertSame('1', $func(1));
        assertSame('1', $func('1'));
        assertSame('Hello', $func('Hello'));
    }
    public function testToInteger()
    {
        $func = TypeCaster::toInteger();
        assertSame(1, $func(1));
        assertSame(1, $func(1.0));
        assertSame(1, $func('1'));
    }
    public function testToFloat()
    {
        $func = TypeCaster::toFloat();
        assertSame((float) 1, $func(1));
        assertSame((float) 1, $func('1'));
    }
}
