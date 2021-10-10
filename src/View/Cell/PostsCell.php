<?php
namespace App\View\Cell;

use Cake\View\Cell;
use App\Controller\Component\NewsfeedComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\Paginator;
use Cake\Collection\Collection;

/**
 * Posts cell
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    protected $_componentRegistry;



    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadModel('Posts');
        $this->_componentRegistry = new ComponentRegistry();
    }

    /**
     *
     * @param string $finder
     * @param array $options
     */
    public function index(string $finder, array $options = [])
    {
        $posts = $this->Posts->find($finder, $options);

        $this->set('posts', $posts);
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
    }

    public function decoratePost($post) {

    }

    public function timeline($actor)
    {
        $newsfeed = new NewsfeedComponent($this->_componentRegistry);
        $posts = $newsfeed->getTimeline($actor);

        $posts = $posts->orderDesc('Posts.id');
        $paginator = new Paginator();
        $posts = $paginator->paginate($posts);

        $timeline = $posts->map(function ($post) {
                    $post->set('comments', $this->Posts->getDescendants($post->refid));
                    return $post;
                })
                ->groupBy(function ($post) {
                    return $post->year;
                })
                ->toArray();

        $this->set(['actor' => $actor, 'timeline' => $timeline, '_serialize' => 'timeline']);
    }

    public function fakeTimeline($actor)
    {
        return $this->timeline($actor);
    }

    public function getSeries($seriesID)
    {

    }

    public function findSimilar($post_text)
    {

    }

    public function findWordUsages($word)
    {

    }
}
