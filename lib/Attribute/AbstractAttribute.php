<?php

namespace Tacone\Bees\Attribute;

class AbstractAttribute
{
    protected $object;
    protected $storage;
    protected $path;

    protected function __construct($object, &$storage, $path)
    {
        $this->object = $object;
        $this->storage = &$storage;
        $this->path = $path;
    }

    public static function make($object, &$storage, $path)
    {
        return new static ($object, $storage, $path);
    }
}
