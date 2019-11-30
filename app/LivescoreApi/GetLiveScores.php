<?php

namespace App\LivescoreApi;

use App\Fixture;

class GetLiveScores
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->readIniFile();
        $data = $this->toAssocArray($this->getData());
        echo '<pre>';
        //var_dump($data['data']['match']);
        foreach ($data['data']['match'] as $match) {
            var_dump($match);
        }
        // foreach ($this->getLocalFixtures()->toArray() as $a)
        //     var_dump($a);
        echo '</pre>';
    }

    private function readIniFile() {
        $ini = parse_ini_file('config.ini');
        define('KEY', $ini['KEY']);
        define('SECRET', $ini['SECRET']); 
        define('BASE_URI', $ini['BASE_URI']);
        define('COMPETITION_ID', $ini['COMPETITION_ID']);
    }

    private function getData() {
        $uri = BASE_URI . 'scores/live.json?' . 'key=' . KEY . '&secret=' . SECRET /*. '&competition_id=' . COMPETITION_ID;*/;
        try {
            return $json = file_get_contents($uri);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return null;
    }

    private function toAssocArray($json) {
        return json_decode($json, true);
    }


    private function getLocalFixtures() {
        $fixtures = Fixture::where('status', 'NOT_STARTED')->orWhere('status', 'IN_PLAY')->get();
        return $fixtures;
    }

    private function process($data) {
        $localFixtures = $this->getLocalFixtures()->toArray();
        
        foreach ($data['data']['match'] as $liveMatch) {
            foreach ($localFixtures as $localFixture) {
                if ($liveMatch['fixture_id'] == $localFixture['id']) {
                    if ($liveMatch['status'] == 'IN PLAY') {

                        if ($localFixture['status'] == 'NOT_STARTED') {
                            // update to IN_PLAY
                            // update  fixture match_id
                        } else if ($localFixture['status'] == 'HALF_TIME_BREAK') {

                        }

                        // update score
                        // update ht score if not null
                        // update ft score if not null
                        // update ot score if not null
    
                        // call function getEvents(match_id)
                            // insert new events
                        // call function getMatchStats(match_id)
                            // update match_stats table
                    } else if ($liveMatch['status'] == 'HALF TIME BREAK' ) {

                    } else if ($liveMatch['status'] == 'ADDED TIME') {

                    } else if ($liveMatch['status'] == 'FINISHED') {
                        // update local status to FINISHED
                    }
                }
            }
        }
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
