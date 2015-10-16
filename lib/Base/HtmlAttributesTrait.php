<?php

namespace Tacone\Bees\Base;

use Tacone\Bees\Attribute\CssAttribute;
use Tacone\Bees\Attribute\DictionaryAttribute;
use Tacone\Bees\Attribute\JoinedArrayAttribute;

trait HtmlAttributesTrait
{
    /**
     * @var DictionaryAttribute
     */
    public $attr;
    /**
     * @var JoinedArrayAttribute
     */
    public $class;
    /**
     * @var CssAttribute
     */
    public $css;

    protected function initHtmlAttributes()
    {
        $this->attr = new DictionaryAttribute();
        $this->class = new JoinedArrayAttribute([], ' ');
        $this->css = new CssAttribute();
    }
    protected function buildHtmlAttributes()
    {
        $attributes = array_merge(
            $this->attr->toArray(),
            ['class' => $this->class->output()],
            ['style' => $this->css->output()]
        );

        return array_filter($attributes);
    }
}
