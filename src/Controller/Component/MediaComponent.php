<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Table\AudiosTable;
use App\Model\Table\VideosTable;
use App\Utility\CustomString;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Locator\TableLocator;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

/**
 * Media component
 * @property CustomStringComponent $CustomString
 * @property Component\PaginatorComponent $Paginator
 */
class MediaComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    protected $components = ['CustomString','Paginator'];


    /**
     * @param array $path
     * @param array $params
     * @throws BadRequestException
     * @throws \Throwable
     * @throws NotFoundException
     * @return mixed|void
     */
    public function handle(array $params = [], array $path = [])
    {
        if (!count($path)) {
            throw new BadRequestException();
        }
        $key = $path[0];
        $endpoint = lcfirst(Inflector::camelize($key));
        $params = collection($params)->each(function ($value) {
            return CustomString::sanitize($value);
        })
            ->toArray();

        try {
            $result = $this->$endpoint($path, $params);
        } catch (\Throwable $throwable) {
            if (Configure::read('debug')) {
                throw $throwable;
            }
            $msg = 'Oops! We searched everywhere but could not find the' .
                ' page you requested.';
            throw new NotFoundException($msg);
        }

        return $result;
    }

    public function music(array $path = null, array $queryParams = null)
    {
        $filter = (string) isset($queryParams['filter'])
            ? $queryParams['filter']
            : 'any';

        $pageId = (int) isset($queryParams['page'])
            ? $queryParams['page']
            : 1;
        $limit = (int) isset($queryParams['limit'])
            ? $queryParams['limit']
            : 24;
        $orderField = (string) isset($queryParams['order_by'])
            ? $queryParams['order_by']
            : 'id';
        $sortField = (string) isset($queryParams['sort'])
            ? $queryParams['sort']
            : 'id';
        $direction = (string) isset($queryParams['direction'])
            ? $queryParams['direction']
            : 'desc';
        /** @var AudiosTable $Medias */
        $Medias = (new TableLocator())->get('Medias');
        $allMusic = $Medias->find('byEntertainmentType', [
            'entertainmentType' => 'music'
        ]);
        $publishedMusic = $Medias->findPublished($allMusic);
        if ($pageId < 1) {
            $pageId = 1;
        }
        $totalPages = ceil($publishedMusic->count() / $limit);
        if ($pageId > $totalPages) {
            $pageId = $totalPages;
        }
        $offset = $limit * ($pageId - 1);
        if ($offset < 0) {
            $offset = 0;
        }
        $findByFilter = 'find' . ucfirst($filter);
        $music = $Medias->{$findByFilter}($publishedMusic)
            ->limit($limit)
            ->offset($offset)
            ->order(['Medias.' . $orderField => $direction]);

        return $music->all();
    }

    public function movies(array $path = null, array $queryParams = null)
    {
        $filter = (string) isset($queryParams['filter'])
            ? $queryParams['filter']
            : 'any';

        $pageId = (int) isset($queryParams['page'])
            ? $queryParams['page']
            : 1;
        $limit = (int) isset($queryParams['limit'])
            ? $queryParams['limit']
            : 24;
        $orderField = (string) isset($queryParams['order_by'])
            ? $queryParams['order_by']
            : 'id';
        $sortField = (string) isset($queryParams['sort'])
            ? $queryParams['sort']
            : 'id';
        $direction = (string) isset($queryParams['direction'])
            ? $queryParams['direction']
            : 'desc';
        /** @var VideosTable $Medias */
        $Medias = (new TableLocator())->get('Medias');
        $allMovies = $Medias->find('byEntertainmentType', [
            'entertainmentType' => 'movie'
        ]);
        $publishedMovies = $Medias->findPublished($allMovies);
        if ($pageId < 1) {
            $pageId = 1;
        }
        $totalPages = ceil($publishedMovies->count() / $limit);
        if ($pageId > $totalPages) {
            $pageId = $totalPages;
        }
        $offset = $limit * ($pageId - 1);
        if ($offset < 0) {
            $offset = 0;
        }
        $findByFilter = 'find' . ucfirst($filter);
        $movies = $Medias->{$findByFilter}($publishedMovies)
            ->limit($limit)
            ->offset($offset)
            ->order(['Medias.' . $orderField => $direction]);

        return $movies->all();
    }
}
