<?php

namespace Tacone\Bees\Field;

class IntegerField extends Field
{

    public function cast()
    {
        return (integer)$this->value();
    }
}
