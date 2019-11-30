<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Fixture;

class GetLiveScores implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->readIniFile();
        $data = $this->getData();

    }

    private function readIniFile() {
        $ini = parse_ini_file('config.ini');
        define('KEY', $ini['KEY']);
        define('SECRET', $ini['SECRET']); 
        define('BASE_URI', $ini['BASE_URI']);
        define('COMPETITION_ID', $ini['COMPETITION_ID']);
    }

    private function getData() {
        $uri = BASE_URI . 'scores/live.json?' . 'key=' . KEY . '&secret=' . SECRET . '&competition_id=' . COMPETITION_ID;
        try {
            return $json = file_get_contents($uri);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return null;
    }

    private function getLocalFixtures() {
        $fixtures = Fixture::where('status', 'NOT_STARTED')->orWhere('status', 'IN_PLAY')->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
