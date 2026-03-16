<?php
namespace App\Controller;

use App\Controller\AppController;

class StatisticsController extends AppController
{    
    public function index()
    {
        $this->loadModel('ContestantFinishtimes');
        
        $races = $this->ContestantFinishtimes->find('all')
                ->contain('Races')
                ->select(['id'=>'race_id','name'=>'races.name','starttime'=>'races.starttime','endtime'=>'races.endtime'])
                ->distinct('race_id');
        $this->set(compact('races'));
    }
    
    public function view($race_id = null)
    {
        $this->loadModel('ContestantFinishtimes');
        $this->loadModel('ContestantLaps');
        $this->loadModel('Races');
        
        if($this->Races->find('all')->where(['id'=>$race_id])->count() < 1)
        {
            $this->Flash->error(__('Unable to find any race with the given criteria.'));
            return;
        }
        
        
        //Får en liste med alle de deltagere, som har afsluttet løbet
        $contestants = $this->ContestantFinishtimes->find('all')
                ->contain('Contestants')
                ->where(['race_id'=>$race_id]);
        
        //Får løbets starttid
        $raceStarttime = $this->Races->find('all')->where(['id'=>$race_id]);
        $raceStarttime = $raceStarttime->first()->starttime;
        //print_r($raceStarttime->first()->starttime);
        //$raceStarttime = $starttime[0]['starttime']['time'];
        
        //Finder ud af hvor mange runder, hver deltager har løbet
        $tmp = array();
        $teamStats = array();
        foreach($contestants as $contestant)
        {
            $contestantStat = array();
            $contestantStat['id'] = $contestant->contestant_id;
            $contestantStat['name'] = $contestant->contestant->name;
            $contestantStat['team'] = $contestant->contestant->team;
            
            if($contestantStat['team'] == "")
            {
              $contestantStat['team'] = __("Unknown");  
            }
            
            $contestantStat['finishtime'] = $contestant->finishtime;
            $contestantStat['lapscount'] = $this->ContestantLaps->find('all')
                    ->where(['contestant_id'=>$contestantStat['id'],'race_id'=>$race_id])
                    ->count();
            
            //Beregner hvor langtid personen har løbet i sekunder
            $datetime1 = strtotime($raceStarttime);
            $datetime2 = strtotime($contestantStat['finishtime']);
            $interval  = abs($datetime2 - $datetime1);
            $seconds   = round($interval);
            
            $contestantStat['time'] = $seconds;
            
            array_push($tmp, $contestantStat);
            
            /*
             * TEAM STATS
             */
            //Hvis holdet allerede findes i array
            if(array_key_exists($contestantStat['team'],$teamStats))
            {
                $teamStats[$contestantStat['team']]['lapscount'] = $teamStats[$contestantStat['team']]['lapscount'] + $contestantStat['lapscount'];
                $teamStats[$contestantStat['team']]['time'] = $teamStats[$contestantStat['team']]['time'] + $contestantStat['time'];
            }
            else
            {
                $teamStats[$contestantStat['team']]['name'] = $contestantStat['team'];
                $teamStats[$contestantStat['team']]['lapscount'] = $contestantStat['lapscount'];
                $teamStats[$contestantStat['team']]['time'] = $contestantStat['time'];
            }
            
        }
        //Overskriver variablen, med de nye informationer.
        $contestants = $tmp;
        
        //Sorterer dem efter rækkefølge (FRA: http://stackoverflow.com/questions/14534672/usort-descending)
        usort($contestants, function($a, $b) {
            if ($a['lapscount'] == $b['lapscount'])
                {
                  // score is the same, sort by endgame
                if ($a['finishtime'] > $b['finishtime']) return 1;
                }
                // sort the higher score first:
                return $a['lapscount'] < $b['lapscount'] ? 1 : -1;
        });
        
        usort($teamStats, function($a, $b) {
            if ($a['lapscount'] == $b['lapscount'])
                {
                  // score is the same, sort by endgame
                if ($a['time'] > $b['time']) return 1;
                }
                // sort the higher score first:
                return $a['lapscount'] < $b['lapscount'] ? 1 : -1;
        });
        
        $this->set(compact('contestants','teamStats'));
        $this->set('_serialize', ['contestants']);
    }
}
