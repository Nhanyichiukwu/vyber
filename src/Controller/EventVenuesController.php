<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EventVenues Controller
 *
 * @property \App\Model\Table\EventVenuesTable $EventVenues
 * @method \App\Model\Entity\EventVenue[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventVenuesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Events'],
        ];
        $eventVenues = $this->paginate($this->EventVenues);

        $this->set(compact('eventVenues'));
    }

    /**
     * View method
     *
     * @param string|null $id Event Venue id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $eventVenue = $this->EventVenues->get($id, [
            'contain' => ['Events', 'Guests', 'Invitees', 'Dates'],
        ]);

        $this->set(compact('eventVenue'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $eventVenue = $this->EventVenues->newEmptyEntity();
        if ($this->request->is('post')) {
            $eventVenue = $this->EventVenues->patchEntity($eventVenue, $this->request->getData());
            if ($this->EventVenues->save($eventVenue)) {
                $this->Flash->success(__('The event venue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event venue could not be saved. Please, try again.'));
        }
        $events = $this->EventVenues->Events->find('list', ['limit' => 200]);
        $this->set(compact('eventVenue', 'events'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Event Venue id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $eventVenue = $this->EventVenues->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eventVenue = $this->EventVenues->patchEntity($eventVenue, $this->request->getData());
            if ($this->EventVenues->save($eventVenue)) {
                $this->Flash->success(__('The event venue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event venue could not be saved. Please, try again.'));
        }
        $events = $this->EventVenues->Events->find('list', ['limit' => 200]);
        $this->set(compact('eventVenue', 'events'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Event Venue id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $eventVenue = $this->EventVenues->get($id);
        if ($this->EventVenues->delete($eventVenue)) {
            $this->Flash->success(__('The event venue has been deleted.'));
        } else {
            $this->Flash->error(__('The event venue could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
