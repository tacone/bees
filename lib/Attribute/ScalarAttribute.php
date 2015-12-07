<?php

namespace Tacone\Bees\Attribute;

class ScalarAttribute extends AbstractAttribute
{
    public function handle($arguments)
    {
        if (!count($arguments)) {
            return !empty($this->storage[$this->path])
                ? $this->storage[$this->path]
                : null;
        }

        $this->storage[$this->path] = $arguments[0];

        return $this->object;
    }
}
