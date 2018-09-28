<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class APIController extends Controller
{
    protected $class = '';
    protected $model = '';
    protected $modelName = '';
    protected $modelListName = '';
    protected $orderBy = 'name';
    protected $storeRules = [];
    protected $updateRules = [];
    protected $ids = [];

    public function __construct(array $attributes = [])
    {
        $this->modelName = strtolower($this->model);
        $this->modelListName = str_plural($this->modelName);
        if (count($this->updateRules) < 1) $this->updateRules = $this->storeRules;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = response();
        $objectsArray = forward_static_call($this->class . "::orderBy", $this->orderBy)->get();
        if (count($objectsArray) === 0)
            $response = response([$this->modelListName => $objectsArray]);
        else
            $response = response([$this->modelListName => $objectsArray]);
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->storeRules);
        $response = response();
        if ($validator->fails()) {
            $response = response(['errors' => $validator->messages()], 400);
        } else {
            $object = new $this->class();
            $this->assignAttributes($object, $request->all());
            $object->save();
            $response = response([$this->modelName => $object]);
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dispenser  $dispenser
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $object = forward_static_call([$this->class, 'find'], $id);
        if ($object === null) {
            $response = response([
                'message' => $this->model . ' not found',
                $this->modelName => $object
            ]);
        } else {
            $response = response([
                'message' => $this->model . ' found',
                $this->modelName => $object
            ]);
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dispenser  $dispenser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->updateRules);
        if ($validator->fails()) {
            $response = response(['errors' => $validator->messages()], 400);
        } else {
            $object = forward_static_call([$this->class, 'find'], $id);
            if ($object === null) {
                $response = response([
                    'message' => $this->model . ' not found',
                    $this->modelName => $object
                ]);
            } else {
                $this->assignAttributes($object, $request->all());
                $object->save();
                $response = response($object);
            }
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dispenser  $dispenser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = forward_static_call([$this->class, 'find'], $id);
        if ($object === null) $response = response([
            'message' => $this->model . ' not found',
            $this->modelName => $object
        ]);
        else {
            $object->delete();
            $response = response([
                'message' => $this->model . ' deleted.',
                $this->modelName => $object
            ]);
        }
        return $response;
    }

    private function isId(string $param)
    {
        $is = false;
        foreach ($this->ids as $id)
            if (!$is && $id === $param) $is = true;
        return $is;
    }

    private function assignAttributes(Model $model, array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if ($this->isId($attribute))
                $attribute = $attribute . '_id';
            $model->$attribute = $value;
        }
    }
}
