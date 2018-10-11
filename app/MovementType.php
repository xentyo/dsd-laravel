<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{
    protected $primaryKey = 'name';
    protected $fillable = ['name', 'description'];
}
