<?php

namespace Tacone\Bees\Helper;

class QueryStringPolicy
{
    public static function action($value = null)
    {
        if (func_num_args()) {
            return 'bees[action]='.urlencode($value);
        }
        switch (\Request::method()) {
            case 'DELETE':
                return 'destroy';
        }
        $data = \Input::query('bees');

        return array_get($data, 'action');
    }

    public static function id($value = null)
    {
        if (func_num_args()) {
            return 'bees[id]='.urlencode($value);
        }
        $data = \Input::query('bees');

        return array_get($data, 'id');
    }
}
