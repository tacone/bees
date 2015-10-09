<?php

namespace Tacone\Bees\Test;

use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
