<?php

namespace App\Http\Controllers\API;

use App\Convertion;
use Illuminate\Http\Request;

class ConvertionController extends APIController
{
    protected $class = Convertion::class;
    protected $model = "Convertion";
}
