<?php

namespace App\Http\Controllers\API;

use App\Dispenser;

class DispenserController extends APIController
{
    protected $class = Dispenser::class;
    protected $model = 'Dispenser';
    protected $storeRules = [
        'name' => 'required|min:2|max:255|unique:dispensers',
        'description' => 'present|min:10|max:255|nullable'
    ];
}
