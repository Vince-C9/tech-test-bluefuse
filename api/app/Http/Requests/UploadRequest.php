<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * This is where we'd plumb in any complicated rules, like are you authorised to access.  For a simple thing like this, we can just return as true
         * */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        //Because there are many kinds of CSV, we need to account for that in full to support these csv types.  Further validation could go in around this in the form of custom rules to be 100% 
        //that we have the right type of text file.
        return [
            'pokemon_csv'=>'required|mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values,text/anytext,application/octet-stream,application/txt'
        ];
    }


    public function messages(){
        return [
            'pokemon_csv.required'=>'If you want to be the very best, you should provide a CSV list of everything you have caught!',
            'pokemon_csv.mimetypes'=>'Trade denied!  You have not sent the CSV with your pokemon in it as requested!'
        ];
    }
}
