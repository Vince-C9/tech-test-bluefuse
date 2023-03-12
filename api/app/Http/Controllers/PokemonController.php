<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Jobs\ProcessPokemonCSV;
use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    /* There is an argument for using resourceful models here, however given the scale of this app, I have elected not to build a full CRUD into the controller.
    In a larger scale project, this is likely the way I would go, making use of the OTB index, create, store, show, edit, update, destroy methods.*/

    /**
     * Store will be used to process the uploaded CSV.  We will then chunk that CSV into 100 lines of data, and then dispatch a job per 100 entries!
     * Once our intrepid pokemon master has caught all of the pokemon, this will queue up 11 jobs (1015 pokemon at time of creation)!
     *
     * We will rely on the UploadRequest to handle our validation.
     *
     * @param UploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UploadRequest $request){

        $csv = file($request->pokemon_csv);
        $chunks = array_chunk($csv, 100);
        $header=[];

        foreach($chunks as $key => $chunk){
            $data = array_map('str_getcsv', $chunk);
            if($key===0){
                $header=$data[0];
                unset($data[0]);
            }
            ProcessPokemonCSV::dispatch($data, $header);
        }

        /**
         * With more time, the response method would either become some form of trait or otherwise an extension/abstraction of the controller class.
         */
        return response()->json([
            'message'=>'Upload successful!  Your captured Pokemon have been queued with the system.  Please hold while we digitise the monsters and process them!',
            'responseTime'=>microtime(true) - LARAVEL_START.' seconds'
        ], 200);
    }
}
