<?php

namespace App\LivescoreApi;

use App\Fixture;
use App\Matchday;
use App\MatchEvent;
use App\MatchStats;


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
        $data = $this->toAssocArray($this->getLiveScoreData());

        $this->processLiveData($data);

        echo '<pre>';
            var_dump($data);
        echo '</pre>';
    }

    private function readIniFile() {
        $ini = parse_ini_file('config.ini');

        $this->defineIfNotDefined('KEY', $ini['KEY']);
        $this->defineIfNotDefined('SECRET', $ini['SECRET']);
        $this->defineIfNotDefined('BASE_URI', $ini['BASE_URI']);
        $this->defineIfNotDefined('COMPETITION_ID', $ini['COMPETITION_ID']);
    }

    private function defineIfNotDefined($key, $value) {
        if (!defined($key))
            define($key, $value);
    }


    private function getLiveScoreData() {
        $uri = BASE_URI . 'scores/live.json?' . 'key=' . KEY . '&secret=' . SECRET . '&competition_id=' . COMPETITION_ID;
        try {
            return $json = file_get_contents($uri);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return null;
    }


    private function getLocalFixtures() {
        //$fixtures = Matchday::
        $fixtures = Fixture::get();
        return $fixtures;
    }

    private function processLiveData($data) {
        $localFixtures = $this->getLocalFixtures()->toArray();
        foreach ($data['data']['match'] as $liveMatch) {
            foreach ($localFixtures as $localFixture) {
                $localFixtureId = $localFixture['id'];
                if ($liveMatch['fixture_id'] == $localFixture['id_api']) {
                    if ($liveMatch['status'] == 'NOT STARTED'){
                        $this->updateFixture($localFixtureId, $liveMatch['id'], 'id_match');
                        continue;
                    } else if ($liveMatch['status'] == 'IN PLAY') {
                        if ($localFixture['status'] == 'NOT_STARTED' || $localFixture['status'] == 'HALF_TIME_BREAK') {
                            $this->updateFixtureStatus($localFixtureId, 'IN_PLAY');
                        } 
                        $this->updateFixture($localFixtureId, $liveMatch['time'], 'minutes');
                        $this->updateMatchScore($localFixture['id'], $liveMatch['score']);
                    } else if ($liveMatch['status'] == 'HALF TIME BREAK' ) {
                        if ($localFixture['status'] == 'IN_PLAY' || $localFixture['status'] == 'ADDED_TIME') {
                            $this->updateFixtureStatus($localFixtureId, 'HALF_TIME_BREAK');
                            $this->updateFixture($localFixtureId, $liveMatch['ht_score'], 'ht_score');
                        }

                    } else if ($liveMatch['status'] == 'ADDED TIME') {
                        if ($localFixture['status'] == 'IN_PLAY') {
                            $this->updateFixtureStatus($localFixtureId, 'ADDED_TIME');
                            $this->updateFixture($localFixtureId, $liveMatch['time'], 'minutes');
                        }
                        $this->updateMatchScore($localFixture['id'], $liveMatch['score']);
                    } else if ($liveMatch['status'] == 'FINISHED') {
                        // do something with time (FT/AET) - or will it be handled in views?
                        if ($localFixture['status'] == 'IN_PLAY' || $localFixture['status'] == 'ADDED_TIME') {
                            $this->updateFixtureStatus($localFixtureId, 'FINISHED');
                        }

                        if ($localFixture['ht_score'] == null) {
                            $this->updateFixture($localFixtureId, $liveMatch['ht_score'], 'ht_score');
                        } 

                        if ($localFixture['ft_score'] == null) {
                            $this->updateFixture($localFixtureId, $liveMatch['ft_score'], 'ft_score');
                        } 

                        if ($localFixture['et_score'] == null) {
                            $this->updateFixture($localFixtureId, $liveMatch['et_score'], 'et_score');
                        }
                    }
                    if ($localFixture['status'] != 'FINISHED' && $localFixture['status'] != 'NOT_STARTED') {
                        $this->updateMatchScore($localFixture['id'], $liveMatch['score']);
                    }
                    if ($liveMatch['events'] != null)
                        $this->insertMatchEvents($liveMatch['id']);
                    $this->insertStatsData($liveMatch['id']);
                }
            }
        }
    }

    private function getStatsData($matchId) {
        $uri = BASE_URI . 'matches/stats.json?' . 'key=' . KEY . '&secret=' . SECRET . '&match_id=' . $matchId;
        try {
            return $json = file_get_contents($uri);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return null;
    }

    private function insertStatsData($matchId) {
        $data = $this->toAssocArray($this->getStatsData($matchId))['data'];
        $matchStats = MatchStats::find($matchId);
        if ($matchStats === null) {
            $matchStats = new MatchStats;
            $matchStats->id_match = $matchId;
        }


        $matchStats->yellow_cards = $data['yellow_cards'];
        $matchStats->red_cards = $data['red_cards'];
        $matchStats->substitutions = $data['substitutions'];
        $matchStats->possesion = $data['possesion'];
        $matchStats->free_kicks = $data['free_kicks'];
        $matchStats->goal_kicks = $data['goal_kicks'];
        $matchStats->throw_ins = $data['throw_ins'];
        $matchStats->offsides = $data['offsides'];
        $matchStats->corners = $data['corners'];
        $matchStats->shots_on_target = $data['shots_on_target'];
        $matchStats->shots_off_target = $data['shots_off_target'];
        $matchStats->attempts_on_goal = $data['attempts_on_goal'];
        $matchStats->saves = $data['saves'];
        $matchStats->fauls = $data['fauls'];
        $matchStats->treatments = $data['treatments'];
        $matchStats->penalties = $data['penalties'];
        $matchStats->shots_blocked = $data['shots_blocked'];
        $matchStats->dangerous_attacks = $data['dangerous_attacks'];
        $matchStats->attacks = $data['attacks'];

        $matchStats->save();
    }

    private function getEventsData($matchId) {
        $uri = BASE_URI . 'scores/events.json?' . 'key=' . KEY . '&secret=' . SECRET . '&id=' . $matchId;
        try {
            return $json = file_get_contents($uri);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return null;
    }

    private function insertMatchEvents($matchId) {
        $data = $this->toAssocArray($this->getEventsData($matchId));
        foreach ($data['data']['event'] as $event) {
            if (MatchEvent::find($event['id']) !== null)
                continue;

            $matchEvent = new MatchEvent;
            $matchEvent->id = $event['id'];
            $matchEvent->id_match = $event['match_id'];
            $matchEvent->player = $event['player'];
            $matchEvent->time = $event['time'];
            $matchEvent->event = $event['event'];
            $matchEvent->sort = $event['sort'];
            $matchEvent->home_away = $event['home_away'];
            $matchEvent->save();
        }
        return $data;
    }

    private function updateFixtureStatus($fixtureId, $status) {
        $fixture = Fixture::find($fixtureId);
        $fixture->status = $status;
        $fixture->save();
    }

    private function updateMatchScore($fixtureId, $score) {
        if ($score == null)
            return;

        $fixture = Fixture::find($fixtureId);

        $scores = explode(' - ', $score);
        if ($fixture['home_score'] == $scores[0] && $fixture['away_score'] == $scores[1])
            return;

        $fixture['home_score'] = $scores[0];
        $fixture['away_score'] = $scores[1];
        $fixture->save();
    }

    private function updateFixture($fixtureId, $value, $fixtureParameter) {
        if ($value == null)
            return;

        $fixture = Fixture::find($fixtureId);
        if ($fixture[$fixtureParameter] == $value)
            return;

        $fixture[$fixtureParameter] = $value;
        $fixture->save();
    }

    
    private function toAssocArray($json) {
        return json_decode($json, true);
    }

}
