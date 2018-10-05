<?php

namespace App\Http\Controllers\API;

use App\Dispenser;
use Illuminate\Http\Request;

class DispenserController extends APIController
{
    protected $class = Dispenser::class;
    protected $model = 'Dispenser';
    protected $storeRules = [
        'name' => 'required|min:2|max:255|unique:dispensers',
        'description' => 'present|min:10|max:255|nullable',
    ];

    public function addItems(Request $request, $id)
    {
        $response = response("", 500);

        $validator = Validator::make($request->only('item'), [
            'item.*' => 'integer|required|exists:items,id',
        ]);
        if ($validator->fails()) {
            $response = response($validator->messages(), 401);
        } else {
            $dispenser = Dispenser::find($id);
            $items = [];
            foreach ($resquest->get('item') as $key => $itemId) {
                $items[] = Item::find($itemId);
            }
            $dispenser->items()->saveMany($items);
        }

        return $response;
    }
}
