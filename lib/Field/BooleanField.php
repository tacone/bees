<?php

namespace Tacone\Bees\Field;

class BooleanField extends Field
{
    public function cast()
    {
        return (boolean)$this->value();
    }
}
