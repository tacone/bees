<?php

namespace Tacone\Bees\Field;

class Textarea extends Field
{
    public function renderEdit()
    {
        return  (string) $this->value;

    }
}
