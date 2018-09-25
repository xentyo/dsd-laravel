<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispenser extends Model
{
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function kits()
    {
        return $this->belongsToMany(Kit::class);
    }
}
