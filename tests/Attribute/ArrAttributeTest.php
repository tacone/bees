<?php

namespace Tacone\Bees\Test;

use Tacone\Bees\Attribute\ArrAttribute;

require_once 'AttributeTest.php';

class ArrAttributeTest extends AttributeTest
{
    protected $baseUrl = '/';

    protected $value1 = ['ok'];
    protected $value2 = ['what','a','nice', 'day'];
    protected $value3 = ['hello'];

    protected $empty = [];
    protected $objClass = ArrAttribute::class;

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
