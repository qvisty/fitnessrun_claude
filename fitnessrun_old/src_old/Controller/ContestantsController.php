<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Contestants Controller
 *
 * @property \App\Model\Table\ContestantsTable $Contestants
 */
class ContestantsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $contestants = $this->paginate($this->Contestants);

        $this->set(compact('contestants'));
        $this->set('_serialize', ['contestants']);
    }

    /**
     * View method
     *
     * @param string|null $id Contestant id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contestant = $this->Contestants->get($id, [
            'contain' => []
        ]);

        $this->set('contestant', $contestant);
        $this->set('_serialize', ['contestant']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contestant = $this->Contestants->newEntity();
        if ($this->request->is('post')) {
            $contestant = $this->Contestants->patchEntity($contestant, $this->request->data);
            if ($this->Contestants->save($contestant)) {
                $this->Flash->success(__('The contestant has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contestant could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('contestant'));
        $this->set('_serialize', ['contestant']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contestant id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contestant = $this->Contestants->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contestant = $this->Contestants->patchEntity($contestant, $this->request->data);
            if ($this->Contestants->save($contestant)) {
                $this->Flash->success(__('The contestant has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contestant could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('contestant'));
        $this->set('_serialize', ['contestant']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contestant id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contestant = $this->Contestants->get($id);
        if ($this->Contestants->delete($contestant)) {
            $this->Flash->success(__('The contestant has been deleted.'));
        } else {
            $this->Flash->error(__('The contestant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
