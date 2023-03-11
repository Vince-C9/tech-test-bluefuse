<?php

namespace Tests\Unit;

use App\Http\Requests\UploadRequest;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertTrue;

class PokemonUploadsTest extends TestCase
{

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
        $rules_keys = array_keys($request->rules());
        $this->assertTrue(count(array_diff($rules_keys, array_keys($request->messages())))===0);
    }

    /**
     * Again, a rigid approach making a fragile test.  If we wanted to add a file size cap to the ruleset,
     * the app would work, but this would fail.
     */
    public function test_the_uploads_form_request_rules_only_accept_csv_mimetypes(){
        $request = new UploadRequest();
        $rules = $request->rules();
        $this->assertTrue(in_array('required|mimetypes:csv', $rules));
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




}
