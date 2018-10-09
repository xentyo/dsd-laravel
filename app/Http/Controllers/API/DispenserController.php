<?php

namespace App\Http\Controllers\API;

use App\Dispenser;
use App\Item;
use App\Kit;
use App\Movement;
use App\MovementType;
use Illuminate\Http\Request;
use Stevebauman\Inventory\Models\Metric;
use Validator;
use Auth;

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

    public function dispense(Request $request, $id)
    {
        $validator = Validator::make($request->only('quantity', 'item', 'kit'), [
            'quantity' => 'required|numeric',
            'item' => 'required_without:kit|integer',
            'kit' => 'required_without:item|integer',
        ]);
        if ($validator->fails()) {
            return response(['message' => 'Validation fails', 'errors' => $validator->messages()], 400);
        }
        if ($request->input('item') && $request->input('kit')) {
            return response(['message' => 'We can not dispense a kit and an item at same time'], 400);
        }

        $dispenser = Dispenser::find($id);
        if (!$dispenser) {
            return response(['message' => 'Dispenser not found'], 404);
        }
        $item = Item::find($request->input('item'));
        $kit = Kit::find($request->input('kit'));
        $quantity = $request->input('quantity');
        if ($request->input('item') && !$item) {
            return response(['message' => 'Item not found'], 404);
        }
        if ($request->input('kit') && !$kit) {
            return response(['message' => 'Kit not found'], 404);
        }

        if ($item) {
            return $this->dispenseItem($dispenser, $item, $quantity);
        }
        if ($kit) {
            return $this->dispenseKit($dispenser, $kit, $quantity);
        }
    }

    protected function dispenseItem(Dispenser $dispenser, Item $item, $quantity)
    {
        $itemInDispenser = $dispenser->items()->where('item_id', $item->id)->first();
        if (!$itemInDispenser) {
            return response(['message' => 'Item not found in Dispenser'], 404);
        }
        if ($itemInDispenser->pivot->quantity < $quantity) {
            return response(['message' => 'Insufficient quantity'], 400);
        }
        $movementType = MovementType::where('name', 'item')->first();
        $movementData = [
            'quantity' => $quantity,
            'type_id' => $movementType->name,
            'metric_id' => $itemInDispenser->pivot->metric_id,
            'item_id' => $itemInDispenser->pivot->item_id,
            'dispenser_id' => $itemInDispenser->pivot->dispenser_id,
            'user_id' => Auth::user()->id,
        ];
        $movement = new Movement($movementData);
        $movement->save();
        $dispenser->items()->updateExistingPivot($item->id,
            [
                'quantity' => $itemInDispenser->pivot->quantity -= $quantity,
            ]
        );

        return response(['message' => 'Movement done', 'movement' => $movement]);
    }

    protected function dispenseKit(Dispenser $dispenser, Kit $kit, $quantity)
    {
        return response(['message' => 'Not implemented'], 501);
    }
}
