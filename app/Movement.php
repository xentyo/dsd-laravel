<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    public function type()
    {
        return $this->hasOne(MovementType::class);
    }
}
