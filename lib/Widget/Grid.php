<?php

namespace Tacone\Bees\Widget;

use Tacone\Bees\Helper\QueryStringPolicy;
use Tacone\Bees\Output\CallbackOutputtable;
use Tacone\Bees\Output\CompositeOutputtable;
use Tacone\Bees\Output\Outputtable;
use Tacone\Bees\Output\Tag;
use Tacone\DataSource\DataSource;

class Grid extends Endpoint
{
    /**
     * @var Row
     */
    public $prototype;

    /**
     * @var Rows
     */
    public $rows;
    /**
     * @var CallbackOutputtable
     */
    public $headers;

    public $url;

    public function __construct($source = null)
    {
        $arguments = func_get_args();
        call_user_func_array('parent::__construct', $arguments);
        $this->headers = new CallbackOutputtable([$this, 'renderHeaders']);
        $this->paginator = new Outputtable([$this, 'renderPaginator']);
        $this->url = new QueryStringPolicy();
    }

    public function toArray($flat = false)
    {
        return $this->rows->toArray();
    }
    protected function initWrapper()
    {
        list($this->start, $this->end) = Tag::createWrapper('table');
        $this->start->class('table table-bordered table-striped');
    }

    protected function initSource($source = null)
    {
        $this->source = DataSource::make($source);
        $this->prototype = new Row();
        $this->rows = new Rows($this->source, $this->prototype, $this->fields);
    }

    protected function bindShortcuts()
    {
        parent::bindShortcuts();
        $this->paginate = $this->rows->paginate;
    }

    public function rows()
    {
        return $this->rows;
    }

    /**
     * Renders the widget as an HTML string.
     * This method is also called by __toString().
     *
     * @return string
     */
    protected function render()
    {
        return $this->start
        .$this->headers
        .$this->rows
        .$this->end
        .$this->paginator;
    }

    public function renderPaginator()
    {
        $paginator = $this->rows->paginator;

        return $paginator ? (string) $paginator->links() : '';
    }

    public function renderHeaders()
    {
        $cells = new CompositeOutputtable();
        foreach ($this->fields as $field) {
            $cells[] = new Tag('th', $field->label());
        }
        $wrapper = new Tag('tr', $cells->output());
        $wrapper = new Tag('thead', $wrapper->output());

        return (string) $wrapper;
    }
}
