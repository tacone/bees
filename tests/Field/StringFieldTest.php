<?php

namespace Tacone\Bees\Test;

use Tacone\Bees\Field\StringField;

class StringFieldTest extends BaseTestCase
{
    protected $baseUrl = '/';

    public function testName()
    {
        $field = new StringField('hello');
        assertEquals($field->name(), 'hello');

        assertEquals($field->name('what'), $field);
        assertEquals($field->name(), 'what');
    }
}
