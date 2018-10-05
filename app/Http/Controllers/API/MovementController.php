<?php

namespace App\Http\Controllers\API;

use App\Movement;
use Illuminate\Http\Request;

class MovementController extends APIController
{
    protected $class = Movement::class;
    protected $model = "Movement";
}
