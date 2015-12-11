<?php

namespace Tacone\Bees\Attribute;

class CollectionAttribute extends ArrayAttribute
{
    //    public function add($value)
//    {
//        return $this[] = $value;
//    }
//
//    public function has($value)
//    {
//        return in_array($value, $this->getDelegatedStorage());
//    }
//    public function set($value)
//    {
//        if (is_string($value)) {
//            $value = explode($this->separator, $value);
//        }
//        if (!$value) {
//            $value = [];
//        }
//        parent::set($value);
//    }
//    public function removeAll()
//    {
//        $this->set([]);
//        return $this;
//    }
//    public function remove($value)
//    {
//        $array = $this->toArray();
//        foreach ($array as $k => $v) {
//            if ($v == $value) {
//                unset($array[$k]);
//            }
//        }
//        $this->set($array);
//
//        return $this;
//    }
}
