<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Races Controller
 *
 * @property \App\Model\Table\RacesTable $Races
 */
class RacesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $races = $this->paginate($this->Races);

        $this->set(compact('races'));
        $this->set('_serialize', ['races']);
    }

    /**
     * View method
     *
     * @param string|null $id Race id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $race = $this->Races->get($id, [
            'contain' => ['ContestantFinishtimes', 'ContestantLaps', 'RaceContestants', 'RaceFinishtimes']
        ]);

        $this->set('race', $race);
        $this->set('_serialize', ['race']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $race = $this->Races->newEntity();
        if ($this->request->is('post')) {
            $race = $this->Races->patchEntity($race, $this->request->data);
            if ($this->Races->save($race)) {
                $this->Flash->success(__('The race has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The race could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('race'));
        $this->set('_serialize', ['race']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Race id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $race = $this->Races->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $race = $this->Races->patchEntity($race, $this->request->data);
            if ($this->Races->save($race)) {
                $this->Flash->success(__('The race has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The race could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('race'));
        $this->set('_serialize', ['race']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Race id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $race = $this->Races->get($id);
        if ($this->Races->delete($race)) {
            $this->Flash->success(__('The race has been deleted.'));
        } else {
            $this->Flash->error(__('The race could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
