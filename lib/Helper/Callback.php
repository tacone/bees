<?php

namespace Tacone\Bees\Helper;


class Callback
{
    /**
     * Check if a callback is a safe callback.
     * Strings callback are insecure as they may come from user input.
     *
     * Forbidden callables are:
     * - string only (i.e. 'strtoupper' or 'unlink')
     * - arrays with string obj params (i.e. ['App', 'abort'])
     *
     * @param $callable
     *
     * @return bool
     */
    static public function isSafe($callable)
    {
        return (
            is_callable($callable)
            && !is_string($callable)
            && (!is_array($callable) || count($callable) && is_object($callable[0]))
        );
    }

    static public function unsafeErrorMessage($value)
    {
        switch (gettype($value)) {
            case 'string':
                return "Strings are not safe callables (got: '$value')";
            case 'array':
                return 'String-only arrays are not safe callables (got: ' . json_encode($value) . ')';
        }
        throw new LogicException('String or array expected, got: ' . gettype($value));
    }

}