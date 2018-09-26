<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name'];
    public function inventory()
    {
        return $this->belongsTo(Inventoy::class);
    }
    
    public function kits()
    {
        return $this->belongsToMany(Kit::class);
    }
}
