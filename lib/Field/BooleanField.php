<?php

namespace Tacone\Bees\Field;

class BooleanField extends Field
{
    public function cast()
    {
        $value = $this->value();
        if ($value === "false") return false;
        return (boolean)$value;
    }
}
