<?php

namespace Tacone\Bees\Attribute;

class Attribute extends AbstractAttribute
{
    protected function get()
    {
        return $this->storage[$this->path];
    }

    protected function set($arguments)
    {
        $this->storage[$this->path] = $arguments[0];
    }
}
