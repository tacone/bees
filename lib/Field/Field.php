<?php

namespace Tacone\Bees\Field;

use Tacone\Bees\Attribute\Attribute;
use Tacone\Bees\Attribute\ErrorsAttribute;
use Tacone\Bees\Attribute\JoinedArrayAttribute;
use Tacone\Bees\Attribute\ScalarAttribute;
use Tacone\Bees\Base\Exposeable;

abstract class Field
{
    /**
     * @var Attribute
     */
    public $name;

    /**
     * @var
     */
    public $value;
    public $rules;
    public $errors;

    protected $data = [];

    public function __construct($name, $label = null)
    {
        $this->errors = new ErrorsAttribute();
        $this->name($name);

        $this->rules = new JoinedArrayAttribute(null, '|');
    }

    public function name($value = null)
    {
        return ScalarAttribute::make($this, $this->data, 'name')
            ->handle(func_get_args());
    }

    public function value($value = null)
    {
        return ScalarAttribute::make($this, $this->data, 'value')
            ->handle(func_get_args());
    }

    /**
     * Implements a jQuery-like interface.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return $this
     */
    public function __call($method, $parameters)
    {
        return Exposeable::handleExposeables($this, $method, $parameters);
    }
}
