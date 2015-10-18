<?php

namespace Tacone\Bees\Test;

use Tacone\Bees\Field\Field;
use Tacone\Bees\Widget\Endpoint;

class EndpointTest extends BaseTestCase
{
    protected $baseUrl = '/';

    function testConstruct()
    {
        $source = [];
        $e = new Endpoint($source);
        assertInstanceOf(Endpoint::class, $e);
    }

    function testAddNonExistingField()
    {
        $this->setExpectedException(\BadMethodCallException::class);

        $source = ['name' => 'Frank', 'surname' => 'Sinatra'];
        $e = new Endpoint($source);
        $e->irrationalInteger('name');
    }

    function testAddExistingField()
    {
        $source = [];
        $e = new Endpoint($source);
        $field = $e->string('name');
        assertInstanceOf(Field::class, $field);
        assertSame($field, $e['name']);
    }

    function testPopulate()
    {
        $expected = ['name' => 'Frank', 'surname' => 'Sinatra'];

        $response = $this->request(function () use ($expected) {

            $source = [];
            $e = new Endpoint($source);
            $e->string('name');
            $e->string('surname');
            $e->populate();
            assertSame($expected, $e->toArray());
            return $e->toArray();
        }, 'POST', null, $expected);
    }

    function testValidate() {
        $source = [];
        $e = new Endpoint($source);
        $e->string('name')->rules('required');
        $e->string('surname')->rules('required');
        $e->populate();
        $this->assertFalse($e->validate());
        $errors = $e->errors();
        $this->assertSame(2, count($errors));
        assertTrue(!empty($errors['name']));
        assertTrue(!empty($errors['surname']));
    }

    function testBasicFlow()
    {
        $source = [];
        $e = new Endpoint($source);

        assertSame($source, $e->toArray());

        $source = ['name' => 'Frank', 'surname' => 'Sinatra'];
        $e = new Endpoint($source);
        $e->string('name');
        $e->string('surname');
        $e->populate();
        $e->validate();
        $e->writeSource();
        assertSame($source, $e->toArray());
    }

}