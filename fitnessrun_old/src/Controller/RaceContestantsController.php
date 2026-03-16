<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RaceContestants Controller
 *
 * @property \App\Model\Table\RaceContestantsTable $RaceContestants
 */
class RaceContestantsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Races', 'Contestants']
        ];
        $raceContestants = $this->paginate($this->RaceContestants);

        $this->set(compact('raceContestants'));
        $this->set('_serialize', ['raceContestants']);
    }

    /**
     * View method
     *
     * @param string|null $id Race Contestant id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $raceContestant = $this->RaceContestants->get($id, [
            'contain' => ['Races', 'Contestants']
        ]);

        $this->set('raceContestant', $raceContestant);
        $this->set('_serialize', ['raceContestant']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    
    public function add()
    {
        //Indlæser de ekstra modeller, som er nødvendige
        $this->loadModel('Contestants');
        $this->loadModel('Races');
        
        //Det ID, der er valgt i GET-query.
        $raceId = $this->request->query('activerace');
        
        $teamName =  $this->request->query('team');
        
        //Den nye optegnelse
        $raceContestant = $this->RaceContestants->newEntity();

        //Finder alle deltagere, som er aktive.
        if($teamName != 'all')
        {
            if($teamName == 'unknown')
            {
                $teamName = "";
            }
            
            $contestants = $this->Contestants->find('list')
                ->where(['active'=>1,'team'=>$teamName]);
        
            
            
        }
        else
        {
            $contestants = $this->Contestants->find('list')
                ->where(['active'=>1]);
        }
        

        //Finder alle tilgængelige hold
        $teams = $this->Contestants->find('all')->select(['team'])->distinct(['team']);
        $tmp = array('all'=>__('View all'));
        foreach($teams as $team)
        {
            if(empty($team['team']))
            {
                $tmp['unknown'] = __("Unknown");
            }
            else
            {
               $tmp[$team['team']] = $team['team']; 
            }                
        }
        $teams = $tmp; //Overskriver variablen, med nye værdier.
        
        //Finder alle løbsdeltagere.
        $raceContestants = $this->RaceContestants->find('list',['keyField'=>'Contestants.id','valueField'=>'Contestants.name'])
                ->select(['Contestants.id','Contestants.name'])
                ->contain('Contestants')
                ->where(['race_id'=>$raceId]);
                
        //Finder alle løb der er aktive.
        $races = $this->Races->find('list')->where(['active'=>1]);
        

        //Sætter variabler til VIEW
        $this->set(compact('raceContestant','raceContestants','contestants',"races",'teams'));
        
        /*
         * HÅNDTERE POST DATA
         */
        if ($this->request->is('post')) {
            //Tager postData
            $postData = $this->request->data;
            $raceId = $postData['race_id'];
            $modifiedRaceContestants = $postData['raceContestants'];
            
            //Omformer nuværrende raceContestantArray til samme format som anvendes i $modifiedRaceContestants, for derefter at sammenligne arrays.
            $tmp = array();
            foreach($raceContestants as $raceContestant => $value)
            {
                array_push($tmp, $raceContestant);
            }
            $raceContestants = $tmp;
     
            //Hvis alle brugere er fjernet fra listen, da udføres dette trin.
            $itemsToAdd = array();
            $itemsToDelete = array();
            if(count($modifiedRaceContestants)<1 || !isset($modifiedRaceContestants)  || empty($modifiedRaceContestants) )
            {
                $itemsToDelete = $raceContestants;
            }
            else
            {
                $itemsToAdd = array_diff($modifiedRaceContestants,$raceContestants); //Hvis der er valgt nogle nye, da findes de i denne diff
                $itemsToDelete = array_diff($raceContestants,$modifiedRaceContestants); //Hvis der er slettet nogle fra listen, da findes de i denne diff.          
            }
            
            //For hver af de items der skal tilføjes
            $addedContestants = 0;
            foreach($itemsToAdd as $itemToAdd)
            {
                $raceContestant = $this->RaceContestants->newEntity([
                        'race_id'=>$raceId,
                        'contestant_id'=>$itemToAdd
                        ]);
                //Hvis der ikke kan gemmes, da meldes fejl.
                if ($this->RaceContestants->save($raceContestant)) {
                    $addedContestants = $addedContestants+1;

                    //return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The race contestant could not be saved. Please, try again.'));
                }    
            }
            
            //For hver af de items der skal slettes.
            $deletedContestants = 0;
            foreach($itemsToDelete as $itemToDelete)
            {
                //Hvis record findes, da skal den slettes
                $record = $this->RaceContestants->find('all')
                        ->where(['contestant_id'=>$itemToDelete,'race_id'=>$raceId])->select('id')->first();

                $this->delete($record->id,false,false);
                $deletedContestants = $deletedContestants+1;
            }
            
            //Lidt bruger feedback
            ($addedContestants>0) ? $this->Flash->success(__('The race contestants saved:').$addedContestants) : "";
            ($deletedContestants>0) ? $this->Flash->success(__('The race contestants removed:').$deletedContestants) : "";
            return $this->redirect(['action' => 'add','activerace'=>$raceId,'team'=>$teamName]);
        }
    }

    
    
    public function addOld()
    {
        $raceContestant = $this->RaceContestants->newEntity();
        if ($this->request->is('post')) {
            //Tager postData
            $postData = $this->request->data;
            $raceId = $postData['race_id'];
            $addedContestants = 0;
            $deletedContestants = 0;
          
            //I hvertpost data er der et array contestant_id, som indeholder valgte ID´er.
            $oldContestants = array();
            if(count($postData['contestant_id'])>0 && isset($postData['contestant_id']))
            {
                foreach($postData['contestant_id'] as $contestantId)
                {
                    //Gemmer ID´et til senere brug
                    array_push($oldContestants, $contestantId);

                    //Opretter ny entry og udfylder variablerne/kolonnerne.
                    $raceContestant = $this->RaceContestants->newEntity([
                            'race_id'=>$raceId,
                            'contestant_id'=>$contestantId
                            ]);

                    //Hvis optegnelsen allerede findes, altså at deltageren allerede er tilmeldt løbet, da meldes fejl.
                    if(!$this->RaceContestants->exists(['contestant_id' => $contestantId, 'race_id' => $raceId]))
                    {
                        //Hvis der ikke kan gemmes, da meldes fejl.
                        if ($this->RaceContestants->save($raceContestant)) {
                            //$this->Flash->success(__('The race contestant has been saved.'));
                            $addedContestants = $addedContestants+1;

                            //return $this->redirect(['action' => 'index']);
                        } else {
                            $this->Flash->error(__('The race contestant could not be saved. Please, try again.'));
                        }    
                    }
                    else 
                    {
                        //$this->Flash->error(__('The race contestant could not be saved, because the contesant already is in race.'));
                    }
                }                
            }

            
            //Laver oprydning af evt. fjernede ID´er
            $newContestants = $this->RaceContestants->find('all',['conditions'=>['race_id'=>$raceId],'fields'=>['contestant_id']])->toArray();
            
            //Løkker igennem resultaterne, og laver en simpler array, da det muliggør anvendelse af in_array() senere. Kan nok gøres smartere.
            $newContestants_tmp = array();
            foreach($newContestants as $newContestant)
            {
                array_push($newContestants_tmp, $newContestant['contestant_id']);
            }
            $newContestants = $newContestants_tmp; //Overskriver variablen
            
            foreach($newContestants as $newContestant)
            {
                //$old_contestant_id = $oldContestant['contestant_id'];
                if(!in_array($newContestant, $oldContestants) || $newContestant == -1)
                {
                    $deletedContestants = $deletedContestants+1;
                    $racecontestantId = $this->RaceContestants->find('all',['conditions'=>['contestant_id'=>$newContestant]])
                            ->toList()[0]['id'];
                    
                    //delete(id,redirect,flash)
                    $this->delete($racecontestantId,false,false);
                }
            }
        
            //Lidt bruger feedback
            ($addedContestants>0) ? $this->Flash->success(__('The race contestants saved:').$addedContestants) : "";
            ($deletedContestants>0) ? $this->Flash->success(__('The race contestants removed:').$deletedContestants) : "";
            
            return $this->redirect(['action' => 'add','activerace'=>$this->request->query('activerace')]);
        }
        
        $races = $this->RaceContestants->Races->find('list');
        $contestants = $this->RaceContestants->Contestants->find('list');
        $activeRace = $this->request->query('activerace');
        if(isset($activeRace))
        {
            $contestantsInRace = $this->RaceContestants->find('list',['conditions'=>['race_id'=>$activeRace],'contain'=>'Contestants','keyField' =>'contestant_id','valueField'=>'contestant.name']);
        }
        else {
            //$contestantsInRace = $this->RaceContestants->find('list',['conditions'=>['race_id'=>$activeRace],'contain'=>'Contestants','keyField' =>'contestant_id','valueField'=>'contestant.name']);
            $contestantsInRace = [];
        }
        $this->set(compact('raceContestant', 'races', 'contestants','contestantsInRace'));
        $this->set('_serialize', ['raceContestant']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Race Contestant id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $raceContestant = $this->RaceContestants->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $raceContestant = $this->RaceContestants->patchEntity($raceContestant, $this->request->data);
            if ($this->RaceContestants->save($raceContestant)) {
                $this->Flash->success(__('The race contestant has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The race contestant could not be saved. Please, try again.'));
            }
        }
        $races = $this->RaceContestants->Races->find('list', ['limit' => 200]);
        $contestants = $this->RaceContestants->Contestants->find('list', ['limit' => 200]);
        $this->set(compact('raceContestant', 'races', 'contestants'));
        $this->set('_serialize', ['raceContestant']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Race Contestant id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null,$redirect = true,$flash = true)
    {
        $this->request->allowMethod(['post', 'delete']);
        $raceContestant = $this->RaceContestants->get($id);
        if ($this->RaceContestants->delete($raceContestant)) {
            if($flash)
            {
                $this->Flash->success(__('The race contestant has been deleted.'));
            }
        } else {

            $this->Flash->error(__('The race contestant could not be deleted. Please, try again.'));
        }

        if($redirect)
        {
            return $this->redirect(['action' => 'index']);            
        }
    }
}
