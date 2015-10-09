<?php

namespace Tacone\Bees\Test;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
