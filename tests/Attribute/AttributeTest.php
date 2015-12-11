<?php

namespace Tacone\Bees\Test;

use Tacone\Bees\Attribute\Attribute;

class AttributeTest extends BaseTestCase
{
    protected $value1 = 'ok';
    protected $value2 = 'what';
    protected $value3 = 'hello';

    protected $empty = null;
    protected $objClass = Attribute::class;

    public function testHandle()
    {
        $obj = new \stdClass();
        $obj->data = [];

        $class = $this->objClass;
        $attribute = $class::make($obj, $obj->data, 'test');

        // getter when empty
        assertEquals($this->empty, $attribute->handle([]));

        // set to value
        assertEquals($obj, $attribute->handle([$this->value1]));
        assertEquals($obj->data['test'], $this->value1);
        assertEquals($obj->data['test'], $attribute->handle([]));

        // set to null
        assertEquals($obj, $attribute->handle([$this->empty]));
        assertEquals($this->empty, $attribute->handle([]));
        assertEquals($this->empty, $attribute->handle([]));

        // unset
        assertEquals($obj, $attribute->handle([$this->value1]));
        assertEquals($obj, $attribute->reset());
        assertEquals($this->empty, $attribute->handle([]));
    }

    public function testDefault()
    {
        $obj = new \stdClass();
        $obj->data = [];

        $class = $this->objClass;
        $attribute = $class::make($obj, $obj->data, 'test', $this->value2);

        // getter when empty
        assertEquals($this->value2, $attribute->handle([]));
        assertEquals($this->value2, $attribute->defaults());

        // set to value
        assertEquals($obj, $attribute->handle([$this->value1]));
        assertEquals($obj->data['test'], $this->value1);
        assertEquals($obj->data['test'], $attribute->handle([]));

        // set to null
        assertEquals($obj, $attribute->handle([$this->empty]));
        assertEquals($this->empty, $attribute->handle([]));
        assertEquals($this->empty, $attribute->handle([]));

        // unset
        assertEquals($obj, $attribute->handle([$this->value1]));
        assertEquals($obj, $attribute->reset());
        assertEquals($this->value2, $attribute->handle([]));

        assertEquals($obj, $attribute->defaults($this->value3));
        assertEquals($this->value3, $attribute->defaults());
    }
}
