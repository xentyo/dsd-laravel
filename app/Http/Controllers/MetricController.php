<?php

namespace App\Http\Controllers;

use Stevebauman\Inventory\Models\Metric;
use Illuminate\Http\Request;
use Validator;

class MetricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Metric::orderBy('name')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);
        $metric = new Metric();
        $response = null;
        if ($validator->fails())
            $response = response($validator->messages(), 400);
        else {
            $metric->name = $request->get('name');
            $metric->symbol = $request->get('symbol');
            $metric->save();
            $response = response($metric);
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Metric::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = null;
        $validator = $this->validator($request);
        if ($validator->fails())
            $response = response([
            'errors' => $validator->messages()
        ], 400);
        else {
            $newMetric = Metric::find($id);
            
            $oldMetric = new Metric();
            $oldMetric->id = $newMetric->id;
            $oldMetric->created_at = $newMetric->created_at;
            $oldMetric->updated_at = $newMetric->updated_at;
            $oldMetric->user_id = $newMetric->user_id;
            $oldMetric->name = $newMetric->name;
            $oldMetric->symbol = $newMetric->symbol;

            $newMetric->name = $request->get('name');
            $newMetric->symbol = $request->get('symbol');
            $newMetric->save();
            $response = response([
                'oldMetric' => $oldMetric,
                'newMetric' => $newMetric
            ]);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function newMetricRules()
    {
        return [
            'name' => 'required|max:255|min:2|alpha|unique:metrics',
            'symbol' => 'required|max:4|min:1|alpha|unique:metrics'
        ];
    }

    public function validator($request)
    {
        return Validator::make($request->all(), $this->newMetricRules());
    }
}
