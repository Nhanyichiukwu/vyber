<?php
namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Cookie\CookieCollection;
use DateTime;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Utility\RandomString;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use App\Utility\FileManager;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Utility\Security;

/**
 * Upload Controller
 *
 *
 * @method \App\Model\Entity\Upload[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Model\Table\MediasTable $Medias
 */
class UploadController extends AppController
{
    public $mediaType;
    
    /**
     *
     * @var array
     * @access protected
     */
    protected $_privacy = array ('public', 'protected', 'connections','mutual_connection');
    
    /**
     *
     * @var array Media Orientation options
     * @access protected
     */
    protected $_orientations = array (
        'landscape'     => 'Landscape',
        'portrait'      => 'Portrait'
    );
    
    /**
     *
     * @var array Monetisation option
     * @access protected
     */
    protected $_monetize = array (
        '0' => 'No', 
        '1' => 'Yes'
    );
    
    /**
     *
     * @var array List of Available licenses
     * @access protected
     */
    protected $_licenses = array ();
    
    /**
     *
     * @var array Age Restriction
     * @access protected
     */
    protected $_ageRestriction = array(
        'No Restriction', '13+', '16+', '18+', '25+', '30+', '40+', '50+'
    );
    
    /**
     *
     * @var array 
     * @access protected
     */
    protected $_contentClassifications = array(
        'Movie', 'Music Video', 'Song', 'Comedy', 'Jingle', 'TV Show', 'Fight',
        'video', 'audio', 'voice note'
    );

    /**
     *
     * @var array
     */
    protected $_statusList = array(
        'published' => 'Published', 'pending' => 'Pending'
    );
    
    /**
     *
     * @var array
     */
    protected $_fileTypes = array(
        'audio' => array(
            'audio/mp3',
            'audio/mpeg3',
            'audio/ogg'
        ),
        'video' => array(
            'video/mp4',
            'video/mpeg4',
            'video/ogg'
        ),
        'media' => array(
            'audio/mp3',
            'audio/mpeg3',
            'audio/ogg',
            'video/mp4',
            'video/mpeg4',
            'video/ogg'
        ),
        'photo' => array(
            'image/jpg',
            'image/jpeg',
            'image/png'
        ),
        'doc' => array(
            'text/plain',
            'application/docx',
            'application/pdf',
            'application/zip'
        ),
//        'any' => array(
//            'audio/mp3',
//            'audio/mpeg3',
//            'audio/ogg',
//            'video/mp4',
//            'video/mpeg4',
//            'video/ogg',
//            'image/jpg',
//            'image/mpeg',
//            'image/png',
//            'text/plain',
//            'application/docx',
//            'application/pdf',
//            'application/zip'
//        )
    );

    /**
     * @staticvar The uploads directory for user video, audio, and image files
     * Each media type is stored in its specific folder, ie: videos in /uploads/videos/
     * and audios in /uploads/audios/
     */
    const UPLOAD_DIR = WWW_ROOT . 'uploads' . DS;
    const MAX_ACCEPTABLE_FILESIZE = 60000000;

