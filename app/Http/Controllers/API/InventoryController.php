<?php

namespace App\Http\Controllers\API;

use Stevebauman\Inventory\Models\Inventory;

class InventoryController extends APIController
{
    protected $model = 'Inventory';
    protected $class = Inventory::class;
    protected $storeRules = [
        'name' => 'required|min:2|max:255|regex:/^[a-z\d\-_\s]+$/i',
        'description' => 'present|nullable|min:2|max:255|regex:/^[a-z\d\-_\s.,]+$/i',
        'metric' => 'required|integer|exists:metrics,id',
        'category' => 'nullable|integer|exists:categories,id'
    ];
    protected $updateRules = [
        'name' => 'nullable|min:2|max:255|regex:/^[a-z\d\-_\s]+$/i',
        'description' => 'nullable|nullable|min:2|max:255|regex:/^[a-z\d\-_\s.,]+$/i',
        'metric' => 'nullable|integer|exists:metrics,id',
        'category' => 'nullable|integer|exists:categories,id'
    ];
    protected $ids = ['metric', 'category'];
}
