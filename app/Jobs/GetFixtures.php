<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Matchday;
use App\Fixture;
use App\Team;

class GetFixtures implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    function __construct() {
        $this->readIniFile();

        $json = $this->getData();
        if ($json == null) 
            return;

        $data = $this->toAssocArray($json);

        $this->insertNewFixture($data);
    }

    private function readIniFile() {
        $ini = parse_ini_file('config.ini');
        
        $this->defineIfNotDefined('KEY', $ini['KEY']);
        $this->defineIfNotDefined('SECRET', $ini['SECRET']);
        $this->defineIfNotDefined('BASE_URI', $ini['BASE_URI']);
        $this->defineIfNotDefined('COMPETITION_ID', $ini['COMPETITION_ID']);
    }

    
    private function defineIfNotDefined($key, $value) {
        if (!defined($key)) {
            define($key, $value);
        }
    }

    private function getData() {
        $uri = BASE_URI . 'fixtures/matches.json?' . 'key=' . KEY . '&secret=' . SECRET . '&competition_id=' . COMPETITION_ID;
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

    private function insertNewFixture($data) {
        $fixtures = $data['data']['fixtures'];
        foreach ($fixtures as $value) {
            $fixtureDate = $value['date'];
            $this->insertNewMatchday($fixtureDate);

            $fixtureId = $value['id'];
            $fixture = Fixture::where('id_api', $fixtureId)->get();
            if (!$fixture->first()) {
                $idMatchday = Matchday::where('date', $fixtureDate)->first()->id;
                $homeTeam = Team::where('name_api', $value['home_name'])->first();
                $awayTeam = Team::where('name_api', $value['away_name'])->first();
                $homeTeamId = null;
                $awayTeamId = null;
                if ($homeTeam != null) 
                    $homeTeamId = $homeTeam->id;
                if ($awayTeam != null) {
                    $awayTeamId = $awayTeam->id;
                }

                $fixture = new Fixture;
                $fixture->id_matchday = $idMatchday;
                $fixture->home_team = $homeTeamId;
                $fixture->away_team = $awayTeamId;
                $fixture->time = $value['time'];
                $fixture->location = $value['location'];
                $fixture->status = 'NOT_STARTED';
                $fixture->id_api = $fixtureId;
                if ($awayTeam == null || $homeTeam == null)
                    continue;
                $fixture->save();
            }       

        }
        
    }
    private function insertNewMatchday($fixtureDate) {
        $matchday = Matchday::where('date', $fixtureDate)->get();

        if (!$matchday->first()) {
            $matchday = new Matchday;
            $matchday->finished = 0;
            $matchday->date = $fixtureDate;
            $matchday->stage = 'QF';
            $matchday->save();
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
