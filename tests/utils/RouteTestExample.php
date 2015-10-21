<?php

namespace Orchestra\Testbench\TestCase;

use Tacone\Bees\Test\BaseTestCase;

class RouteTest extends BaseTestCase
{
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['router']->get('hello', function () {
            return 'hello world';
        });

        $app['router']->resource('foo', 'Orchestra\Testbench\TestCase\FooController');
    }

    /**
     * Test GET hello route.
     *
     * @test
     */
    public function testGetHelloRoute()
    {
        $crawler = $this->call('GET', 'hello');

        //$this->assertResponseOk();
        $this->assertEquals('hello world', $crawler->getContent());
    }

    /**
     * Test GET foo/index route using action.
     *
     * @test
     */
    public function testGetFooIndexRouteUsingAction()
    {
        $crawler = $this->action('GET', '\Orchestra\Testbench\TestCase\FooController@index');

        $this->assertResponseOk();
        $this->assertEquals('FooController@index', $crawler->getContent());
    }

    public function testW()
    {
        $this->assertEquals('FooController@index', 'FooController@index');
    }

    /**
     * Test GET foo/index route using call.
     *
     * @test
     */
    public function testGetFooIndexRouteUsingCall()
    {
        $crawler = $this->call('GET', 'foo');

        $this->assertResponseOk();
        $this->assertEquals('FooController@index', $crawler->getContent());
    }
}

class FooController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        return 'FooController@index';
    }
}
