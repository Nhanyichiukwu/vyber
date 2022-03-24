<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Network\Exception\ForbiddenException;
use Cake\Validation\Validation;
use Cake\ORM\Locator\TableLocator;
use Cake\View\CellTrait;

/**
 * Profile component
 */
class ProfileComponent extends Component
{

    use CellTrait;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * The user whose profile is being viewed
     *
     * @var \App\Model\Entity\User
     */
    protected $_profile;

    public $components = ['Paginator', 'Cookie', 'PostsManager'];

    public $queryParams = [];





    public function initialize(array $config): void
    {
        parent::initialize($config);

        $tableLocator = new TableLocator();

        $this->Users = $tableLocator->get('Users');
        $this->Posts = $tableLocator->get('Posts');
        $this->Playlists = $tableLocator->get('Playlists');
        $this->PlaylistsItems = $tableLocator->get('PlaylistsItems');
        $this->Albums = $tableLocator->get('Albums');
        $this->Comments = $tableLocator->get('Comments');
        $this->Follows = $tableLocator->get('Follows');
        $this->Personalities = $tableLocator->get('Personalities');
        $this->UserPhotos = $tableLocator->get('UserPhotos');
        $this->Campaigns = $tableLocator->get('Campaigns');
        $this->Engagements = $tableLocator->get('Engagements');
        $this->Notifications = $tableLocator->get('Notifications');
        $this->Categories = $tableLocator->get('Categories');
        $this->Genres = $tableLocator->get('Genres');

        $this->_queryParamsHook();
    }

    public function posts()
    {
        $request = $this->getController()->getRequest();
        $response = $this->getController()->getResponse();

        $query = $this->Posts->find('byAuthor', ['author' => $this->_profile->get('refid')]);
        $offset = 0;
        $limit = 24;
        $previousPage = 1;
        $currentPage = 1;
        $user = $this->getController()->getActiveUser();
        $cookieUser = ($user ? $user->get('refid') : 'UnknownUser');
        $cookieKey = $cookieUser . '.preferences.post_pagination_limit';

        if ($this->Cookie->check($cookieKey)) {
            $limit = $this->Cookie->read($cookieKey);
        }
        $settings = [
            'limit' => $limit
        ];
//        $result = $this->Paginator->paginate($query, $settings);

        if ((int) $request->getQuery('p') >= 2 && $query->count() > $limit) {
            $currentPage = (int) $request->getQuery('p');
            $previousPage = $currentPage - 1;
        }
        if ($currentPage > 1) {
            $offset = ($limit * $previousPage);
        }
        if ($query->count() > 1 && $limit > $query->count()) {
            $limit = $query->count();
        }

        $result = $query->take($limit, $offset)->groupBy('year')->toArray();
//        $decoratedResults = [];
//        $postCell = $this->cell('Posts');
//        foreach ($result as $year => $subgroup) {
//            foreach ($subgroup as $post) {
//                $decoratedPost = $postCell->decorate($post);
//                $decoratedResults[$year][] = $decoratedPost;
//            }
//        }

        return $result;
    }

    /**
     * This method runs upon initialisation, to read the request query parameters
     * and validates its values, before any method is called/executed
     *
     * @return $this
     * @throws BadRequestException
     * @throws RecordNotFoundException
     */
    protected function _queryParamsHook()
    {
        $request = $this->getController()->getRequest();
        $base64_encoded = $request->getQuery('token');
        if ($base64_encoded == null) {
            throw new BadRequestException();
        }
        $base64_decode = base64_decode($base64_encoded);
        $strToArr = explode('_', $base64_decode);
        $userid = substr($strToArr[1], 0, 20);

        try {
            $profile = $this->Users->getUser($userid);
        } catch (RecordNotFoundException $ex) {
            throw $ex;
        }

        $this->_profile = $profile;

        return $this;
    }
}
