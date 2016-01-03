<?php

namespace Tacone\Bees\Widget;

use App;
use ArrayAccess;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use Tacone\Bees\Base\DelegatedArrayTrait;
use Tacone\Bees\Collection\FieldCollection;
use Tacone\Bees\Field\Field;
use Tacone\Bees\Helper\Error;
use Tacone\DataSource\AbstractDataSource;
use Tacone\DataSource\DataSource;

class Endpoint implements Countable, IteratorAggregate, ArrayAccess, Arrayable, Jsonable
{
    use DelegatedArrayTrait;

    /**
     * @var FieldCollection
     */
    protected $fields;

    /**
     * @var AbstractDataSource
     */
    protected $source;

    protected $auto = false;

    public function __construct($source = [])
    {
        $this->fields = new FieldCollection();
        $this->initSource($source);
    }

    public static function auto($source)
    {
        $endpoint = new static($source);
        $endpoint->auto = true;

        return $endpoint;
    }

    protected function initSource($source)
    {
        $this->source = DataSource::make($source);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return Field|static|mixed
     */
    public function __call($name, $arguments)
    {
        // Is it a field name?
        try {
            $binding = "bees.$name";
            $field = App::make($binding, $arguments);
            $this->fields->add($field);

            return $field;
        } catch (\ReflectionException $e) {
            // not a field name
        }

        // oh, well, then ...
        throw Error::missingMethod($this, $name);
    }

    public function source($newSource = null)
    {
        if (func_num_args()) {
            $this->source = $newSource;

            return $this;
        }

        return $this->source;
    }

    /**
     * Collection containing all the fields in the form.
     *
     * @return FieldCollection
     */
    public function fields()
    {
        return $this->fields;
    }

    /**
     * Get a field by name (dotted offset).
     *
     * (you can also use array notation like:
     * <code>$form['author.name']</code>
     *
     * @param string $name
     *
     * @return Field
     */
    public function field($name)
    {
        return $this->fields->get($name);
    }

    /**
     * Get the fields value as an associative array.
     * By default a nested array is returned.
     * Passing true as the first parameter, a flat
     * array will be returned, with dotted offsets
     * as the keys.
     *
     * @param bool $flat
     *
     * @return array
     */
    public function toArray($flat = false)
    {
        return $this->fields()->toArray($flat);
    }

    /**
     * Required by DelegatedArrayTrait.
     *
     * @return FieldCollection
     */
    protected function getDelegatedStorage()
    {
        return $this->fields;
    }

    /**
     * Sets the fields values back to the models.
     */
    public function writeSource()
    {
        foreach ($this->fields as $name => $field) {
            $this->source[$name] = $field->cast();
        }
    }

    /**
     * Fills the form with the values coming from the DB
     * and HTTP input.
     */
    public function populate()
    {
        $this->fromSource();
        $this->fromInput();
    }

    public function fromSource()
    {
        return $this->from($this->source);
    }

    public function fromInput()
    {
        $request = method_exists('\Request', 'all')
            ? \Request::instance()
            : \Input::instance();

        return $this->from(\Input::all());
    }

    public function from($source)
    {
        if (!$source instanceof AbstractDataSource) {
            $source = DataSource::make($source);
        }

        return $this->fields->from($source);
    }

    /**
     * Saves the models back to the database.
     */
    public function save()
    {
        return $this->source->save();
    }

    /**
     * Validates the form, then sets eventual errors on each field.
     *
     * @return mixed
     */
    public function validate()
    {
        $arguments = func_get_args();

        return call_user_func_array([$this->fields, 'validate'], $arguments);
    }

    /**
     * @return mixed
     */
    public function errors()
    {
        $arguments = func_get_args();

        return call_user_func_array([$this->fields, 'errors'], $arguments);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        if ($this->auto) {
            $this->process();
        }

        return json_encode(
            $this->toArray(),
            JSON_UNESCAPED_SLASHES
        );
    }

    protected function getKey()
    {
        $parameters = \Route::current()->parameters();

        return reset($parameters);
    }

    protected function process()
    {
        $key = $this->getKey();
        $this->load($key);
        $this->fromSource();

        if (\Request::method() == 'GET') {
            if (!$key) {
                App::abort(404);
            }
        } elseif (\Request::method() == 'POST') {
            $this->fromInput();
            if ($this->validate()) {
                $this->writeSource();
                $this->save();
            } else {
                // TODO: move this to the middleware
                // HTTP_UNPROCESSABLE_ENTITY
                App::abort(422, $this->errors());
            }
        }
    }

    protected function load()
    {
        $key = $this->getKey();
        if ($key) {
            $instance = $this->source->unwrap()->find($key) or App::abort(404);
            $this->initSource($instance);
        }
    }
}
