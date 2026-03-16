<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContestantFinishtimes Controller
 *
 * @property \App\Model\Table\ContestantFinishtimesTable $ContestantFinishtimes
 */
class ContestantFinishtimesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contestants', 'Races']
        ];
        $contestantFinishtimes = $this->paginate($this->ContestantFinishtimes);

        $this->set(compact('contestantFinishtimes'));
        $this->set('_serialize', ['contestantFinishtimes']);
    }

    /**
     * View method
     *
     * @param string|null $id Contestant Finishtime id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contestantFinishtime = $this->ContestantFinishtimes->get($id, [
            'contain' => ['Contestants', 'Races']
        ]);

        $this->set('contestantFinishtime', $contestantFinishtime);
        $this->set('_serialize', ['contestantFinishtime']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //Modellen bruges senere til at finde ud af hvilke deltagere der er i løbet
        $this->loadModel('RaceContestants');
        
        //Således at der kan læses/skrives til sesssion variabler.
        $session = $this->request->session();       
        
        $contestantFinishtime = $this->ContestantFinishtimes->newEntity();
        if ($this->request->is('post')) {
            $postData = $this->request->data;
            $addLaps = $postData['addLaps'];
            
            $session->write('addLaps', $addLaps);
            
            $contestantAlreadyFinished = $this->ContestantFinishtimes->exists(['race_id' => $postData['race_id'], 'contestant_id' => $postData['contestant_id']]);

            if($contestantAlreadyFinished)
            {
                $this->Flash->error(__('The contestant has already finished the race. Nothing saved'));
                return $this->redirect(['action' => 'add','activerace'=>$this->request->query('activerace')]);
            }
            
            //Hvis der er valgt, at man også vil gemme antal gennemførte runder.
            if($addLaps == 1)
            {
               //Indlæser modellen fra Laps, som skal bruges senere.
               $this->loadModel('ContestantLaps');
               $lapsCount = $postData['laps']; //Hvor mange runder der er løbet
               $contestantId = $postData['contestant_id']; // Brugerens ID
               $raceId = $postData['race_id']; //Løbets ID
               
               //De 'post data' der skal anvendes.
               $lapData = array();
               $lapData['contestant_id'] = $contestantId;
               $lapData['race_id'] = $raceId;
               
               //Løkke hvor der gemmes det antal runder, som brugeren har løbet
               for($i=0;$i<$lapsCount;$i++)
               {
                    $contestantLap = $this->ContestantLaps->newEntity();
                    $contestantLap = $this->ContestantLaps->patchEntity($contestantLap, $lapData);
                    $this->ContestantLaps->save($contestantLap);
               }
                    //Flash om at runderne er gemt.
                    $this->Flash->success(__('The contestant laps has been saved. Laps saved: ').$lapsCount );
            }
            
            $contestantFinishtime = $this->ContestantFinishtimes->patchEntity($contestantFinishtime, $postData);
            if ($this->ContestantFinishtimes->save($contestantFinishtime)) {
                //Respons
                $this->Flash->success(__('The contestant finishtime has been saved.'));

                return $this->redirect(['action' => 'add','activerace'=>$this->request->query('activerace')]);
            } else {
                $this->Flash->error(__('The contestant finishtime could not be saved. Please, try again.'));
            }
        }
        
        //$contestants = $this->ContestantFinishtimes->Contestants->find('list', ['conditions'=>['contestants.active'=>1]]);
        
        $contestants = $this->RaceContestants->find('all')->contain('Contestants')->select('contestants.id')->select('contestants.name')->toArray();
        if ($this->request->is(['get'])) {
            $activeRace = $this->request->query('activerace');
            if(isset($activeRace))
            {
                $contestants = $this->RaceContestants->find('all',['conditions'=>['race_id'=>$activeRace]])->contain('Contestants')->select('contestants.id')->select('contestants.name')->toArray();
            }
        }
        
        //Ryder op i det array, som er fået oven over. Så det får den rigtige struktur..
        $cTmp = array();
        foreach($contestants as $contestant)
        {
            $cId = $contestant['contestants']['id']; //ID
            $cName = $contestant['contestants']['name']; //Navnet
            $cTmp[$cId] = $cName; //Indsætter i array
        }
        
        $contestants = $cTmp; //Overskriver variblen, så den indeholder de rigtige oplysninger.
        $races = $this->ContestantFinishtimes->Races->find('list', ['conditions'=>['races.active'=>1]]);
        
        $this->set(compact('contestantFinishtime', 'contestants', 'races'));
        $this->set('_serialize', ['contestantFinishtime']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contestant Finishtime id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contestantFinishtime = $this->ContestantFinishtimes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contestantFinishtime = $this->ContestantFinishtimes->patchEntity($contestantFinishtime, $this->request->data);
            if ($this->ContestantFinishtimes->save($contestantFinishtime)) {
                $this->Flash->success(__('The contestant finishtime has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contestant finishtime could not be saved. Please, try again.'));
            }
        }
        $contestants = $this->ContestantFinishtimes->Contestants->find('list', ['limit' => 200]);
        $races = $this->ContestantFinishtimes->Races->find('list', ['limit' => 200]);
        $this->set(compact('contestantFinishtime', 'contestants', 'races'));
        $this->set('_serialize', ['contestantFinishtime']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contestant Finishtime id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contestantFinishtime = $this->ContestantFinishtimes->get($id);
        if ($this->ContestantFinishtimes->delete($contestantFinishtime)) {
            $this->Flash->success(__('The contestant finishtime has been deleted.'));
        } else {
            $this->Flash->error(__('The contestant finishtime could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
