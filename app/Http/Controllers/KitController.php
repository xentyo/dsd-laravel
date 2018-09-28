<?php

namespace App\Http\Controllers;

use App\Kit;

class KitController extends APIController
{
    protected $class = Kit::class;
    protected $model = 'Kit';
    protected $storeRules = [
        'name' => 'required|min:2|max:100',
        'description' => 'present|max:255|nullable'
    ];
    protected $updateRules = [
        'name' => 'nullable|min:2|max:100',
        'description' => 'nullable|max:255'
    ];
}
