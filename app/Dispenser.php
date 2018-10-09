<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispenser extends Model
{
    protected $appends = ['items'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'dispenser_items')
            ->withPivot('quantity', 'metric_id', 'created_at', 'updated_at');
    }

    public function kits()
    {
        return $this->belongsToMany(Kit::class, 'dispenser_kits')
            ->withPivot('quantity', 'created_at', 'updated_at');
    }

    public function getItemsAttribute()
    {
        $items = [];
        foreach ($this->items()->get() as $item) {
            $itemArray = $item->toArray();
            if ($item->pivot) {
                unset($itemArray['pivot']);
                $itemArray['quantity'] = $item->pivot->quantity;
            }
            $items[] = $itemArray;
        }
        return $items;
    }
}
