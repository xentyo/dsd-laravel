<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{
    protected $primary = 'name';
    protected $fillable = ['name', 'description'];
}
