<?php

namespace Tacone\Bees\Widget;

class Row extends Endpoint
{
    protected function initWrapper()
    {
        $this->wrap('tr');
    }

//    /**
//     * Renders the form as an HTML string.
//     * This method is also called by __toString().
//     * @return string
//     */
//    protected function render()
//    {
//        return $this->start
//        .$this->fields
//        .$this->end;
//    }
}
