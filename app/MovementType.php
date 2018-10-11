<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $fillable = ['name', 'description'];
}
