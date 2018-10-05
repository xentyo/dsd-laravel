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
            'item.*' => 'integer|required|exists:items,id',
            'quantity' => 'integer|required|gte:1',
            'metric' => 'string|required|exists:metrics,symbol',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->messages()], 401);
        } else {
            $dispenser = Dispenser::find($id);
            $metric = Metric::where('symbol', $request->get('metric'))->first();
            $items = [];
            if (!$dispenser) {
                return response(['message' => "Dispenser not found"], 404);
            }
            $itemIds = $request->get('item');
            foreach ($itemIds as $key => $itemId) {
                $item = Item::find($itemId);
                if (!$item) {
                    return response(['message' => "Item with \"id\" "+$itemId+" not found"], 404);
                }
                $items[] = $item;
            }
            foreach($items as $item){
                $dispenser->items()->save($item, ['metric_id' => $metric->id, 'quantity' => $request->get('quantity')]);
            }
            $message = count($items). " items added to dispenser: ". $dispenser->name;
            $dispenser = Dispenser::find($dispenser->id)->first();
            return response(['message' => $message, 'dispenser' => $dispenser]);
        }

        return response("{}", 500);
    }
}
