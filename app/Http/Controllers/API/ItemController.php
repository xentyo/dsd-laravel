<?php

namespace App\Http\Controllers\API;

use App\Item;

class ItemController extends APIController
{
    protected $class = Item::class;
    protected $model = 'Item';
    protected $ids = ['inventory', 'metric'];
    protected $storeRules = [
        'name' => 'required|min:2|max:255|alpha_num',
        'inventory' => 'required|integer',
        'metric' => 'required|integer',
        'description' => 'present|max:255|string|nullable',
    ];
}
