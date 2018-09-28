<?php

namespace App\Http\Controllers\API;

use Stevebauman\Inventory\Models\Inventory;

class InventoryController extends APIController
{
    protected $model = 'Inventory';
    protected $class = Inventory::class;
}
