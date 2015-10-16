<?php

namespace Tacone\Bees\Attribute;

use Tacone\Bees\Base\CollectionTrait;

class CollectionAttribute extends ArrayAttribute
{
    use CollectionTrait;

    public function exposes()
    {
        return [
            'accessors' => ['has'],
            'others' => ['add', 'remove'],
        ];
    }
}