    public function initialize() {
        parent::initialize();
        $this->loadModel('Medias');
        $this->loadModel('Albums');
        $this->loadModel('Genres');
        $this->loadModel('Categories');
        $this->loadModel('Playlists');
        $this->loadModel('Reviews');
        $this->loadModel('Posts');
        $this->loadModel('Comments');
        
        $this->loadComponent('CustomString');
    }
    
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        
        
    }
    
    public function beforeRender(\Cake\Event\Event $event) {
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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $request = $this->getRequest();
        // Warning! This commented line must not be removed
        // 
//        if ($request->getCookie('PendingUpload')) {
//            $this->Flash->info('You have a pending upload...');
//            return $this->redirect (['action' => 'pending']);
//        }

        // Limit the type of uploadable file to the one selected by the user
        $this->_defineFileType();
        
        
    }
    
    public function photo(...$path)
    {
        $request = $this->getRequest();
        $this->_defineFileType();
        
        if ($request->is(['post','ajax'])) {
            if (!empty($request->getUploadedFiles())) {
                $uploadedPhotos = $request->getUploadedFiles()['photo'];
                foreach ($uploadedPhotos as $uploadedPhoto) {
                    $this->_processUpload($uploadedPhoto, 'photos');
                }

                $photos = $this->_getActiveUploads('photos');

                $this->set('photos', $photos);
            }
            
            if ($request->getData('details')) {
                $data = $request->getData();
            }
        }
        
    }
    
    public function audio(...$path) 
    {
        $fileType = 'audio';
        $acceptedTypes = $this->_getValidFileTypes('audio');
        $this->set(compact('fileType', 'acceptedTypes'));
        
        return $this->media($path);
    }
    
    public function video(...$path) 
    {
        $fileType = 'video';
        $acceptedTypes = $this->_getValidFileTypes('video');
        $this->set(compact('fileType', 'acceptedTypes'));
        
        return $this->media($path);
    }


    /**
     * Handles media upload only via ajax post request. 
     *
     * @return \Cake\Http\Response
     * @throws \Cake\Http\Exception\ForbiddenException
     */
    public function media(... $path) 
    {
        $request = $this->getRequest();
        if ($request->is(['post','ajax'])) {
            // Gathering form Data
            $refid = $this->CustomString->sanitize($request->getData('refid'));
            $title = $this->CustomString->sanitize($request->getData('title'));
            $slug = Text::slug($title);
            $description = $this->CustomString->sanitize($request->getData('description'));
////            $author = $this->CustomString->sanitize($request->getData('author'));
            $genre = $this->CustomString->sanitize($request->getData('genre'));
            $recording_date = implode('-', array_values($request->getData('recording_date')));
            $release_date = implode('-', array_values($request->getData('release_date')));
            $categories = serialize($request->getData('categories[]'));
            $album = $this->CustomString->sanitize($request->getData('album'));
            $playlist = $this->CustomString->sanitize($request->getData('playlists'));
            $counterpart = $this->CustomString->sanitize($request->getData('counterpart'));
            $artist = $this->CustomString->sanitize($request->getData('artist'));
            $featured_artists = $this->CustomString->sanitize($request->getData('featured_artists'));
            $orientation = $this->CustomString->sanitize($request->getData('orientation'));
            $privacy = $this->CustomString->sanitize($request->getData('privacy'));
            $monetize = (int) $this->CustomString->sanitize($request->getData('monetize'));
            $license = $this->CustomString->sanitize($request->getData('license'));
            $tags = $this->CustomString->sanitize($request->getData('tags'));
            $cast = $this->CustomString->sanitize($request->getData('cast'));
            $language = $this->CustomString->sanitize($request->getData('language'));
            $contentClassification = $this->CustomString->sanitize($request->getData('content_classification'));
            $ageRestriction = $this->CustomString->sanitize($request->getData('age_restriction'));
            $targetAudience = $this->CustomString->sanitize($request->getData('target_audience'));
            $status = $this->CustomString->sanitize($request->getData('status'));
            $isDebut = $this->CustomString->sanitize($request->getData('is_debut'));

            // Get the user's location if available;
            $location = '';
            if (!(empty($this->VisitorsHandler->getVisitor()->get('country')) &&
                    empty($this->VisitorsHandler->getVisitor()->get('region')))) 
            {
                $location = serialize([
                    'country' => $this->VisitorsHandler->getVisitor()->get('country'),
                    'region' => $this->VisitorsHandler->getVisitor()->get('region'),
                    'city' => $this->VisitorsHandler->getVisitor()->get('city')
                ]);
            }
            
            // In case the album does not exists
            if (!empty($album)) {
                if (! $this->Albums->exists([
                    'refid' => $album, 
                    'owner_refid' => $user->refid, 
                    'type' => FileManager::getFileType($uploadedFile->mimeType)
                ])) {
                    $album = null;
                }
            }
            
            
            // Poster/Thumbnail/Cover Image
            if ($request->getUploadedFiles()) {
                $thumbnail = $request->getUploadedFile('thumbnail');

                if ($thumbnail) 
                {
                    $thumbExt = FileManager::getFileExtension($thumbnail->getClientFilename());
                    if (!in_array($thumbExt, ['jpg','jpeg'])) {
                        $this->Flash->error('Only JPEG files can be used as media thumbnail');
                        return;
                    }
                    $thumbFilename = 'thumb_' . $timestamp . '_' . $uuid . '.' . $thumbExt;
                    $thumbFilepath = $user->get('refid') . DS 
                            . Inflector::pluralize($mediaType) . DS . $thumbFilename;
                    $thumbDestination = $uploadDir->path . DS . $thumbFilepath;
                }
            }
            
            $newMediaDetails = [
                'refid'                 => $refid,
                'title'                 => $title,
                'slug'                  => $slug,
                'description'           => $description,
                'artist'                => $artist,
                'featured_artists'      => $featured_artists,
//                'file_path'             => $filePath,
//                'permalink'             => $permalink,
//                'media_type'            => $mediaType,
//                'file_mime'             => $mimeType,
                'classification'        => $contentClassification,
                'target_audience'       => $targetAudience,
                'age_restriction'       => $ageRestriction,
                'album_refid'           => $album,
//                'author_refid'          => $user->get('refid'),
                'location'              => $location,
                'audio_or_video_counterpart_refid'     => $counterpart,
                'genre_refid'           => $genre,
                'categories'            => $categories,
                'monetize'              => $monetize,
                'license'               => $license,
                'tags'                  => $tags,
                'cast'                  => $cast,
                'orientation'           => $orientation,
                'language'              => $language,
                'thumbnail'             => $thumbFilepath,
                'status'                => $status,
                'is_debut'              => $isDebut,
                'privacy'               => $privacy,
                'recording_date'        => $recording_date,
                'release_date'          => $release_date
            ];
        }
        
        $mediaType = $request->getQuery('mtp');
        $classification = $request->getQuery('cls');
        
        if ($mediaType === 'audio')
            $equiv = 'video';
        else
            $equiv = 'audio';
        
        $acceptedTypes = $this->_getValidFileTypes($mediaType);
        $this->set(compact('mediaType', 'acceptedTypes'));
        
        // View Vars
        $validOrientations = $this->_getMediaOrientations();
        $genres = (array) $this->_getGenres()->chunk(6)->toArray();
        $categories = (array) $this->_getCategories()->chunk(6)->toArray();
//        $albums = $this->UserProfiler->getAlbums($this->getActiveUser(), $fileType)->toArray();
//        $playlists = $this->UserProfiler->getPlaylists($this->getActiveUser(), $fileType)->toArray();
        $privacyOptions = $this->_getPrivacySettings();
        $monetizationOptions = $this->_getMonetizationOptions();
        $licenseOptions = $this->_getLicenseOptions();
        $userSettings = $this->UserProfiler->getSettings();
        $languages = $this->_getLanguages();
        $ageRanges = $this->_ageRestriction;
        $statusList = $this->_statusList;
        $contentClassifications = $this->_contentClassifications;
        
        $this->set(compact(
            'mediaType', 
            'equiv', 
            'categories',
            'genres', 
            'validOrientations', 
            'privacyOptions', 
            'monetizationOptions', 
            'licenseOptions', 
            'languages', 
            'userSettings',
            'ageRanges',
            'classification',
            'contentClassifications',
            'statusList'
        ));
    }
    
    /**
     * 
     * @param array $path
     */
    public function doc(...$path)
    {
        
    }
    
    /**
     * 
     * @param array $path
     */
    public function all(...$path)
    {
        
    }
    
    private function _defineFileType() {
        $fileType = $this->getRequest()->getQuery('file_type');
        if ($fileType)
            $acceptedTypes = $this->_getValidFileTypes($fileType);
        else
            $acceptedTypes = $this->_getValidFileTypes();
        
        $this->set(compact('fileType','acceptedTypes'));
    }
    
    /**
     * Upload processing endpoint
     * 
     * Handles all upload requests and internally calls the appropriate processor
     * depending on the file type
     * 
     * @param type $path
     * @return type
     */
    public function process(...$path)
    {
        $request = $this->getRequest();
        $this->autoRender = false;
        
        if ($request->is(['post', 'ajax'])) {
            $processor = 'basic';
            if (count($path)) {
                $processor = $path[0];
            }
            if (in_array($processor, ['audio','video']))
                    $processor = 'media';
            $processor .= 'UploadProcessor';
            $processor = '__' . $processor;
            
            if ($this->hasAction($processor)) {
                $this->{$processor}();
            }
        }
        
        return null;
    }
    
    public function __mediaUploadProcessor() 
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $isAjax = $request->is('ajax');
        $user = $this->getActiveUser();
        $response = $response->withType('json');
        $uploadedFile = $request->getUploadedFile('file');
        $classification = $this->CustomString->sanitize($request->getData('classification'));
        $isOK = (bool) true;
        
        
        // Limit upload size to the size specified in the UploadController::MAX_ACCEPTABLE_FILESIZE
        if ($uploadedFile->getSize() > static::MAX_ACCEPTABLE_FILESIZE) {
            $msg = json_encode(['status' => 'error', 'message' => 'Oops! The filesize exceeds limit of 60MB.']);
            $response = $response->withStringBody($msg);
            return $response;
        } else {
            $RString = new RandomString();
            $refid = $RString->generateString(20, 'mixed');

            // Define directories
            $mimeType = $uploadedFile->getClientMediaType();
            $mediaType = FileManager::getFileType($mimeType);
            $uploadDir = FileManager::getUploadDir([$user->get('refid'), Inflector::pluralize($mediaType)]);

            // A unique new name for the file, starting with the first 3 
            // letters from the file type (eg: video = 'vid'; audio = 'aud'),
            // then the current timetamp and a 64 chars long random string
            $timestamp =        date('YmdHis');
            $randBytes =        Security::randomString();
            $ext =              FileManager::getFileExtension($uploadedFile->getClientFilename());
            $newMediaName =     implode('_', [substr($mediaType, 0, 3), $timestamp, implode('.', [$randBytes, $ext])]);
            $fileDestination =  implode(DS, [$uploadDir->path, $newMediaName]);
            $filePath =         implode(DS, [$user->get('refid'), Inflector::pluralize($mediaType), $newMediaName]);
            $permalink =        Router::url("play/{$refid}", true);

            $newMediaDetails = [
                'refid'                 => $refid,
                'title'                 => $uploadedFile->getClientFilename(),
                'slug'                  => Text::slug($uploadedFile->getClientFilename()),
                'file_path'             => $filePath,
                'permalink'             => $permalink,
                'media_type'            => $mediaType,
                'file_mime'             => $mimeType,
                'author_refid'          => $user->get('refid'),
                'classification'        => $classification
            ];

            $medias = $this->Medias;
            $media = $medias->newEntity($newMediaDetails);
            $medias->getConnection()->transactional(
                    function ($connection) 
                    use ($medias, $media, $uploadedFile, $fileDestination, &$isOK) {
//                $response = $this->getResponse();
                
                // If the database operation tests OK, then we proceed with
                // moving the file to the appropriate destination
                // And if that fails, we rollback all operations
                if ($medias->save($media, ['atomic' => false])) {
                    try {
                        $uploadedFile->moveTo($fileDestination);
                        
                        // If the script runs upto this point, it means there
                        // was no error in the file transfer
                        $connection->commit();
                    } catch (Exception $exc) {
                        $exc->getTraceAsString();
                        $isOK = false;
                    }
                } else {
                    $isOK = false;
                }
            });
            
            // Read the error status and return the appropriate response
            if ($isOK) {
                if ($isAjax) {
                    $message = json_encode([
                        'status' => 'success', 
                        'message' => 'Upload Completed',
                        'permalink' => $permalink,
                        'refid' => $refid
                    ]);
                    $response = $response->withStringBody($message);
                } else {
                    $this->Flash->success(_("{media} uploaded", ['media' => ucfirst($mediaType)]));
                }
            } else {
                if ($isAjax) {
                    $message = ['status' => 'error', 'message' => 'Upload Failed'];
                    $response = $response->withStringBody(json_encode($message));
                } else {
                    $this->Flash->error(__('Upload failed!'));
                }
            }
            
            $this->setResponse($response);
        }
    }


    

    protected function _getValidFileTypes($type = null)
    {
        $types = [];
        if ($type && array_key_exists($type, $this->_fileTypes)) {
            $types = $this->_fileTypes[$type];
        } else {
            foreach (array_values($this->_fileTypes) as $array) {
                $types = array_merge($types, $array);
            }
            $types = array_unique($types);
        }
        
        return $types;
    }


    public function pending() 
    {
        $request = $this->getRequest();
//        $this->viewBuilder()->setTemplate('file_details');
        
        $session = $request->getSession();
        $isPost = $request->is('post');
        $user = $this->getActiveUser();
        
        // Just in case a user dives directly on to this page when they have
        // no pending upload, kick them out
        $pendingUpload = $this->_getPendingUpload();
        if (! $pendingUpload) {
            $this->Flash->error('You have no pending upload...');
            return $this->redirect(['action' => 'index']);
        }
        
        $this->set('pendingUpload', $pendingUpload);
//        $File = new File($fileTmpLocation);
//        if (! $File->exists()) {
//            return $this->getResponse()
//                    ->withExpiredCookie('PendingUpload')
//                    ->withLocation(['action' => 'index']);
//        }
        
        // Full URL of the file
//        $fileUri = $this->FileManager->getFileUri('uri',  $user->get('refid') 
//                . '/' . Inflector::pluralize($fileType) . '/' . $newMediaName);
        
//        $Medias = $this->getTableLocator()->get('Medias');
//        $media = $Medias->newEntity();
        
//        if ($isPost)
//        {
//            // Gathering form Data
//            $title = $this->CustomString->sanitize($request->getData('title'));
//            $slug = Text::slug($title);
//            $description = $this->CustomString->sanitize($request->getData('description'));
////            $author = $this->CustomString->sanitize($request->getData('author'));
//            $genre = $this->CustomString->sanitize($request->getData('genre'));
//            $release_date = implode('-', array_values($request->getData('release_date')));
//            $categories = json_encode($request->getData('categories[]'));
//            $album = $this->CustomString->sanitize($request->getData('album'));
//            $playlist = $this->CustomString->sanitize($request->getData('playlist'));
//            $counterpart = $this->CustomString->sanitize($request->getData('counterpart'));
//            $artist = $this->CustomString->sanitize($request->getData('artist'));
//            $featured_artists = $this->CustomString->sanitize($request->getData('featured_artists'));
//            $orientation = $this->CustomString->sanitize($request->getData('orientation'));
//            $privacy = $this->CustomString->sanitize($request->getData('privacy'));
//            $monetize = (int) $this->CustomString->sanitize($request->getData('monetize'));
//            $license = $this->CustomString->sanitize($request->getData('license'));
//            $tags = $this->CustomString->sanitize($request->getData('tags'));
//            $cast = $this->CustomString->sanitize($request->getData('cast'));
//            $language = $this->CustomString->sanitize($request->getData('language'));
//            $contentDefinition = $this->CustomString->sanitize($request->getData('content_definition'));
//            $ageRestriction = $this->CustomString->sanitize($request->getData('age_restriction'));
//            $status = $this->CustomString->sanitize($request->getData('status'));
//            $datetime = date('Y-m-d H:i:s');
//            
//            // Get the user's location if available;
//            $location = '';
//            if (!(empty($this->VisitorsHandler->getVisitor()->get('country')) &&
//                    empty($this->VisitorsHandler->getVisitor()->get('region')))) 
//            {
//                $location = json_encode([
//                    'country' => $this->VisitorsHandler->getVisitor()->get('country'),
//                    'region' => $this->VisitorsHandler->getVisitor()->get('region'),
//                    'city' => $this->VisitorsHandler->getVisitor()->get('city')
//                ]);
//            }
//            
//            // In case the album does not exists
//            if (!empty($album)) {
//                if (! $this->Albums->exists([
//                    'refid' => $album, 
//                    'owner_refid' => $user->refid, 
//                    'type' => FileManager::getFileType($pendingUpload->mimeType)
//                ])) {
//                    $album = null;
//                }
//            }
//            
//            
//            $RString = new RandomString();
//            $refid = $RString->generateString(20);
//            $randomStr = $RString->generateString(32, 'mixed');
//
//            // Define directories
//            $fileType = FileManager::getFileType($pendingUpload->mimeType);
//            $uploadDir = FileManager::getUploadDir([
//                        $user->get('refid'),
//                        Inflector::pluralize($fileType)
//                    ]);
//
//            // A unique new name for the file, starting with the first 3 
//            // letters from the file type (eg: video = 'vid'; audio = 'aud'),
//            // then the current timetamp and a 64 chars long random bit
//            $timestamp = \date('YmdHis');
//            $uuid = Text::uuid();
//            $newMediaName = substr($fileType, 0, 3) . '_' . $timestamp 
//                    . '_' . $uuid . '.' 
//                    . FileManager::getFileExtension($pendingUpload->name);
//            $fileDestination = $uploadDir->path . DS . $newMediaName;
//            $filePath = $user->get('refid') . DS . Inflector::pluralize($fileType) 
//                    . DS . $newMediaName;
//            
//            // Poster/Thumbnail/Cover Image
//            $thumbnail = $request->getUploadedFile('thumbnail');
//            
//            if ($thumbnail) 
//            {
//                $thumbExt = FileManager::getFileExtension($thumbnail->getClientFilename());
//                if (!in_array($thumbExt, ['jpg','jpeg'])) {
//                    $this->Flash->error('Only JPEG files can be used as media thumbnail');
//                    return;
//                }
//                $thumbFilename = 'thumb_' . $timestamp . '_' . $uuid . '.' . $thumbExt;
//                $thumbFilepath = $user->get('refid') . DS 
//                        . Inflector::pluralize($fileType) . DS . $thumbFilename;
//                $thumbDestination = $uploadDir->path . DS . $thumbFilepath;
//            }
//    
//            $refid = $RString->generateString(20);
//            $newMediaDetails = [
//                'refid'                 => $refid,
//                'title'                 => $title,
//                'slug'                  => $slug,
//                'description'           => $description,
//                'artist'                => $artist,
//                'featured_artists'      => $featured_artists,
//                'file_path'             => $filePath,
//                'file_mime_type'        => $fileMediaType,
//                'content_definition'    => $contentDefinition,
//                'age_restriction'       => $ageRestriction,
//                'album_refid'           => $album,
//                'author_refid'          => $user->get('refid'),
//                'location'              => $location,
//                'counterpart_refid'     => $counterpart,
//                'genre_refid'           => $genre,
//                'categories'            => $categories,
//                'monetize'              => $monetize,
//                'license'               => $license,
//                'tags'                  => $tags,
//                'cast'                  => $cast,
//                'orientation'           => $orientation,
//                'language'              => $language,
//                'thumbnail'             => $thumbFilepath,
//                'status'                => $status,
//                'privacy'               => $privacy,
//                'release_date'          => $release_date,
//                'created'               => $datetime,
//                'modified'              => $datetime
//            ];
//    
//            $media = $this->Medias->patchEntity($media, $newMediaDetails);
//            $conx = $this->Medias->getConnection();
//
//            if ($this->Medias->save($media, ['atomic' => false])) 
//            {
//                // Create permalink and shorten the urls
////                $url = $this->generatePermalink($mediaFiletype, $media->ref_id);
////                $UrlShortener = $this->UrlShortener;
////                $url_short_code = $UrlShortener->shorten($url);
//    
//                // Upload the files to the appropriate location on the server
//                try {
////                    $destination = $this->FileManager
////                            ->findOrCreateDirectory($mediaLocation);
////                    $thumb_destination = $this->FileManager
////                            ->findOrCreateDirectory($imagesUploadDir);
////    
////                    $files = array(
////                        [
////                            'location' => $media_tmp_location,
////                            'destination' => $media_filepath
////                        ],
////                        [
////                            'location' => $thumbFileStream,
////                            'destination' => $thumb_filepath
////                        ]
////                    );
//                    
//                    $FileManager = new FileManager();
//                    if (
//                            $FileManager
//                            ->move($fileTmpLocation)
//                            ->to($fileDestination) &&
//                            $thumbnail->moveTo($thumbDestination)
//                        ) {
//                        $this->Flash->success(_("{$fileType} Saved"));
//                        
////                      Commit the transaction
//                        $conx->commit();
//                        
//                        return $this->getResponse()->withLocation([
//                            'controller' => 'media-player'
//                        ]);
//                    } else {
//                        throw new \Exception("Unable to save $fileType");
//                    }
//                } catch (\Exception $e) {
//                    if ($request->is('ajax')) {
//                        echo $e->getMessage();
//                    } else {
//                        $this->Flash->error(_($e->getMessage()));
//                    }
//                }
//            } else {
//                $this->Flash->error(_('Sorry, we\'re unable to upload this {0} at the moment. Please try again', $fileType));
//            }
////            if (array_key_exists('data-referrer', $data)) {
////                $referrer = $data['data-referrer'];
////                $referrer = str_replace($this->request->base, '', $referrer);
////                $this->redirect($referrer);
////            }
//        }
        
            
        // View Vars
//        $validOrientations = $this->_getMediaOrientations();
//        $genres = (array) $this->_getGenres()->chunk(6)->toArray();
//        $categories = (array) $this->_getCategories()->chunk(6)->toArray();
//        $albums = $this->UserProfiler->getAlbums($fileType);
//        $playlists = $this->UserProfiler->getPlaylists($fileType);
//        $privacyOptions = $this->_getPrivacySettings();
//        $monetizationOptions = $this->_getMonetizationOptions();
//        $licenseOptions = $this->_getLicenseOptions();
//        $userSettings = $this->UserProfiler->getSettings();
//        $languages = $this->_getLanguages();
//        $ageRanges = $this->_ageRestriction;
//        $contentDefinitions = $this->_contentDefinitions;
//        $statusList = $this->_statusList;
        
//        $this->set(compact(
//                'media',
//                'tmpFile', 
//                'categories', 
//                'albums', 
//                'playlists', 
//                'genres', 
//                'validOrientations', 
//                'privacyOptions', 
//                'monetizationOptions', 
//                'licenseOptions', 
//                'languages', 
//                'userSettings',
//                'ageRanges',
//                'contentDefinitions',
//                'statusList'));
    }
    
    
    
    /**
     * Upload process abortion method
     * 
     * This will abort an active upload process and delete the temporary file
     * that was previously created and also deletes the cookie
     * data.
     * 
     * @return Http redirect
     */
    public function abort()
    {
        $this->autoRender = false;
        $request = $this->getRequest();
        $response = $this->getResponse();       
        $cookies = $request->getCookieCollection();
        $pendingUpload = $this->_getPendingUpload();
        if ($pendingUpload) {
            /* @var $uploadedFile \Zend\Diactoros\UploadedFile */
            foreach ($pendingUpload as $uploadedFile) {
                $uploadedFile->getStream()->getMetadata();
            }
//        $pendingUploadCookie = $pendingUploadCookie->withExpired();
            $response = $response->withExpiredCookie('PendingUpload');
            $this->setResponse($response);
            
            $this->Flash->success(__('Upload aborted successfully...'));
//            return $this->redirect(['action' => 'index']);
        }
    }
    
    public function oldAbort()
    {
        $this->autoRender = false;
        $request = $this->getRequest();
        $response = $this->getResponse();       
        $cookieParams = $request->getCookieParams();
        $cookieName = 'PendingUpload';
        $pendingUpload = null;
        
        if (array_key_exists($cookieName, $cookieParams)) {
            $pendingUpload = $cookieParams[$cookieName];
            unset($cookieParams[$cookieName]);
            $cookieCollection = new CookieCollection();
            
            foreach ($cookieParams as $key => $value) {
                $cookie = $request->getCookieCollection()->get($key);
                $cookieCollection = $cookieCollection->add($cookie);
                //$cookieCollection = $cookieCollection->addToRequest($request, [$key => $value]);
                $response = $response->withCookie($cookie);
            }
            
            $request = $request->withCookieCollection($cookieCollection);
            $this->setRequest($request);
            $this->setResponse($response);
            
            return $this->setAction('checkIfIsAborted');
        }
        
        $this->Flash->error(_('Sorry, but there is no pending upload session'));
        return $this->redirect(['action' => 'index']);
    }
    
    public function checkIfIsAborted()
    {
//        $cookie = new CookieCollection();
//        $cookie->createFromServerRequest($this->getRequest());
        //print_r($this->getRequest()->getCookieCollection());
        // Try renewing the request instance
//            $request = $this->getRequest();
            
//            $pendingUploadValue = json_decode($pendingUpload->getValue(), false);

//            if (file_exists($pendingUploadValue->tmp_location)) {
//                unlink($pendingUploadValue->tmp_location);
//            }
            
            $this->Flash->info(_('You have canceled your previous upload process!'));
            return $this->redirect(['action' => 'index']);
//            $response = $response->withLocation('../upload');
//            print_r($response->getCookieCollection());
//            exit;
    }
    
    

    public function uploadComplete() 
    {
        $session = $this->getRequest()->getSession();
        
        $media_type = $session->read('media_type');
        $short_url = $session->read('short_url');
    }
    
    protected function _getPrivacySettings() 
    {
        return $this->_privacy;
    }

    protected function _getMonetizationOptions() 
    {
        return $this->_monetize;
    }

    protected function _getLicenseOptions() 
    {
        return $this->_licenses;
    }
    
    protected function _getMediaOrientations()
    {
        return $this->_orientations;
    }


    protected function _generatePermalink($type, $ref_id) {
        $types = [
            'video' => ['controller' => 'tv', 'action' => 'watch'],
            'audio' => ['controller' => 'radio', 'action' => 'listen']
        ];

        $randomKey = $this->CustomString->generateRandom(16);
        $permalink = $this->request->getAttribute('base') . '/' . 
                $types[$type]['controller'] . '/' . 
                $types[$type]['action'] . '/?' . substr($type, 0, 1) . '=' . $ref_id;
        
        return $permalink;
    }
    
    
    protected function _getFileRepository($filetype)
    {
        $repository = null;
        switch ($filetype)
        {
            case 'photo':
                $repository = 'photos';
                break;
            case 'video':
                $repository = 'videos';
                break;
            case 'audio':
                $repository = 'audios';
                break;
            default :
                $repository = 'files';
        }
        
        return $repository;
    }
    
    protected function _getAgeRestriction()
    {
        return $this->_ageRestriction;
    }
    
    protected function _getContentClassifications()
    {
        return $this->_contentClassifications;
    }
    
    protected function _getPendingUpload() 
    {
        $request = $this->getRequest();
        
/* @var $pendingUpload Cookie */
        $pendingUpload = $request->getCookie('PendingUpload');

        // Ensure there is a pending upload before granting access to this page
        if ( !$pendingUpload ) {
            return false;
        }
        
        $pendingFile = unserialize($pendingUpload);

        // Main Media
//        $fileName = $pendingUpload->name;
//        $fileMediaType = $pendingUpload->mimeType;
//        $fileSize = $pendingUpload->size;
//        $fileError = $pendingUpload->error;
//        $fileStream = $pendingUpload->stream;
//        $fileType = $this->FileManager->getFileType($fileMediaType);
//        $fileTmpName = $pendingUpload->tmpName;
//        $fileTmpLocation = $pendingUpload->tmpLocation;
//
//        $tmpFile = array (
//            'name' => $fileTmpName,
//            'file_location' => $fileTmpLocation,
//            'title' => $fileName,
//            'mimetype' => $fileMediaType,
//            'filetype' => $fileType,
//            'size' => $fileSize
//        );
        
        return $pendingFile;
    }
    
    public function _processUpload($uploadedFile, $name = 'PendingUpload') {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $isAjax = $request->is('ajax');
        $isPost = $request->is('post');
        

        // Limit upload size to the size specified in self::MAX_ACCEPTABLE_FILESIZE
//        
            $cookies = $request->getCookieCollection();
            if ($cookies->has($name)) {
                $existingCookies = $request->getCookie($name);
                $existingCookies[] = serialize($uploadedFile);
            } else {
                $newCookie = array(serialize($uploadedFile));
            }
            $cookieData = $existingCookies ?? $newCookie;
            $cookie = (new Cookie($name))
                    ->withValue($cookieData)
                    ->withExpiry(new DateTime('+1 year'))
                    ->withPath('/')
                    //->withDomain('')
                    ->withSecure(false)
                    ->withHttpOnly(false);

            $response = $response->withCookie($cookie);

            $this->setResponse($response);
    }
    
    private function _uploadedFileHasErrors($uploadedFile) {
//        if ($uploadedFile->getSize() > static::MAX_ACCEPTABLE_FILESIZE) {
//            $msg = json_encode(['status' => 'error', 'message' => 'Oops! The filesize exceeds limit of 60MB.']);
//            $response = $response->withStringBody($msg);
//            return $response;
//        } else {
        return false;
    }

    /**
     * 
     * @param string $form
     * @return response|null
     * @throws MissingTemplateException
     * @throws NotFoundException
     */
