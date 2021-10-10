<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\RandomString;
use App\Utility\FileManager;
use Cake\Http\Response;
use Cake\Utility\Security;
use Cake\ORM\Exception as DbException;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 * @property \App\Model\Table\EventTypesTable $EventTypes
 * @property \App\Model\Table\EventVenuesTable $EventVenues
 * @property \App\Model\Table\EventGuestsTable $EventGuests
 *
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventsController extends AppController
{

    const  UPLOAD_DIR = WWW_ROOT . DS . 'uploads';

    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Events');
        $this->loadModel('EventTypes');
        $this->loadModel('EventVenues');
        $this->loadModel('EventGuests');

//        $this->viewBuilder()->setLayout('left_sidebar');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $events = $this->paginate($this->Events, ['conditions' => ['user_refid' => $this->getActiveUser()->refid]]);

        $this->set(compact('events'));
    }

    public function due($actor = null, $timeframe = '')
    {
        if (!is_null($actor)) {
            try {
                $actor = $this->Posts->getUser($actor);
            } catch (RecordNotFoundException $exc) {
                throw new NotFoundException();
            } catch (\Exception $ex) {

            }
        } else {
            $actor = $this->getActiveUser();
        }

        $dueEvents = $this->Events->find('due', ['actor' => $actor->refid, 'timeframe' => $timeframe]);
        $events = $this->paginate($dueEvents);

        $this->set(['events' => $events, '_serialize' => 'events']);
    }

    /**
     *
     * @return Response|null
     */
    public function create(): Response
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $event = $this->Events->newEntity();
        $eventTypes = $this->EventTypes->find('all')->select(['id','name'])->all();
        $typeList = [];
        $eventTypes->each(function ($type) use (&$typeList) {
            $typeList[$type->id] = $type->name;
        });

        if ($request->is(['post','put'])) {
            $user = $request->getData('user_refid');
            $hostName = $request->getData('host_name');
            $title = $request->getData('event_title');
            $desc = $request->getData('description');
            $type = (int) $request->getData('event_type');
            $privacy = $request->getData('privacy');
            $datetime = $this->getCurrentDateTime();
            $refid = RandomString::generateUniqueID(function($id) {
                return $this->Events->exists(['refid' => $id]);
            }, 20, 'numbers');

            $newEvent = [
                'refid' => $refid,
                'user_refid' => $user,
                'host_name' => $hostName,
                'title' => $title,
                'description' => $desc,
                'event_type_id' => $type,
                'privacy' => $privacy,
                'created' => $datetime,
                'modified' => $datetime
            ];

            $event = $this->Events->patchEntity($event, $newEvent);
            if ($event->hasErrors()) {
                $response = $response->withStatus('500', 'Internal Server Error');
                return $response;
            }

            $uploadedFiles = $request->getUploadedFiles();
            /* @var $thumb Zend\Diactoros\UploadedFile */
            $thumb = $uploadedFiles['image'];
            $destination = rtrim(WWW_ROOT, DS) . DS . 'media' . DS . 'photos';
            $fileSaved = FileManager::saveFile($thumb, $destination);
            if (false === $fileSaved) {
                $response = $response->withStatus('500', 'Internal Server Error');
                return $response;
            }
            $event->set('image', substr($fileSaved['file_path'], strlen(self::UPLOAD_DIR)));
            if (!$this->Events->save($event)) {
                $response = $response->withStatus('500', 'Internal Server Error');
                return $response;
            }

            $response = $response->withStatus(200, 'success')->withStringBody('Success');
            if ($request->is('ajax')) {
                return $response;
            }

            $this->setResponse($response);
            $this->Flash->success(__('Success'));
        }

        $this->set(['event' => $event, 'eventTypes' => $typeList, '_serialize' => 'event']);
    }

    public function calendar($param)
    {

    }

    public function nearby($param)
    {

    }

    public function myEvents($path)
    {

    }

    public function reminders($param)
    {

    }

    public function invites($filter = null)
    {
        $actor = $this->getActiveUser()->refid;
        $query = $this->Events->find('invites', ['actor' => $actor, 'filter' => $filter]);

        $events = $this->paginate($query);

        $this->set('events', $events);
    }

    public function recent()
    {
        $events = $this->paginate($this->Events)->take(5, 0);

        $this->set('events', $events);
    }

    public function upcoming() {

    }
    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => []
        ]);

        $this->set('event', $event);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $event = $this->Events->newEntity();
        if ($this->request->is('post')) {
            $postedEvent = $this->getRequest()->getData();
            $refid = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
            $title = $postedEvent['event_title'];
            $user_refid = $postedEvent['user_refid'];
            $host_name = $postedEvent['host_name'];
            $description = $postedEvent['description'];
            $venues = $postedEvent['venues'];

            // Date collation
            $start_year = $postedEvent['start_date']['year'];
            $start_month = $postedEvent['start_date']['month'];
            $start_day = $postedEvent['start_date']['day'];
            $start_hour = $postedEvent['start_date']['hour'];
            $start_min = $postedEvent['start_date']['minute'];
            $startDate = $start_year . '-' . $start_month . '-' . $start_day . ' ' . $start_hour . ':' . $start_min . ':' . '00';

            $end_year = $postedEvent['end_date']['year'];
            $end_month = $postedEvent['end_date']['month'];
            $end_day = $postedEvent['end_date']['day'];
            $end_hour = $postedEvent['end_date']['hour'];
            $end_min = $postedEvent['end_date']['minute'];
            $endDate = $end_year . '-' . $end_month . '-' . $end_day . ' ' . $end_hour . ':' . $end_min . ':' . '00';

            $data = array(
                'refid' => $refid,
                'event_title' => $title,
                'user_refid' => $user_refid,
                'host_name' => $host_name,
                'venues' => $venues,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'description' => $description
            );
            $event = $this->Events->patchEntity($event, $data);
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));
        }
        $this->set(compact('event'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));
        }
        $this->set(compact('event'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            $this->Flash->error(__('The event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
