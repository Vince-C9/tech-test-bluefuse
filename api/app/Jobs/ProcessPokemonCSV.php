<?php

namespace App\Jobs;

use App\Models\Pokemon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPokemonCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $header;
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $header)
    {
        $this->data=$data;
        $this->header=$header;
    }

    /**
     * Execute the job.
     * In this case we will process the chunk we have received from the dispatch, and create a new pokemon for each.
     * This approach results in a lot of SQL calls (if we have a lot of pokemon), which is why we've queued it.
     * This will run it in a different thread / a background job, meaning it won't eat up the site users resources or time.
     */
    public function handle(): void
    {
        foreach($this->data as $pokemon){
            Pokemon::firstOrCreate([
               'name'=>$pokemon[0],
               'height'=>$pokemon[2],
               'weight'=>$pokemon[1]
            ]);
        }
    }
}