//    public function addFileInfo($fileType = null) 
//    {
//        if (!$fileType)
//            $fileType = 'basic';
//        $form = $fileType;
//        if (in_array($fileType, ['audio','video']))
//            $form = 'media';
//        
//        $tpl = 'file_info_form/' . $form;
//
//        try {
//            $this->viewBuilder()->setTemplate($tpl);
//        } catch (MissingTemplateException $ex) {
//            if (Configure::read('debug')) {
//                throw new MissingTemplateException();
//            }
//
//            throw new NotFoundException();
//        }
//        
//        // The method below is a hook to prepare the view vars and/or handle the
//        // form submission
//        $this->set('fileType', $fileType);
//        $action = '__add' . ucfirst($form) . 'Info';
//        if ($this->hasAction($action)) {
//            return $this->{$action}($fileType);
//        }
//    }
//    
//    private function __addMediaInfo($fileType) 
//    {
//        $request = $this->getRequest();
//        if ($fileType === 'audio')
//            $equiv = 'video';
//        else
//            $equiv = 'audio';
//        // View Vars
//        $validOrientations = $this->_getMediaOrientations();
//        $genres = (array) $this->_getGenres()->chunk(6)->toArray();
//        $categories = (array) $this->_getCategories()->chunk(6)->toArray();
////        $albums = $this->UserProfiler->getAlbums($this->getActiveUser(), $fileType)->toArray();
////        $playlists = $this->UserProfiler->getPlaylists($this->getActiveUser(), $fileType)->toArray();
//        $privacyOptions = $this->_getPrivacySettings();
//        $monetizationOptions = $this->_getMonetizationOptions();
//        $licenseOptions = $this->_getLicenseOptions();
//        $userSettings = $this->UserProfiler->getSettings();
//        $languages = $this->_getLanguages();
//        $ageRanges = $this->_ageRestriction;
//        $contentClassification = $this->_contentClassifications;
//        $statusList = $this->_statusList;
//        
//        $this->set(compact(
//            'fileType', 
//            'equiv', 
//            'categories',
//            'genres', 
//            'validOrientations', 
//            'privacyOptions', 
//            'monetizationOptions', 
//            'licenseOptions', 
//            'languages', 
//            'userSettings',
//            'ageRanges',
//            'contentClassification',
//            'statusList'
//        ));
//    }
}


