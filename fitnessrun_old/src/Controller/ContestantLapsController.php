<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContestantLaps Controller
 *
 * @property \App\Model\Table\ContestantLapsTable $ContestantLaps
 */
class ContestantLapsController extends AppController
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
        $contestantLaps = $this->paginate($this->ContestantLaps);

        $this->set(compact('contestantLaps'));
        $this->set('_serialize', ['contestantLaps']);
    }

    /**
     * View method
     *
     * @param string|null $id Contestant Lap id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contestantLap = $this->ContestantLaps->get($id, [
            'contain' => ['Contestants', 'Races']
        ]);

        $this->set('contestantLap', $contestantLap);
        $this->set('_serialize', ['contestantLap']);
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
        $this->loadModel('Contestants');
        
        $contestantLap = $this->ContestantLaps->newEntity();
        if ($this->request->is('post')) {
            $contestantLap = $this->ContestantLaps->patchEntity($contestantLap, $this->request->data);
            $result = $this->ContestantLaps->save($contestantLap);
            if ($result) {
                $latestId = $result->id;
                $raceContestantName = $this->Contestants->get($result->contestant_id)->name;
                $this->Flash->success(__("Successfully added lap for {0}",[$raceContestantName]));
                $this->Flash->success('<form name="DELETEFORM" style="display:none;" method="post" action="/fitnessrun/contestant-laps/delete/'.$latestId.'"><input type="hidden" name="_method" value="POST"></form>'.'<a href="#" onclick="if (confirm(&quot;Are you sure you want to delete # '.$latestId.'?&quot;)) { document.DELETEFORM.submit(); } event.returnValue = false; return false;">'.__('Undo').'</a>',['escape' => false]);                
                return $this->redirect(['action' => 'add','activerace'=>$this->request->query('activerace'),'autosubmit'=>$this->request->query('autosubmit')]);
            } else {
                $this->Flash->error(__('The contestant lap could not be saved. Please, try again.'));
            }
        }
        
        $activeRace = $this->request->query('activerace');
        if(isset($activeRace))
        {
            $contestants = $this->RaceContestants->find('list', ['conditions'=>['race_id'=>$activeRace],'contain'=>'Contestants','keyField' =>'contestant_id','valueField'=>'contestant.name']);
            
            if(count($contestants->toArray())<1)
            {
             $this->Flash->error(__('Currently no contenstants added to this race. Add some in "{0}"',[__('Race Contestants')]));
            }
            
        }
        
        $races = $this->ContestantLaps->Races->find('list');
        $this->set(compact('contestantLap', 'contestants', 'races'));
        $this->set('_serialize', ['contestantLap']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contestant Lap id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contestantLap = $this->ContestantLaps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contestantLap = $this->ContestantLaps->patchEntity($contestantLap, $this->request->data);
            if ($this->ContestantLaps->save($contestantLap)) {
                $this->Flash->success(__('The contestant lap has been saved.'));

                return $this->redirect(['action' => 'add']);
            } else {
                $this->Flash->error(__('The contestant lap could not be saved. Please, try again.'));
            }
        }
        $contestants = $this->ContestantLaps->Contestants->find('list', ['limit' => 200]);
        $races = $this->ContestantLaps->Races->find('list', ['limit' => 200]);
        $this->set(compact('contestantLap', 'contestants', 'races'));
        $this->set('_serialize', ['contestantLap']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contestant Lap id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contestantLap = $this->ContestantLaps->get($id);
        if ($this->ContestantLaps->delete($contestantLap)) {
            $this->Flash->success(__('The contestant lap has been deleted.'));
        } else {
            $this->Flash->error(__('The contestant lap could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
