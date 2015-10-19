<?php

use Tacone\Bees\Test\Customer;

class Customers
{

    function anyIndex()
    {
        $collection = new EndpointCollection(new Customer());
        $collection->string('name', 'first_name');
        $collection->boolean('published', true);
        $collection->dateTime('updated', 'Last update');

        return $collection;
    }

    function anyEdit()
    {
        $endpoint = new Endpoint(new Customer());
        $endpoint->string('name', 'first_name');
        $endpoint->boolean('published');
        $endpoint->optional->dateTime('updated', 'Last update');

        return $endpoint;
    }

    function anyOneMethod()
    {
        $collection = new Endpoint(new Customer());
        $collection->string('name', 'first_name');
        $collection->boolean('published', true);
        $collection->dateTime('updated', 'Last update');

        $endpoint = new Endpoint(new Customer());
        $endpoint->string('name', 'first_name');
        $endpoint->boolean('published');
        $endpoint->dateTime('updated', 'Last update');

        return $collection->and($endpoint);
    }

    function anyProxy() {

    }

}

class UsersController extends ResourceController {
    function getResource() {
        $endpoint = new Endpoint(new Customer());
        $endpoint->string('name', 'first_name');
        $endpoint->boolean('published');
        $endpoint->dateTime('updated', 'Last update');
        return $endpoint;
    }
    function getResourcesCollection() {
        $collection = new Endpoint(new Customer());
        $collection->string('name', 'first_name');
        $collection->boolean('published', true);
        $collection->dateTime('updated', 'Last update');
        return $collection;
    }
}