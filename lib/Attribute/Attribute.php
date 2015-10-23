<?php

namespace Tacone\Bees\Attribute;

use Tacone\Bees\Base\Exposeable;

class Attribute
{
    use Exposeable;

    public $value = null;

    public function __construct($value = null)
    {
        if ($value !== null) {
            $this->set($value);
        }
    }

    public function __invoke()
    {
        $arguments = func_get_args();
        if (!count($arguments)) {
            return $this->get();
        }

        return call_user_func_array([$this, 'set'], $arguments);
    }

    public function get()
    {
        return $this->value;
    }

    public function set($value)
    {
        $this->value = $value;

        return $this;
    }
}
