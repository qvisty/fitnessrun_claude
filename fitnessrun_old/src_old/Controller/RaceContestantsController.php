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
        $raceContestant = $this->RaceContestants->newEntity();
        if ($this->request->is('post')) {
            //Tager postData
            $postData = $this->request->data;
            $raceId = $postData['race_id'];
            $addedContestants = 0;
            $deletedContestants = 0;
          
            //I hvertpost data er der et array contestant_id, som indeholder valgte ID´er.
            $oldContestants = array();
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
