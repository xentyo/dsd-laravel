<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use Closure;

class RoutesController extends Controller
{
    public function index()
    {
        $middlewareClosure = function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        };

        $routes = collect(Route::getRoutes());

        foreach (config('pretty-routes.hide_matching') as $regex) {
            $routes = $routes->filter(function ($value, $key) use ($regex) {
                return !preg_match($regex, $value->uri());
            });
        }

        return view('routes-list', [
            'routes' => $routes,
            'middlewareClosure' => $middlewareClosure,
        ]);
    }
}
