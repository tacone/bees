<?php

namespace Tacone\Bees\Attribute;

abstract class AbstractAttribute
{
    protected $object;
    protected $storage;
    protected $path;
    protected $default;

    protected function __construct($object, &$storage, $path)
    {
        $this->object = $object;
        $this->storage = &$storage;
        $this->path = $path;
    }

    abstract protected function get();

    abstract protected function set($arguments);

    public function handle($arguments)
    {
        if (!count($arguments)) {
            return array_key_exists($this->path, $this->storage)
                ? $this->get()
                : $this->default;
        }

        $this->set($arguments);

        return $this->object;
    }

    /**
     * @param \Tacone\Bees\Field\Field $object
     * @param $storage
     * @param string $path
     *
     * @return static
     */
    public static function make($object, &$storage, $path, $default = null)
    {
        $instance = new static ($object, $storage, $path);
        if (func_num_args() > 3) {
            $instance->defaults($default);
        }

        return $instance;
    }

    public function defaults($value = null)
    {
        $arguments = func_get_args();
        if (!count($arguments)) {
            return $this->default;
        }

        $this->default = $arguments[0];

        return $this->object;
    }

    public function reset()
    {
        unset($this->storage[$this->path]);

        return $this->object;
    }
}
