<?php

namespace App\Http\Controllers\API;

use App\Dispenser;
use App\Item;
use Illuminate\Http\Request;
use Stevebauman\Inventory\Models\Metric;
use Validator;

class DispenserController extends APIController
{
    protected $class = Dispenser::class;
    protected $model = 'Dispenser';
    protected $storeRules = [
        'name' => 'required|min:2|max:255|unique:dispensers',
        'description' => 'present|min:10|max:255|nullable',
    ];
    protected $with = ['items', 'kits'];

    public function addItems(Request $request, $id)
    {
        $validator = Validator::make($request->only('item', 'metric', 'quantity'), [
            'item' => 'integer|required',
            'metric' => 'string|required|exists:metrics,symbol',
            'quantity' => 'integer|required|gte:1',
        ]);
        if ($validator->fails()) {
            return response(['message' => 'Validation fails', 'errors' => $validator->messages()], 400);
        }
        $dispenser = Dispenser::find($id);
        $metric = Metric::where('symbol', $request->get('metric'))->first();
        $item = Item::find($request->get('item'));
        if (!$dispenser) {
            return response(['message' => "Dispenser not found"], 404);
        }
        if (!$item) {
            return response(['message' => "Item with \"id\" "+$request->get('item')+" not found"], 404);
        }
        if (!$metric) {
            return response(['message' => 'Metric not found'], 404);
        }
        if ($this->existsItemWithMetricInDispenser($item, $metric, $dispenser)) {
            return response(['message' => 'This item already exists in the dispenser'], 400);
        }

        $dispenser->items()->save($item, ['metric_id' => $metric->id, 'quantity' => $request->get('quantity')]);
        $message = "Item added to dispenser: " . $dispenser->name;
        $dispenser = Dispenser::find($dispenser->id)->first();

        return response(['message' => $message, 'dispenser' => $dispenser]);
    }

    public function removeItems(Request $request, $id)
    {
        $validator = Validator::make($request->only('item', 'metric'), [
            'item' => 'required|integer',
            'metric' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response(['message' => 'Validation failed', 'errors' => $validator->messages()], 401);
        }
        $dispenser = Dispenser::find($id);
        $item = Item::find($request->get('item'));
        $metric = Metric::where('symbol', $request->get('metric'))->first();
        if (!$dispenser) {
            return response(['message' => "Dispenser not found"], 404);
        }
        if (!$item) {
            return response(['message' => "Item with \"id\" "+$request->get('item')+" not found"], 404);
        }
        if (!$metric) {
            return response(['message' => 'Metric not found'], 404);
        }
        if (!$this->existsItemWithMetricInDispenser($item, $metric, $dispenser)) {
            $message = "Item with metric $metric->symbol does not exists on dispenser $dispenser->name";
            return response(['message' => $message], 400);
        }

        $dispenser->items()->wherePivot('metric_id', $metric->id)->detach($item->id);

        return response(['message' => 'Item removed from dispenser', 'dispenser' => $dispenser]);
    }

    private function existsItemWithMetricInDispenser(Item $item, Metric $metric, Dispenser $dispenser)
    {
        $itemSelected = $dispenser->items()
            ->wherePivot('item_id', $item->id)
            ->wherePivot('metric_id', $metric->id)
            ->first();
        $exists = $itemSelected ? true : false;
        return $exists;
    }

    public function dispense(Request $request){
        
    }
}
