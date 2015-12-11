<?php

namespace Tacone\Bees\Attribute;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Traversable;

class ArrayAttribute extends AbstractAttribute implements \Countable, \IteratorAggregate, \ArrayAccess
{
    protected $default = [];

    /**
     * Required by DelegatedArrayTrait, must return the
     * storage array.
     */
    public function getDelegatedStorage()
    {
        return !empty($this->storage[$this->path])
            ? $this->storage[$this->path]
            : [];
    }

    protected function get()
    {
        return $this->getDelegatedStorage();
    }

    protected function set($arguments)
    {
        $array = $arguments[0];
        $this->exchangeArray($array);
    }

    // --- cast

    protected function castToArray($array)
    {
        switch (true) {
            case is_array($array):
                return $array;
            case $array instanceof Arrayable:
            case $array instanceof Model:
                return $array->toArray();

            case $array instanceof EloquentBuilder:
            case $array instanceof QueryBuilder:
                return $array->get()->toArray();

            case $array instanceof \ArrayIterator:
            case $array instanceof \ArrayObject:
                return $array->getArrayCopy();

            case is_null($array):
                return [];
        }

        throw new \RuntimeException(sprintf(
            'ArrayAttribute does not supports type: %s%s',
            gettype($array),
            is_object($array) ? ' - '.get_class($array) : ''
        ));
    }

    // --- Array methods

    public function count()
    {
        return $this->getDelegatedStorage()->count();
    }

    public function offsetExists($name)
    {
        return isset($this->getDelegatedStorage()[$name]);
    }

    public function offsetSet($name, $value)
    {
        $array = $this->getDelegatedStorage();
        $array[$name] = $value;
        $this->exchangeArray($array);
    }

    public function offsetUnset($name)
    {
        return $this->getDelegatedStorage()->offsetUnset($name);
    }

    public function offsetGet($name)
    {
        return $this->getDelegatedStorage()[$name];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator.
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     *
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *                     <b>Traversable</b>
     */
    public function getIterator()
    {
        return $this->getDelegatedStorage();
    }

    public function toArray()
    {
        return $this->getDelegatedStorage();
    }

    public function exchangeArray($array)
    {
        $array = $this->castToArray($array);
        $this->storage[$this->path] = $array;
    }
}
