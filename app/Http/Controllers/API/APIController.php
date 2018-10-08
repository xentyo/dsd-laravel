<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class APIController extends Controller
{
    protected $class = '';
    protected $model = '';
    protected $modelName = '';
    protected $modelListName = '';
    protected $defaultSort = 'name';
    protected $storeRules = [];
    protected $updateRules = [];
    protected $ids = [];
    protected $sorts = [];

    public function __construct(array $attributes = [])
    {
        $this->modelName = strtolower($this->model);
        $this->modelListName = str_plural($this->modelName);
        if (count($this->updateRules) < 1) {
            $this->updateRules = $this->storeRules;
        }

        if (count($this->sorts) < 1) {
            $this->sorts = \Schema::getColumnListing(app($this->class)->getTable());
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->only('sort', 'direction');
        $direction = $params['direction'] = mb_strtolower($params['direction'] ?? 'asc');
        $validator = Validator::make($params, [
            'sort' => 'string|alpha_dash',
            'direction' => 'in:asc,desc'
        ]);
        if($validator->fails()){
            return response(['message' => 'Validation fails', 'errors' => $validator->messages()]);
        }
        $sort = $params['sort'] ?? $this->defaultSort;
        $objectsArray = forward_static_call($this->class . "::orderBy", $sort, $direction)->get();
        if (count($objectsArray) === 0) {
            $message = 'No ' . str_plural("$this->model") . " found";
            return response(['message' => $message, $this->modelListName => $objectsArray]);
        } else {
            $message = count($objectsArray) . ' ' . str_plural($this->model) . " found";
            return response(['message' => $message, $this->modelListName => $objectsArray]);
        }
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
                $this->modelName => $object,
            ]);
        } else {
            $response = response([
                'message' => $this->model . ' found',
                $this->modelName => $object,
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
                    $this->modelName => $object,
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
        if ($object === null) {
            $response = response([
                'message' => $this->model . ' not found',
                $this->modelName => $object,
            ]);
        } else {
            $object->delete();
            $response = response([
                'message' => $this->model . ' deleted',
                $this->modelName => $object,
            ]);
        }

        return $response;
    }

    protected function isId(string $param)
    {
        foreach ($this->ids as $id) {
            if ($id === $param) {
                return true;
            }
        }

        return false;
    }

    protected function getSort($sort)
    {
        foreach ($this->sorts as $key => $value) {
            if ($sort === $value) {
                return $value;
            }
        }
        return null;
    }

    private function assignAttributes(Model $model, array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if ($this->isId($attribute)) {
                $attribute = $attribute . '_id';
            }

            $model->$attribute = $value;
        }
    }
}
