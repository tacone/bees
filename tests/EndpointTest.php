<?php

namespace Tacone\Bees\Test;

use Tacone\Bees\Field\Field;
use Tacone\Bees\Widget\Endpoint;
use Tacone\DataSource\ArrayDataSource;

class EndpointTest extends BaseTestCase
{
    protected $baseUrl = '/';

    function testSource() {
        $e = new Endpoint();
        assertSame([], $e->toArray());
        $result = $e->source(['a' => 1]);
        assertSame($e, $result);
        assertSame(['a' => 1], $e->source());
    }

    function testConstructSource()
    {
        $source = [];
        $e = new Endpoint($source);
        assertInstanceOf(ArrayDataSource::class, $e->source());
        assertSame($source, $e->toArray());

        // an empty array should be the default source
        // if no source is passed in
        $e = new Endpoint();
        assertSame([], $e->toArray());
        assertInstanceOf(ArrayDataSource::class, $e->source());
    }



    function testAddNonExistingField()
    {
        $this->setExpectedException(\BadMethodCallException::class);

        $source = ['name' => 'Frank', 'surname' => 'Sinatra'];
        $e = new Endpoint($source);
        // irrational integer field does not exists
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

    function testValidate()
    {
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
        $e->fromSource();
        $e->fromInput();
        $e->validate();
        $e->writeSource();
        assertSame($source, $e->toArray());
    }

}