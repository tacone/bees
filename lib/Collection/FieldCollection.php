<?php

namespace Tacone\Bees\Collection;

use Illuminate\Contracts\Support\Arrayable;
use Tacone\Bees\Base\CompositeTrait;
use Tacone\Bees\Base\DelegatedArrayTrait;
use Tacone\Bees\Helper\ArrayHelper;

class FieldCollection implements \Countable, \IteratorAggregate, \ArrayAccess, Arrayable
{
    use DelegatedArrayTrait;
    use CompositeTrait;

    public function __construct()
    {
        $this->storage = new \ArrayObject();
    }

    protected function compositeTraitGetChildren()
    {
        $children = [];
        foreach ($this as $name => $field) {
            $children[$name] = $field;
        }

        return $children;
    }

    public function add($object)
    {
        return $this->storage[$object->name()] = $object;
    }

    public function get($name)
    {
        return $this->storage[$name];
    }

    public function contains($name)
    {
        if (is_object($name)) {
            $name = $name->name();
        }

        return $this->storage->offsetExists($name);
    }

    protected function getDelegatedStorage()
    {
        return $this->storage;
    }

    /**
     * Get the fields value as an associative array.
     * By default a nested array is returned.
     * Passing true as the first parameter, a flat
     * array will be returned, with dotted offsets
     * as the keys.
     *
     * @param bool $flat
     *
     * @return array
     */
    public function toArray($flat = false)
    {
        $array = $this->value();
        if ($flat) {
            return $array;
        }

        return ArrayHelper::undot($array);
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $validator = \Validator::make(
            $this->toArray(true),
            $this->rules()
        );
        $names = array();
        foreach ($this as $field) {
            $names[$field->name()] = '"'.$field->name().'"';
        }
        $validator->setAttributeNames($names);
        foreach ($validator->errors()->getMessages() as $name => $messages) {
            $this[$name]->errors($messages);
        }

        return !$validator->fails();
    }

    public function from($source)
    {
        foreach ($this as $name => $field) {
            if (isset($source[$name])) {
                $field->value($source[$name]);
            }
        }
    }
}
