<?php

namespace App\Http\Controllers;

use Stevebauman\Inventory\Models\Metric;
use Illuminate\Http\Request;
use Validator;

class MetricController extends APIController
{
    protected $class = Metric::class;
    protected $model = 'Metric';
    protected $storeRules = [
        'name' => 'required|max:255|min:2|alpha|unique:metrics',
        'symbol' => 'required|max:4|min:1|alpha|unique:metrics'
    ];
}
