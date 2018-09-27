<?php

namespace App\Http\Controllers;

use App\Kit;
use Illuminate\Http\Request;

class KitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kits = Kit::orderBy('name')->get();
        return response(['kits' => $kits]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kit  $kit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kit $kit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kit  $kit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kit $kit)
    {
        //
    }
}
