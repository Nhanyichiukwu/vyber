<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\User;
use Cake\Collection\Collection;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;

/**
 * Timeline component
 */
class TimelineComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @param array $path
     * @param array $params
     * @return mixed
     */
    public function handle(array $params = [], array $path = [])
    {
        if (count($path) > 0) {
            $key = array_keys($path)[0];
            $subHandler = Inflector::camelize($path[$key]);
            if (method_exists($this, $subHandler)) {
                array_shift($path);
                return $this->$subHandler($path, $params);
            }
        }

//        $what = $params['what'];
//        unset($params['what']);
//        $suggestWhat = 'suggest' . Inflector::camelize($what);
//
//        return $this->{$suggestWhat}($params);
    }

    public function post(array $path)
    {
        $this->enableAutoRender();

        if (!count($path)) {
            throw new BadRequestException();
        }
        // Prevent illegal dots in the path
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $postID = $path[0];
        try {
            $post = $this->Posts->getByRefid($postID);
        } catch (RecordNotFoundException $exc) {
            if (Configure::read('debug')) {
                throw $exc;
            }
            throw new NotFoundException();
        }

        $this->set(compact('post'));
    }

    private function postsByUser(array $params, array $path)
    {
        $response = $this->getResponse();
        $account = $this->getActiveUser();
        if (array_key_exists('cw_uid', $params)) {
            $account = $this->Users->get($params['cw_uid']);
        }
        $postsLayout = isset($params['layout']) ? $params['layout'] : null;
        if (is_null($postsLayout)) {
            $postsLayout = 'stack';
        }

        if (!$account instanceof User) {
            throw new BadRequestException();
        }
        $posts = $this->Newsfeed->fetchAllFor($account, 'byAuthor', $account->refid);

        $posts = $posts->orderAsc('Posts.id');
        $posts = $this->paginate($posts);
        $arrayPosts = $posts->toArray();
        $collection = collection($arrayPosts);

        $groupedPosts = $collection->groupBy(function ($post) {
            return $post->year;
        })->toArray();

        $this->set(compact('account', 'postsLayout'));

        return $groupedPosts;
    }
}
