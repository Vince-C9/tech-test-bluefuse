<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Typically would put this in a controller of its own, and perhaps write a helper method for the response time data & maybe even throw in debug stuff */
Route::get('/', function(Request $request){

    return response()->json([
        'hello'=>'API is live and functioning.',
        'responseTime'=>microtime(true) - LARAVEL_START.' seconds'
    ], 200);
});

/* There is an argument for using resourceful models here, however given the scale of this app, I have elected not to build a full CRUD into the controller.
    In a larger scale project, this is likely the way I would go, making use of the OTB index, create, store, show, edit, update, destroy methods.*/


Route::post("/pokemon", [PokemonController::class, 'store'])->name("pokemon.store");

/*
 * Can protect our routes either by calling middleware via the providers, or thus.  In this case there is no login.
 * Route::post("/pokemon", [PokemonController::class, 'store'])->name("pokemon.store")->middleware("auth");
 */




