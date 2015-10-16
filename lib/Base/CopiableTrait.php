<?php

namespace Tacone\Bees\Base;

use DeepCopy\DeepCopy;
use DeepCopy\Matcher\PropertyTypeMatcher;
use Tacone\Bees\Helper\ArrayObjectFilter;

trait CopiableTrait
{
    public function copy()
    {
        $copy = new DeepCopy();
        $copy->addFilter(
            new ArrayObjectFilter(),
            new PropertyTypeMatcher('\ArrayObject'));

        return $copy->copy($this);
    }
}
