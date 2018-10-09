<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['dispenser_id', 'item_id', 'metric_id', 'type_id', 'quantity'];
    public function type()
    {
        return $this->hasOne(MovementType::class);
    }
}
