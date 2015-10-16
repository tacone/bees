<?php

namespace Tacone\Bees\Test;
require_once __DIR__ . '/utils/laravel.php';

use Tacone\Bees\Field\Field;
use Tacone\Bees\Widget\Endpoint;

class EndpointTest extends BaseTestCase
{
    protected $baseUrl = '/';

    function testConstruct()
    {
        $this->app = null;
        $source = [];
        $e = new Endpoint($source);
    }
//
    function testAddNonExistingField()
    {
        $this->app = null;

        $this->setExpectedException(\BadMethodCallException::class);

        $source = ['name' => 'Frank', 'surname' => 'Sinatra'];
        $e = new Endpoint($source);
        $e->irrationalInteger('name');
    }
//
//    function testAddExistingField()
//    {
//        $source = [];
//        $e = new Endpoint($source);
//        $field = $e->string('name');
//        assertInstanceOf(Field::class, $field);
//        assertSame($field, $e['name']);
//    }
//
    function testInput()
    {

        $expected = ['name' => 'Frank', 'surname' => 'Sinatra'];
//        $this->mockInput(null, $expected);

//        $this->refreshApplication();
        $r = $this->call('GET', '/');
        dd($r);
    }

//    function testPopulate()
//    {
//        $source = [];
//        $e = new Endpoint($source);
//
//        $expected = ['name' => 'Frank', 'surname' => 'Sinatra'];
////        $this->mockInput(null, $expected);
////dd(\Request::all());
//        $e = new Endpoint([]);
//        $e->string('name');
//        $e->string('surname');
//        $e->populate();
//
////        assertSame($expected, $e->toArray());
//    }
//
//
//
//    function testBasicFlow()
//    {
//        $source = [];
//        $e = new Endpoint($source);
//
//        assertSame($source, $e->toArray());
//
//        $source = ['name' => 'Frank', 'surname' => 'Sinatra'];
//        $e = new Endpoint($source);
//        $e->string('name');
//        $e->string('surname');
//        $e->populate();
//        $e->writeSource();
//        assertSame($source, $e->toArray());
//    }

}