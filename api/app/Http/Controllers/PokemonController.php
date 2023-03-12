<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    /* There is an argument for using resourceful models here, however given the scale of this app, I have elected not to build a full CRUD into the controller.
    In a larger scale project, this is likely the way I would go, making use of the OTB index, create, store, show, edit, update, destroy methods.*/

    /**
     * Store will be used to upload the CSV of pokemon.  Once successful, it will trigger a job to upload those pokemon into our database.
     *
     * @param UploadRequest $request
     */
    public function store(UploadRequest $request){
        dd($request->pokemon_csv);
    }
}
