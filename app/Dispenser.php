<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispenser extends Model
{
    protected $appends = ['items'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'dispenser_items');
    }

    public function kits()
    {
        return $this->belongsToMany(Kit::class, 'dispenser_kits');
    }

    public function getItemsAttribute()
    {
        $items = [];
        foreach ($this->items()->get() as $key => $item) {
            $items[] = $item;
        }
        return $items;
    }
}
