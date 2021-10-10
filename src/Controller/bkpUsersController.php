<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer;
use Cake\Mailer\MailerAwareTrait;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\ForbiddenException;
use Cake\Validation\Validation;

/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize() {
        parent::initialize();
        
        //$this->Auth->allow(['index', 'signup', 'login']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    

    private function _registrationStep2() {
        $this->viewBuilder()->setTemplate('register_step2');

        $session = $this->request->getSession();
        $isAjax = $this->request->is('ajax');
        $user = $this->Users->newEntity();

        if ($this->request->is(['post', 'ajax'])) {
            $postData = $this->request->getData();

            if (!isset($postData['username'])) {
                if ($isAjax) {
                    echo 'Please set your username';
                    return;
                }
                $this->Flash->error(__('Please set your username'));
                return;
            }
            $pass_msg1 = 'Both password fields are required';
            $pass_msg2 = 'Oops! Looks like both passwords do not match';

            if (!isset($postData['password'], $postData['re_password'])) {
                if ($isAjax) {
                    echo $pass_msg1;
                    return;
                }
                $this->Flash->error(__($pass_msg1));
                return;
            } elseif ($postData['password'] !== $postData['re_password']) {
                if ($isAjax) {
                    echo $pass_msg2;
                    return;
                }

                $this->Flash->error(__($pass_msg2));
                return;
            }


// If no errors are encountered, then it is time to gather all the 
// data and save
            else {
                $firstname = $session->read('Signup.firstname');
                $middlename = $session->read('Signup.middlename');
                $lastname = $session->read('Signup.lastname');
                $email = $session->read('Signup.email');
                $phone = $session->read('Signup.phone');
                $contactType = $session->read('Signup.contactType');
                $username = $this->CustomString->sanitize($postData['username']);
                $password = $this->CustomString->sanitize($postData['password']);
                $datetime = date('Y-m-d h:i:s');
                $ref_id = $this->CustomString->generateRandom(16);


// Check for existing user
                if ($this->User->getInfo($username) instanceof \App\Model\Entity\User) {
                    if ($isAjax) {
                        echo 'Username already taken!';
                        return;
                    }
                    $this->Flash->error(__('Username already taken!'));
                    return;
                }

                $userData = array(
                    'ref_id' => $ref_id,
                    'email' => $email,
                    'phone' => $phone,
                    'username' => $username,
                    'password' => $password,
                    'firstname' => $firstname,
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                    'created' => $datetime,
                    'modified' => $datetime,
                    'activated' => '1'
                );

                $user = $this->Users->patchEntity($user, $userData);

                if ($this->Users->save($user)) {
                    // Notify the administrator about the event.
//                        $event = 'signup';
//                        $msgToAdmin = $userData['firstname'] . ' ' . $userData['lastname'];
//                        $this->notifyAdminAboutThisEvent($event, $msgToAdmin);
                    // If no errors, send a mail or sms to the contact provided, depending on the contact type
                    if ($contactType === 'phone') {
                        // Write SMS Code Here...
                    } else if ($contactType === 'email') {
                        // Send email...
                    }

// Destroy the entire session and start a new one for this user
                    $session->destroy();
                    $user = $this->User->getInfo($user->ref_id);

                    if ($user) {
                        $user = $this->User->getProfile($user);
                        $this->Auth->setUser($user);
                        $this->Flash->default(__('Welcome to ' . Configure::read('Site.name')));
                        return $this->redirect('/');
                    }
                } else {
                    $this->Flash->error(__('Sorry, we\'re unable to create your account at the moment. Please, try again.'));
                }
            }
        }
    }
}
