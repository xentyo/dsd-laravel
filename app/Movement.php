<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Inventory\Models\Metric;

class Movement extends Model
{
    protected $fillable = ['dispenser_id', 'item_id', 'metric_id', 'type_id', 'quantity'];
    protected $appends = ['type', 'metric', 'item', 'dispenser'];
    protected $hidden = ['dispenser_id', 'item_id', 'metric_id', 'type_id'];
    public function type()
    {
        return $this->hasOne(MovementType::class, 'name', 'type_id');
    }

    public function metric()
    {
        return $this->hasOne(Metric::class, 'id', 'metric_id');
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function dispenser()
    {
        return $this->hasOne(Dispenser::class, 'id', 'dispenser_id');
    }

    public function getTypeAttribute()
    {
        $type = $this->type()->first();
        return [
            'name' => $type->name,
            'description' => $type->description,
        ];
    }

    public function getMetricAttribute()
    {
        $metric = $this->metric()->first();
        return [
            'id' => $metric->id,
            'name' => $metric->name,
            'symbol' => $metric->symbol,
        ];
    }

    public function getItemAttribute()
    {
        $item = $this->item()->first();
        return [
            'id' => $item->id,
            'name' => $item->name
        ];
    }

    public function getDispenserAttribute()
    {
        $dispenser = $this->dispenser()->first();
        return [
            'id' => $dispenser->id,
            'name' => $dispenser->name
        ];
    }
}
