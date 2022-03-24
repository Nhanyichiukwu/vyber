<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\CustomString;
use App\Utility\RandomString;
use App\Utility\FileManager;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Utility\Security;
use Cake\ORM\Exception as DbException;
use Cake\Utility\Text;
use Laminas\Diactoros\UploadedFile;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 * @property \App\Model\Table\EventTypesTable $EventTypes
 * @property \App\Model\Table\EventVenuesTable $EventVenues
 * @property \App\Model\Table\EventGuestsTable $EventGuests
 * @property \App\Controller\Component\FileManagerComponent $FileManager
 *
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Events');
        $this->loadModel('EventTypes');
        $this->loadModel('EventVenues');
        $this->loadModel('EventGuests');

        $this->loadComponent('FileManager');
        $this->enableSidebar(false);
        $this->collapseOffCanvas(true);

//        $this->viewBuilder()->setLayout('left_sidebar');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
//        $arr = array('hello','world','foo','bar','more','items','for','the','array');
//        $key = array_keys($arr, 'world')[0];
//        $position = 2;
//        $widget = 'barz';
//        $fromInsertionPoint = array_slice($arr, $position);
//        $newArr = array_slice($arr, 0, $position, true);
//        $newArr[$position] = $widget;
//        $resultingArr = array_merge($newArr, $fromInsertionPoint);
//        pr($resultingArr);
//        exit;

        $options = [
            'user' => $this->getActiveUser()->refid,
        ];
        $events = $this->Events->find('allForUser', $options);
        $events = $this->paginate($events);

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
     * @return \Cake\Http\Response|null|void
     */
    public function create()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $event = $this->Events->newEmptyEntity();
        $error = 0;

        if ($request->is(['post','put'])) {
            $postData = collection($request->getData())->map(function ($value, $index) {
                if (is_string($value)) {
                    return CustomString::sanitize($value);
                }
                return $value;
            })
                ->toArray();
            $datetime = $this->getCurrentDateTime();
            $refid = RandomString::generateUniqueID(function($id) {
                return $this->Events->exists(['refid' => $id]);
            }, 20, 'numbers');
            $postData['refid'] = $refid;
            $postData['created'] = $datetime;
            $postData['modified'] = $datetime;
            unset($postData['media']);
            $event = $this->Events->patchEntity($event, $postData);

//            $newEvent = [
//                'refid' => $refid,
//                'user_refid' => $user,
//                'hostname' => $hostName,
//                'title' => $title,
//                'description' => $desc,
//                'event_type_id' => $type,
//                'privacy' => $privacy,
//                'created' => $datetime,
//                'modified' => $datetime
//            ];

            if ($event->hasErrors()) {
                $error = 1;
            } else {
                /* @var $media \Laminas\Diactoros\UploadedFile*/
                $media = $request->getUploadedFile('media');
                $destination = $this->FileManager->getUploadDir($event->user_refid,  ['media','event-medias']);
                $fileSaved = $this->FileManager->saveFile($media, $destination->path);
                if (false === $fileSaved) {
                    $error = 1;
                } else {
                    $event->set(
                        'media',
                        substr($fileSaved['file_path'], strlen($destination->path))
                    );
                    if (!$this->Events->save($event)) {
                        $error = 1;
                    }
                }
            }

            if ($error === 0) {
                $success = 'Event saved. Add a venue to your event';
                $response = $response
                    ->withStatus(200, 'success')
                    ->withStringBody($success);
                if ($request->is('ajax')) {
                    return $response;
                }

                $this->Flash->info($success);
                $this->redirect(['action' => 'add-venue', $event->refid]);
            }
            $msg = 'Oops! Unable to create your event. This could be due to ' .
                'an error on our side. Please try again.';
            $this->Flash->error($msg);
        }

//        $eventTypes = $this->Events->EventTypes->find()->select(['id','name'])->all();
//        $typeList = [];
//        $eventTypes->each(function ($type) use (&$typeList) {
//            $typeList[$type->id] = $type->name;
//        });
        $eventTypes = $this->Events->EventTypes->find('list', ['limit' => 200]);
        $this->set(compact('event', 'eventTypes'));
    }

    public function addVenue($event_refid = null)
    {
        $event_refid = CustomString::sanitize($event_refid);
        try {
            $event = $this->Events->get($event_refid);
            unset($event_refid);
        } catch (RecordNotFoundException $e) {
            if (Configure::read('debug')) {
                throw new $e;
            }
            $msg = 'Oops! Looks like you took the wrong turn here... ' .
                'Please go back home...';
            throw new NotFoundException($msg);
        }

        $request = $this->getRequest();
        if ($request->is(['post', 'put'])) {
            $data = CustomString::arraySanitizeRecursive(
                $request->getData('venues')
            )
                /**
                 * Use the map method to decorate the date and add new items
                 */
                ->map(function ($value) use($event) {
                    $value['event_refid'] = $event->refid;

                    /* @var $media \Laminas\Diactoros\UploadedFile */
                    $media = $value['media'];
                    $destination = $this->FileManager->getUploadDir(
                        $event->user_refid, ['media','event-medias']
                    );
                    $mediaSaved = $this->FileManager->saveFile(
                        $media, $destination->path
                    );
                    pr($value['media']);
                    exit;

                    $value['media'] = substr($mediaSaved['file_path'], strlen($destination->path));

                    return $value;
                })

                /**
                 * Use the each method to modify the data. This can not be used
                 * to add new entries
                 */
                ->each(function ($value) use($event) {
                    $dateData = $value['dates'];
                    $dateEntities = $this->Events->Venues->Dates->newEntities(
                        $dateData
                    );
                    $value['dates'] = $dateEntities;

//                    /* @var $media \Laminas\Diactoros\UploadedFile */
//                    $media = $value['media'];
//                    $destination = $this->FileManager->getUploadDir(
//                        $event->user_refid, ['media','event-medias']
//                    );
//                    $mediaSaved = $this->FileManager->saveFile(
//                        $media, $destination->path
//                    );
//                    $value['media'] = substr($mediaSaved['file_path'], strlen($destination->path));

                    return $value;
                })
                ->toArray();

            $venues = $this->Events->Venues->newEntities($data);
            pr($venues);
            exit;
            $event->set('venues', $venues);
            if ($this->Events->save($event)) {
                $this->Flash->success('Event updated successfully...');
                return $this->redirect(['action' => 'index']);
            }
            $msg = 'Oops! Something went wrong. This could be an error on our own part.';
            $this->Flash->error($msg);
        }

        $this->viewBuilder()->setTemplate('add_venue');
        $this->set(compact('event'));
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

    public function upcoming()
    {
        $actor = $this->getActiveUser();
        $this->loadModel('Events');
        $events = $this->EventVenues->find('dueEventsWhereUserIsGuest', [
            'user' => $actor->refid,
        ])->toArray();

        $this->set(compact('events'));
    }

    /**
     * View method
     *
     * @param string|null $id Events id.
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
     * @param string|null $id Events id.
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
     * @param string|null $id Events id.
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
