<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Utility\FileManager;
use Cake\Utility\Inflector;
use Cake\I18n\Time;
use Cake\Utility\Text;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;

/**
 * DynamicFiles Controller
 *
 * @property \App\Model\Table\VideosTable $Videos
 * @property \App\Model\Table\AudiosTable $Audios
 * @property \App\Model\Table\PhotosTable $Photos
 *
 * @method \App\Model\Entity\Media[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DynamicFilesController extends AppController
{
    const MEDIA_DIR = WWW_ROOT . 'uploads' . DS;
    const STATIC_IMAGE_DIR = WWW_ROOT . 'img' . DS;

    public function initialize(): void
    {
        parent::initialize();

        $this->Auth->Allow();
        $this->loadModel('Photos');
        $this->loadModel('Videos');
        $this->loadModel('Audios');
    }
    public function beforeRender(EventInterface $event) {
        parent::beforeRender($event);

        if ($this->getRequest()->getQuery('request_origin') === 'container') {
            $this->viewBuilder()
                    ->setLayoutPath('/')
                    ->setLayout('blank');
        }
        if ($this->getRequest()->is('ajax')) {
            $this->viewBuilder()
                    ->setLayoutPath('/')
                    ->setLayout('ajax');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Media id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function load($file_id)
    {
        $this->viewBuilder()->setLayout('ajax');
        $request = $this->getRequest();
        $response = $this->getResponse();
        $fileType = $request->getQuery('type') ?? 'photo';
        $fileRole = $request->getQuery('role') ?? 'bg';
        $fileRole = Inflector::dasherize($fileRole);
        $fileFormat = $request->getQuery('format');
        $fileSize = $request->getQuery('size');
        $filename = $file_id . '.' . $fileFormat;
        $root = rtrim(WWW_ROOT, DS);
        $pluralFileType = Inflector::pluralize($fileType);

        $dir = self::MEDIA_DIR . $pluralFileType;
        $file = $dir . DS . $filename;
        if (!file_exists($file) || !is_readable($file)) {
            $file = self::STATIC_IMAGE_DIR . $filename;
        }
        if (!file_exists($file) || !is_readable($file)) {
            $file = self::STATIC_IMAGE_DIR . $fileRole . DS . $filename;
        }
        if (!file_exists($file) || !is_readable($file)) {
            $file = self::STATIC_IMAGE_DIR . Inflector::pluralize($fileRole) . DS . $filename;
        }

        if ((!file_exists($file) || !is_readable($file)) && strlen($file_id) === 20) {
            $fileTypeSingular = Inflector::classify($fileType);
            $className = Inflector::pluralize($fileTypeSingular);
            try {
                $media = $this->$className->get($file_id);
            } catch (RecordNotFoundException $exc) {
                $response = $response->withStatus(404, __('{0} does not exist', ucfirst($fileType)));
                return $response;
            }
            $class = "\App\Model\Entity\\$fileTypeSingular";

            if ($media instanceof $class) {
                $file = str_replace('/', DS, self::MEDIA_DIR . $media->file_path);
                $file = str_replace('\\', DS, $file);
            }
        }

        if (file_exists($file) && is_readable($file)) {
            $fileObj = new File($file);
            $response = $response->withFile($fileObj->path);
            return $response;
        }

        $response = $response->withStatus(404, __('{0} does not exist', ucfirst($fileType)));
        return $response;
    }
}
