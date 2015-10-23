<?php

use Tacone\Bees\Test\Customer;

class Customers
{
    public function anyIndex()
    {
        $collection = new EndpointCollection(new Customer());
        $collection->string('name', 'first_name');
        $collection->boolean('published', true);
        $collection->dateTime('updated', 'Last update');

        return $collection;
    }

    public function anyEdit()
    {
        $endpoint = new Endpoint(new Customer());
        $endpoint->string('name', 'first_name');
        $endpoint->boolean('published');
        $endpoint->optional->dateTime('updated', 'Last update');

        return $endpoint;
    }

    public function anyOneMethod()
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

    public function anyProxy()
    {
    }
}

class UsersController extends ResourceController
{
    public function getResource()
    {
        $endpoint = new Endpoint(new Customer());
        $endpoint->string('name', 'first_name');
        $endpoint->boolean('published');
        $endpoint->dateTime('updated', 'Last update');

        return $endpoint;
    }

    public function getResourcesCollection()
    {
        $collection = new Endpoint(new Customer());
        $collection->string('name', 'first_name');
        $collection->boolean('published', true);
        $collection->dateTime('updated', 'Last update');

        return $collection;
    }
}

// add field
$e->string('name', 'user_name', $sortable)
    ->rules('required|min:4', function ($field) {
        return 'custom error string for field '.$field->name();
    })
    ->options(['enum', 'of', 'choices']);

// terminators
$e->errors();
$e->output($array);

// field types
$e->string('name');
$e->integer('age');
$e->float('age');
$e->object('location');

// field API
$newValue = 1;
$field = f();

$field->value();
$field->value($newValue);
$field->onValue(function () {
});
$field->onGetValue(function () {
});
