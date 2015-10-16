<?php

namespace Tacone\Bees\Field;

class String extends Field
{
    public function renderEdit()
    {
        return  (string) $this->value;
    }
}
