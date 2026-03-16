<?php
namespace App\Controller;

use App\Controller\AppController;

class StatisticsController extends AppController
{    
    public function index()
    {
        //$this->loadModel('ContestantFinishtimes');
        $this->loadModel('Races');
        
        /*$races = $this->ContestantFinishtimes->find('all')
                ->contain('Races')
                ->select(['id'=>'race_id','name'=>'races.name','starttime'=>'races.starttime','endtime'=>'races.endtime'])
                ->distinct('race_id');*/
        
        $races = $this->Races->find('all');
        
        $this->set(compact('races'));
    }
    
    public function view($race_id = null)
    {
        //indlæser de anvendte modeller
        $this->loadModel('ContestantFinishtimes');
        $this->loadModel('ContestantLaps');
        $this->loadModel('Races');
        
        //Finder alle de løb der har det pågældende ID, hvis under nul da fejles der.
        if($this->Races->find('all')->where(['id'=>$race_id])->count() < 1)
        {
            $this->Flash->error(__('Unable to find any race with the given criteria.'));
            return;
        }
        
        if($this->Races->find('all')->where(['id'=>$race_id])->first()->active != 1)
        {
            $this->Flash->set(__('This race is not active. Maybe it has finished? If a mistake then activate it again in the menu "{0}"',[__('Races')]));
        }
        else
        {
            $this->Flash->set(__('This race is an active race. For updated statistics please refresh this page once a while' ));
        }
        
        
        //Får en liste med alle de deltagere, som har afsluttet løbet
        $contestants = $this->ContestantFinishtimes->find('all')
                ->contain('Contestants')
                ->where(['race_id'=>$race_id]);
        
        //Får løbets starttid
        $raceStarttime = $this->Races->find('all')->where(['id'=>$race_id]);
        $raceStarttime = $raceStarttime->first()->starttime;
        
        //Finder ud af hvor mange runder, hver deltager har løbet
        $tmp = array();
        $teamStats = array();
        foreach($contestants as $contestant)
        {
            $contestantStat = array();
            $contestantStat['id'] = $contestant->contestant_id;
            $contestantStat['name'] = $contestant->contestant->name;
            $contestantStat['team'] = $contestant->contestant->team;
            
            //Hvis holdet er ukendt/ikke sat
            if($contestantStat['team'] == "")
            {
              $contestantStat['team'] = __("Unknown");  
            }
            
            //Deltagerens sluttid - Dato og tidsspunkt
            $contestantStat['finishtime'] = $contestant->finishtime;
            //Finder alle de omgange deltageren har løbet
            $contestantStat['lapscount'] = $this->ContestantLaps->find('all')
                    ->where(['contestant_id'=>$contestantStat['id'],'race_id'=>$race_id])
                    ->count();
            
            //Beregner hvor langtid personen har løbet i sekunder
            $raceStarttime = str_replace('/', '-', $raceStarttime); //Gøres for at få det rigtige format, da strtotime kun forstår dd-mm-yyyy og ikke dd/mm/yyyy
            $datetime1 = strtotime($raceStarttime);
            
            $contestantStat['finishtime'] = str_replace('/', '-', $contestantStat['finishtime']);
            $datetime2 = strtotime($contestantStat['finishtime']);
            $interval  = abs($datetime2 - $datetime1);
            $seconds   = round($interval); //Hvor mange sekunder deltageren har taget.
            
            //Hvor langtid i sekunder. Gemmes i array
            $contestantStat['time'] = $seconds;
            
            //Gemmer oplysningerne i arrayet tmp, som bliver til $contestants længere nede.
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
        
        
        if(!count($contestants)>0)
        {
           $this->Flash->set(__("No contestants that have finished this race yet.")); 
        }
        
        
        $this->set(compact('contestants','teamStats'));
        $this->set('_serialize', ['contestants']);
    }
}
