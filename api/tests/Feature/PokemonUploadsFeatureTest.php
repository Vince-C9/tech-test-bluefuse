<?php

namespace Tests\Feature;

use App\Jobs\ProcessPokemonCSV;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class PokemonUploadsFeatureTest extends TestCase
{
    public function test_it_will_only_allow_you_to_access_the_store_method_via_post(){
       $response =  $this->get(route('pokemon.store'));
       $response->assertJsonFragment(['message'=>"The GET method is not supported for route pokemon. Supported methods: POST."]);
       $response->assertStatus(405);
    }


   public function test_it_will_error_if_a_file_is_not_provided(){
        $response = $this->post(route('pokemon.store'));
        $response->assertStatus(422)->assertJsonStructure(['errors']);


   }

   public function test_it_will_error_if_a_file_is_provided_but_it_isnt_a_csv(){
        $file = UploadedFile::fake()->create('pokemon.pdf');
        $response = $this->post(route('pokemon.store'), [
            'pokemon_csv'=>$file
        ]);
       $response->assertStatus(422)->assertJsonStructure(['errors']);

   }

   /**
    * Can be improved with a fake bus & a check to see whether files have been queued or not.
    * */
   public function test_it_will_accept_a_csv_and_process_it_into_queueable_jobs(){
       $file = UploadedFile::fake()->create('pokemon.csv');
       $response = $this->post(route('pokemon.store'), [
           'pokemon_csv'=>$file
       ]);
       $response->assertStatus(200)->assertJsonMissingExact(['errors']);


   }



}
