<?php

namespace App\Http\Controllers\API;

use App\MovementType;
use Illuminate\Http\Request;

class MovementTypeController extends APIController
{
    protected $class = MovementType::class;
    protected $model = "MovementType";
}
