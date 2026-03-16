<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RaceFinishtimes Controller
 *
 * @property \App\Model\Table\RaceFinishtimesTable $RaceFinishtimes
 */
class RaceFinishtimesController extends AppController
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
        $raceFinishtimes = $this->paginate($this->RaceFinishtimes);

        $this->set(compact('raceFinishtimes'));
        $this->set('_serialize', ['raceFinishtimes']);
    }

    /**
     * View method
     *
     * @param string|null $id Race Finishtime id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $raceFinishtime = $this->RaceFinishtimes->get($id, [
            'contain' => ['Contestants', 'Races']
        ]);

        $this->set('raceFinishtime', $raceFinishtime);
        $this->set('_serialize', ['raceFinishtime']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $raceFinishtime = $this->RaceFinishtimes->newEntity();
        if ($this->request->is('post')) {
            $raceFinishtime = $this->RaceFinishtimes->patchEntity($raceFinishtime, $this->request->data);
            if ($this->RaceFinishtimes->save($raceFinishtime)) {
                $this->Flash->success(__('The race finishtime has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The race finishtime could not be saved. Please, try again.'));
            }
        }
        $contestants = $this->RaceFinishtimes->Contestants->find('list',['conditions'=>['contestants.active'=>1]]);
        $races = $this->RaceFinishtimes->Races->find('list');
        $this->set(compact('raceFinishtime', 'contestants', 'races'));
        $this->set('_serialize', ['raceFinishtime']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Race Finishtime id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $raceFinishtime = $this->RaceFinishtimes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $raceFinishtime = $this->RaceFinishtimes->patchEntity($raceFinishtime, $this->request->data);
            if ($this->RaceFinishtimes->save($raceFinishtime)) {
                $this->Flash->success(__('The race finishtime has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The race finishtime could not be saved. Please, try again.'));
            }
        }
        $contestants = $this->RaceFinishtimes->Contestants->find('list', ['limit' => 200]);
        $races = $this->RaceFinishtimes->Races->find('list', ['limit' => 200]);
        $this->set(compact('raceFinishtime', 'contestants', 'races'));
        $this->set('_serialize', ['raceFinishtime']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Race Finishtime id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $raceFinishtime = $this->RaceFinishtimes->get($id);
        if ($this->RaceFinishtimes->delete($raceFinishtime)) {
            $this->Flash->success(__('The race finishtime has been deleted.'));
        } else {
            $this->Flash->error(__('The race finishtime could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
