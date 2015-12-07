<?php

namespace Tacone\Bees\Test;

use Tacone\Bees\Attribute\ArrAttribute;

class ArrAttributeTest extends BaseTestCase
{
    protected $baseUrl = '/';

    public function testHandle()
    {
        $obj = new \stdClass();
        $obj->data = [];
        $attribute = ArrAttribute::make($obj, $obj->data, 'test', []);

        assertEquals($attribute->handle([]), []);

        assertEquals($obj, $attribute->handle([['ok']]));

        assertEquals($obj->data['test'], ['ok']);

        assertEquals($obj->data['test'], $attribute->handle([]));

        assertEquals($obj, $attribute->handle([null]));

        assertEquals($attribute->handle([]), []);

        assertEquals([], $attribute->handle([]));
    }

    public function testGetSet()
    {
        $obj = new \stdClass();
        $obj->data = [];
        $attribute = ArrAttribute::make($obj, $obj->data, 'test', []);

        $attribute['hello'] = 'world';
        $this->assertEquals('world', $attribute['hello']);
        $this->assertEquals('world', $obj->data['test']['hello']);

        $attribute['hello'] = null;
        $this->assertEquals(null, $attribute['hello']);
        $this->assertEquals(null, $obj->data['test']['hello']);
    }

    public function testIssetUnset()
    {
        $obj = new \stdClass();
        $obj->data = [];
        $attribute = ArrAttribute::make($obj, $obj->data, 'test', []);

        assertFalse(isset($attribute['hello']));
        assertFalse(isset($obj->data['test']['hello']));

        $attribute['hello'] = 'world';
        $this->assertEquals('world', $attribute['hello']);
        $this->assertEquals('world', $obj->data['test']['hello']);

        assertTrue(isset($attribute['hello']));
        assertTrue(isset($obj->data['test']['hello']));

        $attribute['hello'] = null;
        $this->assertEquals(null, $attribute['hello']);
        $this->assertEquals(null, $obj->data['test']['hello']);

        // this is how PHP behaves
        assertFalse(isset($attribute['hello']));
        assertFalse(isset($obj->data['test']['hello']));
    }

    public function testToArray()
    {
        $obj = new \stdClass();
        $obj->data = [];
        $attribute = ArrAttribute::make($obj, $obj->data, 'test', []);

        $attribute['hello'] = 'world';

        $this->assertEquals(['hello' => 'world'], $attribute->toArray());
    }
}
