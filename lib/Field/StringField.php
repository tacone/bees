<?php

namespace Tacone\Bees\Field;

class StringField extends Field
{
    public function renderEdit()
    {
        return  (string) $this->value;
    }
}
