<?php
namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\Datasource\Exception\RecordNotFoundException;
use App\Utility\Folder;
use App\Utility\File;

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
    const MEDIA_DIR = WWW_ROOT . 'public-files' . DS;
    const STATIC_IMAGE_DIR = WWW_ROOT . 'img' . DS;

    public function initialize(): void
    {
        parent::initialize();

        $this->Auth->Allow();
        $this->loadModel('Photos');
//        $this->loadModel('Videos');
//        $this->loadModel('Audios');
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

    public function media($file_id)
    {
        return $this->__load('media', $file_id);
    }

    /**
     * View method
     *
     * @param string|null $id Media id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function __load($file_path, $file_id)
    {
        $this->viewBuilder()->setLayout('ajax');
        $request = $this->getRequest();
        $response = $this->getResponse();

        // The owner of the file. If none is provided, it will use the site default
        $fileSrc = $request->getQuery('_src', 'default');

        // The type of file, whether audio, video, photo, or other types of file
        $fileType = $request->getQuery('type', 'photo');

        $category = $request->getQuery('_cat');

        // What the file is used for determines the specific folder where to find it
        $fileRole = Inflector::dasherize(
            $request->getQuery('role', 'photo')
        );

        // The format of the file: .png, .jpg, .mp3, etc.
        $fileFormat = $request->getQuery('format', 'jpg');

        // The size of the file to be returned.
        $fileSize = $request->getQuery('size','medium');

        // Build the file by connecting all the pieces together.
        $theFile = $file_id . '.' . $fileFormat;

        $root = rtrim(WWW_ROOT, DS);
        $pluralFileType = Inflector::pluralize($fileType);

//        $dir = self::MEDIA_DIR . $pluralFileType;
//        $file = $dir . DS . $filename;

        // First, we start by searching for the image in /webroot/img directory and subdirectories
        $pathToFile = self::STATIC_IMAGE_DIR . $theFile;
        if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
            $pathToFile = self::STATIC_IMAGE_DIR . $fileRole . DS . $theFile;
        }
        if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
            $pathToFile = self::STATIC_IMAGE_DIR . Inflector::pluralize($fileRole) . DS . $theFile;
        }

        // If we don't see it there, then, we search in the /webroot/public-files directory and subdirectories
        if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
            $publicPath = implode(DS, [
                rtrim(self::MEDIA_DIR, DS),
                $fileSrc,
                $file_path
            ]);

            $pathToFile = $publicPath . DS . $pluralFileType . DS . $theFile;

            if ((!file_exists($pathToFile) || !is_readable($pathToFile)) && !is_null($category)) {
                $pathToFile = $publicPath . DS . $pluralFileType . DS . $category . DS . $theFile;
            }
            if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
                $pathToFile = $publicPath . DS . Inflector::pluralize($fileRole) . DS . $theFile;
            }
            if ((!file_exists($pathToFile) || !is_readable($pathToFile)) && !is_null($category)) {
                $pathToFile = $publicPath . DS . Inflector::pluralize($fileRole) . DS . $category . DS . $theFile;
            }
        }

        if ((!file_exists($pathToFile) || !is_readable($pathToFile)) && strlen($file_id) === 20) {
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
                $dir = self::MEDIA_DIR . $media->author_refid . DS . $file_path . DS;
                $pathToFile = str_replace('/', DS, $dir . $media->file_path);
                $pathToFile = str_replace('\\', DS, $pathToFile);
            }
        }

        if (file_exists($pathToFile) && is_readable($pathToFile)) {
            $fileObj = new File($pathToFile);
            $response = $response->withFile($fileObj->path);
            return $response;
        }

        $response = $response->withStatus(404, __('{0} does not exist', ucfirst($fileType)));
        return $response;
    }
    public function load(...$path)
    {
        if (!count($path)) {
            throw new BadRequestException();
        }
        // Prevent illegal dots in the path
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }

        $handler = lcfirst(Inflector::camelize($path[0], '-'));
        $gallery = 'default';
        if (isset($path[1])) {
            $gallery = $path[1];
        }
        pr($handler);
        exit;

        $this->viewBuilder()->setLayout('ajax');
        $request = $this->getRequest();
        $response = $this->getResponse();

        // The owner of the file. If none is provided, it will use the site default
        $fileSrc = $request->getQuery('_src', 'default');

        // The type of file, whether audio, video, photo, or other types of file
        $fileType = $request->getQuery('type', 'photo');

        $category = $request->getQuery('_cat');

        // What the file is used for determines the specific folder where to find it
        $fileRole = Inflector::dasherize(
            $request->getQuery('role', 'photo')
        );

        // The format of the file: .png, .jpg, .mp3, etc.
        $fileFormat = $request->getQuery('format', 'jpg');

        // The size of the file to be returned.
        $fileSize = $request->getQuery('size','medium');

        // Build the file by connecting all the pieces together.
        $theFile = $file_id . '.' . $fileFormat;

        $root = rtrim(WWW_ROOT, DS);
        $pluralFileType = Inflector::pluralize($fileType);

//        $dir = self::MEDIA_DIR . $pluralFileType;
//        $file = $dir . DS . $filename;

        // First, we start by searching for the image in /webroot/img directory and subdirectories
        $pathToFile = self::STATIC_IMAGE_DIR . $theFile;
        if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
            $pathToFile = self::STATIC_IMAGE_DIR . $fileRole . DS . $theFile;
        }
        if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
            $pathToFile = self::STATIC_IMAGE_DIR . Inflector::pluralize($fileRole) . DS . $theFile;
        }

        // If we don't see it there, then, we search in the /webroot/public-files directory and subdirectories
        if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
            $publicPath = implode(DS, [
                rtrim(self::MEDIA_DIR, DS),
                $fileSrc,
                $file_path
            ]);

            $pathToFile = $publicPath . DS . $pluralFileType . DS . $theFile;

            if ((!file_exists($pathToFile) || !is_readable($pathToFile)) && !is_null($category)) {
                $pathToFile = $publicPath . DS . $pluralFileType . DS . $category . DS . $theFile;
            }
            if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
                $pathToFile = $publicPath . DS . Inflector::pluralize($fileRole) . DS . $theFile;
            }
            if ((!file_exists($pathToFile) || !is_readable($pathToFile)) && !is_null($category)) {
                $pathToFile = $publicPath . DS . Inflector::pluralize($fileRole) . DS . $category . DS . $theFile;
            }
        }

        if ((!file_exists($pathToFile) || !is_readable($pathToFile)) && strlen($file_id) === 20) {
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
                $dir = self::MEDIA_DIR . $media->author_refid . DS . $file_path . DS;
                $pathToFile = str_replace('/', DS, $dir . $media->file_path);
                $pathToFile = str_replace('\\', DS, $pathToFile);
            }
        }

        if (file_exists($pathToFile) && is_readable($pathToFile)) {
            $fileObj = new File($pathToFile);
            $response = $response->withFile($fileObj->path);
            return $response;
        }

        $response = $response->withStatus(404, __('{0} does not exist', ucfirst($fileType)));
        return $response;
    }

    public function cwXStatic($file_id)
    {
        echo $file_id;
        exit;

    }
}
