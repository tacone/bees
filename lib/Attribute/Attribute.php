<?php

namespace Tacone\Bees\Attribute;

use Tacone\Bees\Base\Exposeable;
use Tacone\Bees\Base\StringableTrait;
use function Tacone\Bees\is_safe_callable;

class Attribute
{
    use Exposeable;

    public $value = null;
    /** @var callable */
    public $callback = null;

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

    protected function rawGet()
    {
        return $this->value;
    }

    public function get()
    {
        $value = $this->rawGet();
        if (is_safe_callable($this->callback)) {
            $func = $this->callback;

            return $func($value);
        }

        return $value;
    }

    public function set($value)
    {
        if (is_safe_callable($value)) {
            $this->callback = $value;

            return $this;
        }
        $this->value = $value;

        return $this;
    }
}