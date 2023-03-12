<?php

namespace Tests\Feature;

use App\Models\Pokemon;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PokemonUploadsFeatureTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_will_error_if_a_file_is_not_provided(){
        $response = $this->post(route('pokemon.store'));
        $response->assertStatus(422)->assertJsonStructure(['errors']);
   }

   public function test_it_will_produce_a_list_of_pokemon_that_are_in_the_database(){
        /** Note: Can create factories to provide random information in tests/seeders to make this a little more fluid.*/
        Pokemon::create([
            'name'=>'Test Pokemon',
            'height'=>6,
            'weight'=>5
        ]);
        $response = $this->get(route('pokemon.get'));

        $pokemon = json_decode($response->content());

        //Another way of writing assertStatus(200)
        $response->assertOk();
        $this->assertTrue(is_array($pokemon));
        $this->assertTrue(count($pokemon)>0);

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
