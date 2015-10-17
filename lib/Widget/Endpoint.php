<?php

namespace Tacone\Bees\Widget;

use App;
use ArrayAccess;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use IteratorAggregate;
use Tacone\Bees\Base\CopiableTrait;
use Tacone\Bees\Base\DelegatedArrayTrait;
use Tacone\Bees\Collection\FieldCollection;
use Tacone\Bees\Field\Field;
use Tacone\Bees\Helper\Error;
use Tacone\DataSource\DataSource;

class Endpoint implements Countable, IteratorAggregate, ArrayAccess, Arrayable
{
    use DelegatedArrayTrait;
    use CopiableTrait;

    /**
     * @var FieldCollection
     */
    public $fields;

    /**
     * @var DataSource
     */
    public $source;

    public function __construct($source = null)
    {
        $this->fields = new FieldCollection();
        $this->initSource($source);
    }

    protected function initSource($source = null)
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
            $this->source[$name] = $field->value();
        }
    }

    /**
     * Fills the form with the values coming from the DB
     * and HTTP input.
     */
    public function populate()
    {
        $inputData = array_dot(\Input::all());

        return call_user_func_array([$this->fields, 'populate'], [
            $this->source,
            $inputData,
        ]);
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
}
