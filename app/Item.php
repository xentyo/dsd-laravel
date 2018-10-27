<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Inventory\Models\InventoryStock as Stock;

class Item extends Model
{
    protected $fillable = ['name'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if($this->pivot) $this->appends[] = 'quantity';
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function kits()
    {
        return $this->belongsToMany(Kit::class);
    }

    public function dispensers()
    {
        return $this->belongsToMany(Dispenser::class);
    }

    public function getQuantityAttribute()
    {
        return $this->pivot->quantity;
    }
}
