<?php

namespace Tacone\Bees\Attribute;

class JoinedArrayAttribute extends ArrayAttribute
{
    protected $separator = '|';

    protected function castToArray($array)
    {
        $array = is_string($array) ? explode('|', $array) : $array;

        return parent::castToArray($array);
    }

    /**
     * Flatten a multi dimensional array and split all the strings
     * using the separator.
     *
     * @param $value
     *
     * @return array
     */
    protected function flattenValue($value)
    {
        $value = (array) $value;
        $return = array();
        $separator = $this->separator;
        array_walk_recursive($value, function ($item) use (&$return, $separator) {
            if (is_string($item)) {
                $item = explode($separator, $item);
            }
            if (!is_array($item) && $item instanceof \Traversable) {
                $item = iterator_to_array($item);
            }
            if (is_array($item)) {
                $return = array_merge($return, $item);
            } else {
                $return[] = $item;
            }
        });
        $return = array_filter($return);

        return $return;
    }
}
