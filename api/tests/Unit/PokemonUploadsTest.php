<?php

namespace Tests\Unit;

use App\Http\Requests\UploadRequest;
use App\Models\Pokemon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

class PokemonUploadsTest extends TestCase
{

    use DatabaseMigrations;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        //Work around to get LARAVEL_START to function in unit tests
        if(!defined("LARAVEL_START")){define('LARAVEL_START', microtime(true));};
    }

    /**
     * This is an example of a fragile test.  It's fragile because while it passes, it's reliant on the pokemon_csv field being named that way.
     * Why is it fragile: If we were to change both the front end and back end of our code to, for example pokemon_file, the code would work,
     * but the test would fail.  This would create a false negative.
     */
    public function test_the_uploads_form_request_has_rules_for_the_pokemon_csv_field(){
        $request = new UploadRequest();
        $this->assertTrue(array_key_exists('pokemon_csv', $request->rules()));
    }

    /**
     * In cases like this it's slightly better to forgo using names, specific IDs and similar.  We don't want our tests to rely on rigid data.
     * We sort of just need to know there are rules set in this instance.
     */
    public function test_the_uploads_form_request_has_rules_set(){
        $request = new UploadRequest();
        $this->assertTrue(count($request->rules())>0);
    }

    /**
     *  Make sure we have custom messages for all our fields - the OTB ones are not great.
     */
    public function test_the_uploads_form_request_has_some_custom_messages_for_errors(){
        $request = new UploadRequest();
        $this->assertTrue(count($request->messages()) > 0);
    }

    /**
     * Again, a rigid approach making a fragile test.  If we wanted to add a file size cap to the ruleset,
     * the app would work, but this would fail.
     */
    public function test_the_uploads_form_request_rules_only_accept_csv_mimetypes(){
        $request = new UploadRequest();
        $rules = $request->rules();
        $this->assertTrue(in_array('required|mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values,text/anytext,application/octet-stream,application/txt', $rules));
    }

    /**
     * A less rigid approach to make sure someone is validating filetypes.
     */
    public function test_the_uploads_form_request_rules_contains_csv_mimetype_check(){
        $request = new UploadRequest();
        $rules = $request->rules();

        $mimetypes=false;

        foreach($rules as $rule)
        {
            if(Str::contains($rule, 'mimetypes:') && Str::contains($rule, 'csv'))
            {
                $mimetypes=true;
                break;
            }
        }

        $this->assertTrue($mimetypes);
    }

    /**
     * Tests to make sure the fillable array is set correctly & the model can save to the db
     */
    public function test_the_model_can_write_successfully_write_a_pokemon_to_the_database(){
        $pokemonBefore = Pokemon::count();
        Pokemon::create(['name'=>'charizard','height'=>8, 'weight'=>98]);
        $this->assertTrue($pokemonBefore < Pokemon::count());
    }


}
