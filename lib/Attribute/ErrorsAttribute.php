<?php

namespace Tacone\Bees\Attribute;

class ErrorsAttribute extends ArrayAttribute
{

    public function __invoke()
    {
        // avoid parent-chaining
        if (!func_num_args()) {
            return clone($this);
        }
        $arguments = func_get_args();

        return call_user_func_array('parent::__invoke', $arguments);
    }
}
