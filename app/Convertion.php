<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Inventory\Models\Metric;

class Convertion extends Model
{
    public function from()
    {
        return $this->hasOne(Metric::class);
    }

    public function to()
    {
        return $this->hasOne(Metric::class);
    }

    public function convert($number)
    {
        return $number * $this->factor;
    }

    public function convertReverse()
    {
        return $number / $this->factor;
    }
}
