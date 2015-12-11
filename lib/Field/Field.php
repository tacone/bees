<?php

namespace Tacone\Bees\Field;

use Tacone\Bees\Attribute\ArrayAttribute;
use Tacone\Bees\Attribute\JoinedArrayAttribute;
use Tacone\Bees\Attribute\Attribute;

abstract class Field
{
    protected $data = [];

    public function __construct($name, $label = null)
    {
        $this->name($name);
    }

    public function name($value = null)
    {
        return Attribute::make($this, $this->data, 'name')
            ->handle(func_get_args());
    }

    public function value($value = null)
    {
        return Attribute::make($this, $this->data, 'value')
            ->handle(func_get_args());
    }

    public function errors($value = null)
    {
        return ArrayAttribute::make($this, $this->data, 'errors')
            ->handle(func_get_args());
    }

    public function rules($value = null)
    {
        return JoinedArrayAttribute::make($this, $this->data, 'rules')
            ->handle(func_get_args());
    }
}
