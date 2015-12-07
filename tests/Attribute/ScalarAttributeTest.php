<?php

namespace Tacone\Bees\Test;

use Tacone\Bees\Attribute\ScalarAttribute;

class ScalarAttributeTest extends BaseTestCase
{
    protected $baseUrl = '/';

    public function testSource()
    {
        $obj = new \stdClass();
        $obj->data = [];

        $attribute = ScalarAttribute::make($obj, $obj->data, 'test', []);

        assertNull($attribute->handle([]));

        assertEquals($obj, $attribute->handle(['ok']));

        assertEquals($obj->data['test'], 'ok');

        assertEquals($obj->data['test'], $attribute->handle([]));

        assertEquals($obj, $attribute->handle([null]));

        assertNull($attribute->handle([]));

        assertEquals(null, $attribute->handle([]));
    }
}
