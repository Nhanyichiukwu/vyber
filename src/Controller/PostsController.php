<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Post;
use App\Utility\CustomString;
use App\Utility\DateTimeFormatter;
use App\Utility\FileManager;
use App\Utility\RandomString;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Exception;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\PhotosTable $Photos
 * @property \App\Model\Table\MediasTable $Medias
 * @property \App\Model\Table\PostAttachmentsTable $PostAttachments
 *
 * @method \App\Model\Entity\Post[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController
{

    protected $_response = [];

    /**
     *
     * @var \App\Model\Entity\Post
     */
    protected $_post;

    /**
     * @var boolean
     */
    protected $_isSharedPost;


    /**
     * @var \App\Model\Entity\User;
     */
    protected $_author;

    /**
     * @var boolean
     */
    protected $_hasAttachment = false;

    /**
     *
     * @var array
     */
    protected $_uploadedFiles = [];

    /**
     *
     * @var array
     */
    protected $_attachmentAttributes = [];

    /**
     * @var array
     *
     * List of #hashtags used in a given post
     */
    protected $_hashtags;

    /**
     * @var array
     *
     * List of @usernames mentioned in a given post
     */
    protected $_mentionedUsers;

    /**
     * @var string
     */
    protected $_postLocation;

    /**
     * @var boolean
     */
    protected $_isScheduled = false;

    /**
     * @var string
     */
    protected $_scheduledTime;

    /**
     *
     * @var string
     */
    protected $_postText;

    /**
     *
     * @var string
     */
    protected $_postType = 'shoutout';

    /**
     *
     * @var string
     */
    protected $_attachmentType = 'media';

    /**
     *
     * @var string
     */
    protected $_privacy;

    /**
     *
     * @var string refid of the original post
     */
    protected $_originalPost;

    /**
     *
     * @var string
     */
    protected $_originalAuthor;

    /**
     *
     * @var string
     */
    protected $_sharedPost;
    /**
     *
     * @var string refid of the user from who's wall a post is being shared
     */
    protected $_sharedPostReferer;

    /**
     *
     * @var string
     */
    protected $_authorLocation;

    /**
     *
     * @var string timestamp
     */
    protected $_datetime;

    /**
     *
     * @var string
     */
    protected $_status = 'published';

    /**
     *
     * @var array Database transactions that are yet to be committed
     */
    protected $_pendingTransactions = [];


    const UPLOAD_DIR = WWW_ROOT . 'media' . DS;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Posts');
        $this->loadModel('Photos');
        $this->loadModel('Videos');
//        $this->loadModel('Files');
        $this->loadModel('Medias');
        $this->loadModel('PostAttachments');

        $this->Auth->allow(['read']);
    }

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);

//        if ($this->getRequest()->is(['ajax'])) {
//            $this->viewBuilder()->setLayout('ajax');
//        }
    }

    public function beforeRender(EventInterface $event) {
        parent::beforeRender($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $posts = $this->paginate($this->Posts);

        $this->set(compact('posts'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Users', 'Comments']
        ]);

        $this->set('post', $post);
    }

    /**
     * @return \Cake\Http\Response
     */
    public function create()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $composer = $request->getQuery('composer') ?? 'composer';
        $this->viewBuilder()->setTemplate($composer);
        $draft = $this->getLastSavedDraft();

        if ($draft) {
            $this->_post = json_decode($draft->getValue(), false);
        } else {
            $this->_post = $this->Posts->newEmptyEntity();
        }

        $post = $this->_post;
        $status = 'success';
        $message = 'Saved';
        $isAjax = (
            $request->is('ajax') ||
            $request->getQuery('utm_req_w') === 'if'
        );

        if ($isAjax) {
            $this->viewBuilder()->setLayout('ajax');
        }

        if ($request->is(['post','put'])) {
            // Prepares the data sent via the http post
            try {
                $this->preparePost();
            } catch (Exception $e) {
            }

            try {
                if (!$this->savePost()) {
                    // This section could be moved to an event handler function
                    // {
                    $logMessage = __("Status update by user {userid} ({fullname}) failed. Reason: {reason}", [
                        'userid' => $this->_author->refid,
                        'fullname' => $this->_author->fullname,
                        'reason' => serialize($this->_post->getErrors())
                    ]);
                    Log::write('error', $logMessage);
                    // }

                    $status = 'error';
                    $message = __("Sorry, something went wrong while trying "
                        . "to post your {0}. Please try "
                        . "refreshing the page and try again.", $this->_post->type);
                    return $response->withStatus(500, 'Unable to publish post');
                }
            } catch (Exception $e) {
            }
            $post = $this->Posts->get($this->_post->refid);
            $this->viewBuilder()->setTemplate('new_post');

            // An event to make other parts of the application
            // aware of the new post, and as well inform those
            // who matter, that this user has created a new post.
            $event =  new Event('Model.Post.newPost', $this, ['post' => $post]);
            $this->getEventManager()->dispatch($event);
        }

        $this->set(['post' => $post, '_serialize' => 'post']);
    }


    /**
     * Prepares post from
     *
     * @return $this\void\null
     */
    protected function preparePost()
    {
        $request = $this->getRequest();
        if (!$request->getData()) {
            return null;
        }
        $post = (
            null !== $this->_post ? $this->_post : $this->Posts->newEmptyEntity()
        );

        /** Building post **/

        $this->_author = $this->getActiveUser();
        if ($request->getData('uid')) {
            $this->_author = $this->Users->getUser(
                    CustomString::sanitize($request->getData('uid'))
            );
        }

        if ($request->getData('post_text')) {
            $this->_postText = CustomString::sanitize(
                    $this->applyFilters($request->getData('post_text'))
            );
        }
        if ($request->getData('privacy')) {
            $this->_privacy = CustomString::sanitize(
                    $request->getData('privacy')
            );
        }
        if ($request->getData('post_type')) {
            $this->_postType = CustomString::sanitize(
                    $request->getData('post_type')
            );
        }
        if ($request->getData('has_attachment')) {
            $this->_hasAttachment = true;
            $this->_attachmentAttributes =
                (array) $request->getData('attachments_attributes');
        }
        if ($request->getData('attachment_type')) {
            $this->_attachmentType = CustomString::sanitize(
                    $request->getData('attachment_type')
            );
        }
        if ($request->getData('original_post')) {
            $this->_originalPost = CustomString::sanitize(
                    $request->getData('original_post')
            );
        }
        if ($request->getData('original_author')) {
            $this->_originalAuthor = CustomString::sanitize(
                    $request->getData('original_author')
            );
        }
        if ($request->getData('shared_post')) {
            $this->_sharedPost = CustomString::sanitize(
                    $request->getData('shared_post')
            );
        }
        if ($request->getData('shared_post_referer')) {
            $this->_sharedPostReferer = CustomString::sanitize(
                    $request->getData('shared_post_referer')
            );
        }

// If the user sharing his/her location with the post..
        if ($request->getData('location')) {
            $this->_authorLocation = (string) CustomString::sanitize(
                $request->getData('location')
            );
        } elseif (
            $this->_author->allowsLocationOnPosts() &&
            $this->LocationService->getCurrentLocation()
        ) {
            $this->_authorLocation = $this->LocationService->getCurrentLocation();
        }
        // Keep copies of the hashtags and mentions as arrays in different containers
        $this->_hashtags = (array) $this->extractHashtags($this->_postText);
        $this->_mentionedUsers = (array) $this->getMentionedUsers($this->_postText);

        if ($request->getData('status')) {
            $this->_status = CustomString::sanitize($request->getData('status'));
        }
        if ($request->getData('scheduled_time')) {
            $this->_scheduledTime = CustomString::sanitize(
                $request->getData('scheduled_time')
            );
            $this->_isScheduled = true;
        }

        if ($this->_status === 'published') {
            $timezone = $this->GuestsManager->getGuest()->get('timezone');
            $datetime = DateTimeFormatter::getCurrentDateTime($timezone);
            $this->_datetime = $datetime;
        }

        $refid = RandomString::generateUniqueID(function($id) {
            if ($this->Posts->exists(['refid' => $id])) {
                return true;
            }
            return false;
        }, 20, 'numbers');

        $data = [
            'refid' => $refid,
            'author_refid' => $this->_author->refid,
            'original_author_refid' => $this->_originalAuthor ?: $this->_author->refid,
            'post_text' => $this->_postText,
            'original_post_refid' => $this->_originalPost,
            'shared_post_refid' => $this->_sharedPost,
            'shared_post_referer' => $this->_sharedPostReferer,
            'type' => $this->_postType,
            'category' => '',
            'topics' => '',
            'tags' => implode(',', $this->_hashtags),
            'location' => $this->_authorLocation,
            'privacy' => $this->_privacy,
            'status' => $this->_status,
//            'year_published' => $this->_year,
            'date_published' => $this->_datetime,
            'scheduled_time' => $this->_scheduledTime,
            'created' => $this->_datetime,
            'modified' => $this->_datetime,
        ];

        $post = $this->Posts->patchEntity($post, $data);
        $this->_post = $post;
        $this->_uploadedFiles = $request->getUploadedFiles();
        $request = $request->withUploadedFiles([]);
        $request = $request->withParsedBody(null);
        $this->setRequest($request);

        return $this;
    }

    /**
     *
     * @param \App\Model\Entity\Post $post
     * @param boolean $returnTransaction
     * @return \Cake\Database\Connection|boolean
     * @throws Exception
     */
    protected function savePost(Post $post = null)
    {
        if (is_null($post)) {
            $post = $this->_post;
        }

        if ($post->hasErrors()) {
            return false;
        }

        return $this->Posts->getConnection()->transactional(
                        function (Connection $connection) use ($post) {
                    if (!$this->Posts->save($post, ['atomic' => false])) {
                        $connection->rollback();
                        return false;
                    }

                    // Check if the post has attachments and save it all at once
                    if ($this->_hasAttachment) {
                        if (false === $this->saveAttachments()) {
                            $connection->rollback();
                            return false;
                        }
                    }

                    //  If the post is to be scheduled
                    if ($this->_isScheduled && $this->hasAction('_schedule')) {
                        if (!$this->_schedule($post)) { // Should trigger some kind of cron job
                            $this->_response['post_scheduling'] = 'Unable to schedule post';
                        }
                    }

                    // Removing any draft saved during the post composition
                    $this->deleteDraft();
                    $connection->commit();
                    foreach ($this->_pendingTransactions as $tranx) {
                        $tranx->commit();
                    }
                    return true;
                });
    }


    protected function saveAttachments()
    {
        $result = null;
        $saveAttachmentsAsType = 'saveAttachmentsAs' . Inflector::camelize($this->_attachmentType);

        if (!$this->hasAction($saveAttachmentsAsType)) {
            $this->_response['attachment_error'] = __('Unknown attachment processor');
            return false;
        }
        $result = $this->{$saveAttachmentsAsType}();
        if (!is_array($result)) {
            $this->_response['attachment_error'] = __('Unknown attachment processor');
            return false;
        }

        $attachmentEntities = $this->PostAttachments->newEntities($result);
        return $this->PostAttachments->getConnection()
            ->transactional(
                function ($connection) use ($attachmentEntities) {
                if (!$this->PostAttachments->saveMany(
                    $attachmentEntities, ['atomic' => false]
                )) {
                    $connection->rollback();
                    return false;
                }
                $this->_pendingTransactions[] = $connection;
                return true;
            });
    }


    protected function saveAttachmentsAsMedia()
    {
        $uploadedFiles = (array) $this->_uploadedFiles;

        if (!array_key_exists('attachments', $uploadedFiles) || empty($uploadedFiles['attachments'])) {
            throw new Exception('No media found');
        }

        $batchAttachmentsData = [];
        $error = 0;
        // The following container will be populated with values returned from
        // FileManager::saveFile();
        // In case of any failure in a bulk operation, we can undo all all
        // previous files saved in this container
        $savedFiles = [];

        foreach ($uploadedFiles['attachments'] as $uploadedFile) {
            $destination = self::UPLOAD_DIR . Inflector::pluralize(
                            FileManager::getFileTypeBasedOnMime($uploadedFile->getClientMediaType())
            );
            $fileInfo = FileManager::saveFile($uploadedFile, $destination);
            if (false === $fileInfo) {
                $this->_response['file_server_error'] = __('Internal sever error!');
                $error = 1;
                break;
            }
            $savedFiles[] = $fileInfo;

            $saveMediaDetailsInDb = 'save' . Inflector::camelize($fileInfo['filetype']) . 'DetailsInDb';
            if (!$this->hasAction($saveMediaDetailsInDb) ) {
                $this->_response['file_processor_error'] = __('No corresponding file processor found for "{0}".', $fileInfo['filetype']);
                $error = 1;
                break;
            }

            // Set auto commit to false, to force the method to keep the transaction
            // pending until we are satisfied with our checks
            $media = $this->{$saveMediaDetailsInDb}($fileInfo);

            if (!is_object($media)) {
                FileManager::deleteFile($fileInfo['file_path']);
                $this->_response['file_database_error'] = __('Unable to upload {0}', $fileInfo['filetype']);
                $error = 1;
                break;
            }

            $permalink = Router::url('/'. $this->_author->getUsername().'/posts/' . $this->_post->get('refid') . '/' . Inflector::pluralize($fileInfo['filetype']) . '/' . $media->refid, true);
            $batchAttachmentsData[] = [
                'post_refid' => $this->_post->get('refid'),
                'author_refid' => $this->_author->get('refid'),
                'attachment_type' => $fileInfo['filetype'],
                'attachment_refid' => $media->refid,
                'file_path' => substr($fileInfo['file_path'], strlen(self::UPLOAD_DIR)),
                'permalink' => $permalink,
                'created' => $this->_post->get('created'),
                'modified' => $this->_post->get('created'),
            ];
        }

        if ($error > 0) {
            foreach ($savedFiles as $fileDetails) {
                FileManager::deleteFile($fileDetails['file_path']);
            }
            return false;
        }

        return $batchAttachmentsData;
    }

    protected function savePostUrl(callable $callback = null) {

    }

    /**
     *
     * @param array $photoInfo
     * @param boolean $returnTransaction
     * @return boolean
     */
    protected function savePhotoDetailsInDb(array $photoInfo)
    {
        $attachmentAttributes = [];
        if (array_key_exists($photoInfo['original_filename'], $this->_attachmentAttributes)) {
            $attachmentAttributes = $this->_attachmentAttributes[$photoInfo['original_filename']];
        }
        $refid = RandomString::generateUniqueID(function($id) {
            if ($this->Photos->exists(['refid' => $id])) {
                return true;
            }
            return false;
        }, 20, 'mixed');

        $photo = $this->Photos->newEmptyEntity([
            'refid' => $refid,
            'author_refid' => $this->_author->refid,
            'file_path' => substr($photoInfo['file_path'], strlen(self::UPLOAD_DIR)),
            'location' => $this->_postLocation,
            'privacy' => $this->_privacy,
            'tags' => $attachmentAttributes['tags'] ?? '',
            'caption' => $attachmentAttributes['caption'] ?? '',
            'created' => $this->_post->created,
            'modified' => $this->_post->modified
        ]);

        if ($photo->hasErrors()) {
            $this->_response['photo_database_error'] = __('Error saving photo details.');
            return false;
        }
        return $this->Photos->getConnection()->transactional(
                    function($connection) use($photo) {
                if (!$this->Photos->save($photo, ['atomic' => false])) {
                   $connection->rollback();
                   return false;
                }

                $this->_pendingTransactions[] = $connection;
                return $photo;
            });
    }

    protected function saveVideoDetailsInDb(array $videoDetails, $autoCommit = true) {

        $attachmentAttributes = [];
        if (array_key_exists($videoDetails['original_filename'], $this->_attachmentAttributes)) {
            $attachmentAttributes = $this->_attachmentAttributes[$videoDetails['original_filename']];
        }

        $refid = RandomString::generateUniqueID(function() {
            if ($this->Videos->exists(['refid' => $id])) {
                return true;
            }
            return false;
        }, 20, 'mixed');

        $video = $this->Videos->newEmptyEntity([
            'refid' => $refid,
            'description' => $attachmentAttributes['caption'] ?? '',
            'author_refid' => $this->_author->refid,
            'file_path' => substr($videoDetails['file_path'], strlen(MEDIA_DIR)),
            'file_mime_type' => $videoDetails['file_mime'],
            'author_location' => $this->_postLocation,
            'privacy' => $this->_privacy,
            'tags' => $attachmentAttributes['tags'] ?? '',
            'status' => $this->_status,
            'video_type' => 'video',
            'created' => $this->_post->created,
            'modified' => $this->_post->modified
        ]);

        if ($video->hasErrors()) {
            $this->_response['photo_saving'] = __('Error saving photo details.');
            return false;
        }
        try {
            return $this->Videos->getConnection()->transactional(
                    function($connection) use($video, $autoCommit) {
                if ($this->Videos->save($video, ['atomic' => false])) {
                   if ($autoCommit === true)
                       $connection->commit();
                   else
                        $this->_pendingTransactions[] = $connection;
                   return $video;
                }
            });
        } catch (Exception $exc) {
            return false;
        }
    }

    protected function saveDocumentDetailsInDb(array $doc, $returnTransaction = false) {

    }


    /**
     * Creates a new draft in the CakePHP Cookie
     *
     * @return \Cake\Http\Response
     */
    public function saveDraft()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
//        $request->allowMethod(['ajax']);
        $this->viewBuilder()->setLayout('ajax');

        $this->_preparePost();
        $post = $this->_post;
        $jsonPost = json_encode($post->toArray());
        $cookie = $this->_getLastSavedDraft();
        if ($cookie === null) {
            $cookie = new Cookie('Drafts.post');
        }
        $cookie = $cookie->withValue($jsonPost)
                ->withNeverExpire()
                ->withPath('/')
                //->withDomain('')
                ->withSecure(function() {
                    if ($request->scheme() === 'https') {
                        return true;
                    }
                    return false;
                })
                ->withHttpOnly(function() {
                    if ($request->scheme() === 'https') {
                        return true;
                    }
                    return false;
                });

        $response = $response->withCookie($cookie);
        $response = $response->withType('json')
                ->withStringBody('Draft Saved');

        return $response;
    }

    protected function hasDraft() {

        return false;
    }

    /**
     * Removes the previous draft saved either via PHP or JavaScript
     *
     * @param \Cake\Http\Response $response
     * @return $this
     */
    protected function deleteDraft(&$response = null)
    {
        if ($response === null) {
            $response = $this->getResponse();
        }
        $postCookie = $this->getLastSavedDraft();
        if ($postCookie !== null) {
//            $postCookie = $postCookie
//                    ->withName(null)
//                    ->withValue(null);

            $response = $response->withExpiredCookie('Draft.post');
            $this->setResponse($response);
        }

        return $this;
    }

    /**
     * Retrieves the previous draft saved either via PHP or JavaScript
     *
     * @param void
     * @return \Cake\Http\Cookie
     */
    protected function getLastSavedDraft() {
        $cookies = $this->getRequest()->getCookieCollection();
        $cookie = null;
        if ($cookies->has('Drafts_post')) {
            $cookie = $cookies->get('Drafts_post');
        }

        return $cookie;
    }

    protected function schedule($post = null)
    {

    }

    protected function depricated_savePost()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();
        $user = $this->getActiveUser();
        $post = $this->Posts->newEmptyEntity();

        $statusText = $request->getData('post_text') ?? '';
        $privacy = $request->getData('privacy');
        $hashtags = (array) $this->_extractHashtags($statusText);
        $mentionedUsers = (array) $this->_getMentionedUsers($statusText);
        $authorLocation = (string) $this->identifyUserLocation() ? $this->getUserLocation(['country','region']) : $request->getData('location');
        $contentType = $request->getData('post_type');
        $originalPost = $request->getData('original_post');
        $originalAuthor = $request->getData('original_post_author');
        $sharedPost = $request->getData('shared_post') ?? '';
        $sharedPostReferer = $request->getData('shared_post_referer') ?? '';
        $isAttachment = $request->getData('is_attachment');
        $fileManager = $this->FileManager;
        $datetime = date('Y-m-d h:i:s');
        $year = date('Y');
        $published = (int) $request->getData('is_draft') ? 0 : 1;

        // Checking if any file was uploaded
        // This is necessary because, by default the form, when submitted, comes
        // with all file input fields, most of which will certainly be empty
        // Therefore we use this approach to extract and process only the field
        // that actually has a value.
        $uploadedFiles = $fileManager->getUploadedFiles($request->getUploadedFiles());
//        if ( count($uploadedFiles) )
//        {
//            $isAttachments = true;
//            $totalUploadedFiles = count($uploadedFiles);
//        }

        if (empty($statusText) && ! $isAttachment)
        {
            $message = 'Please type a status or upload a file...';
            return false;
        }
        else
        {
            // If this function runs upto this point, it means that either there were no files
            // or there were, but no errors were encountered with the files;
            // So we proceed with saving the associated post...
            $refid = RandomString::generateUniqueID(function(){return false;}, 20);
            $data = [
                'refid' => $refid,
                'author_refid' => $user->refid,
                'original_author_refid' => $originalAuthor,
                'post_text' => $statusText,
                'original_post_refid' => $originalPost,
                'shared_post_refid' => $sharedPost,
                'shared_post_referer' => $sharedPostReferer,
                'type' => $contentType,
                'tags' => json_encode($hashtags),
                'location' => $authorLocation,
                'privacy' => $privacy,
                'status' => $published,
                'year_published' => $year,
                'date_published' => $datetime,
                'created' => $datetime,
                'modified' => $datetime,
            ];

            $post = $this->Posts->patchEntity($post, $data);
            $isOK = true;
            $this->Posts->getConnection()->transactional(function ($connection) use ($post, &$isOK) {

                // If the database operation tests OK, then we proceed with
                // moving the file to the appropriate destination
                // And if that fails, we rollback all operations
                if ($this->Posts->save($post, ['atomic' => false])) {
                    if ($this->_hasAttachment) {
                        try {
                            $this->_saveAttachment($post);
                        } catch (Exception $exc) {
                            $exc->getTraceAsString();
                            $isOK = false;
                        }
                    }


                    // If the script runs upto this point, it means there
                    // was no error in the file transfer
                    $connection->commit();
                } else {
                    $isOK = false;
                }
            });

            if ($isOK)
            {
                $this->_response = __('{content} posted successfully...', ['content' => $post->type]);
            } else {
                $this->_response = __('Sorry, we could not post your {content}.', ['content' => $post->type]);
            }
        }

        return $this;
    }


    protected function extractHashtags( $source )
    {
        $hashtags = [];
        $source = strip_tags($source);
        $words = explode(' ', $source);
        foreach ($words as $word) {
            if (substr($word, 0, 1) === '#') {
                $hashtags[] = $word;
            }
        }

        return $hashtags;
    }

    protected function getMentionedUsers( $source )
    {
        $usernames = [];
        $source = strip_tags($source);
        $words = explode(' ', $source);
        foreach ($words as $word) {
            if (substr($word, 0, 1) === '@') {
                $usernames[] = $word;
            }
        }

        return $usernames;
    }


    /**
     * Save post with attachments
     *
     * @version Beta
     * @return boolean
     */
    protected function savePostWithAttachment()
    {
        $isOK = true;
        $transactions = [];
        $attachments = $this->getRequest()->getUploadedFiles();

        // Let's first try saving the post to ensure that everything is alright
        // on that side
        $postTransaction = $this->_savePost($this->_post, true);
        // 'true' will force it to delay the final execution of the query, and enable us to handle it manually

        if (false  === $postTransaction) {
            $isOK = false;
        } else {
            $attachments = FileManager::saveFiles($attachments['attachments'], [], $this->_author);
            if (count($attachments['failed'])) {
                FileManager::delete($attachments['saved']);
                $isOK = false;
            } else {
                $savedAttachments = $attachments['saved'];
                $batchAttachmentsData = [];
                foreach ($savedAttachments as $attachment) {
                    try {
                        $fileProcessor = '_' . $attachment['filetype'];
                        if ($this->hasAction($fileProcessor)) {
                            $transactions[] = $this->{$fileProcessor}($attachment, true);
                            // True forces the operation to be transactional, in order
                            // to enable us manually commit all when no errors are
                            // encountered
                            $data = [
                                'post_refid' => $this->_post->get('refid'),
                                'author_refid' => $this->_author->get('refid'),
                                'attachment_type' => $attachment['filetype'],
                                'attachment_permalink' => $attachment['permalink'],
                                'created' => $this->_post->get('created'),
                                'modified' => $this->_post->get('created'),
                            ];
                            $batchAttachmentsData[] = $data;
                        } else {
                            $isOK = false;
                            break;
                        }
                    } catch (Exception $exc) {
                        $isOK = false;
                    }
                }

                if ($isOK && count($transactions)) {
                    $attachmentTranx = null;
                    $attachmentEntities = $this->PostAttachments
                            ->newEntities($batchAttachmentsData);
                    $this->PostAttachments->getConnection()->transactional(
                            function ($connection)
                            use ($attachmentEntities, &$isOK, &$attachmentTranx) {
                        if ($this->PostAttachments
                                ->save($attachmentEntities , ['atomic' => false])) {
                            $attachmentTranx = $connection;
                        } else {
                            $isOK = false;
                        }
                    });

                    if ($isOK && $attachmentTranx !== null) {
                        // Here is the last operation
                        // Every committment should be made at this point,
                        // given that all is well
                        $postTransaction->commit();
                        foreach ($transactions as $fileTranx) {
                            $fileTranx->commit();
                        }
                        $attachmentTranx->commit();
                    }
                }
            }
        }

        return $isOK;
    }

    /**
     * Alias of the save post with attachments method
     * @version Beta
     * @return boolean
     */
    protected function savePostWithAttachments()
    {
        $autoCommit = false;
        if (false === $this->_savePost(null, $autoCommit)) {
            return false;
        }

        $saveAttachments = '_savePost' . Inflector::camelize($this->_attachmentType);
        if (!$this->hasAction($saveAttachments)) {
            return false;
        }
        $result = $this->{$saveAttachments}($autoCommit);
        if (is_array($result)) {
            $attachmentEntities = $this->PostAttachments->newEntities($result);
//            $attachmentEntities = $this->PostAttachments->patchEntities($attachmentEntities, );
//            pr($attachmentEntities);
//            exit;
            return $this->PostAttachments->getConnection()->transactional(
                function ($connection)
                use ($attachmentEntities) {
                if ($this->PostAttachments->saveMany($attachmentEntities , ['atomic' => false])) {
                    // Here is the last operation
                    // Every committment should be made at this point,
                    // given that all is well
                    foreach ($this->_pendingTransactions as $transaction) {
                        $transaction->commit();
                    }

                    return true;
                }

                return false;
            });
        }
    }

    protected function savePostMedia_beta($autoCommitDbTransaction = true)
    {
        $request = $this->getRequest();
        $uploadedFiles = $request->getUploadedFiles();
        if (!count($uploadedFiles)) {
            throw new Exception('No attachments found');
        }

        $batchAttachmentsData = [];
        $destination = $this->_author->refid;

        $saveOrFail = true;
        $processed = FileManager::saveFiles($uploadedFiles['attachments'], $destination, $saveOrFail);

        if (false === $processed) {
            return false;
        }
        $error = 0;
        foreach ($processed as $fileInfo) {
            $_saveMediaDetailsInDb = '_save' . Inflector::camelize($fileInfo['filetype']) . 'DetailsInDb';
            if ( !$this->hasAction($_saveMediaDetailsInDb) ) {
                $this->_response['file_error'] = __('No corresponding file processor found for "{0}".', $fileInfo['filetype']);
                $error += 1;
                break;
            }

            // Set auto commit to false, to force the method to keep the transaction
            // pending until we are satisfied with our checks
            $media = $this->{$_saveMediaDetailsInDb}($fileInfo, $autoCommitDbTransaction);
            if (false !== $media) {
                $permalink = Router::url('/e/'.$this->_author->getUsername().'/posts/' . $this->_post->get('refid') . '/' . Inflector::pluralize($fileInfo['filetype']) . '/' . $media->refid, true);
                $batchAttachmentsData[] = [
                    'post_refid' => $this->_post->get('refid'),
                    'author_refid' => $this->_author->get('refid'),
                    'attachment_type' => $fileInfo['filetype'],
                    'attachment_refid' => $media->refid,
                    'file_path' => $fileInfo['relative_path'],
                    'permalink' => $permalink,
                    'created' => $this->_post->get('created'),
                    'modified' => $this->_post->get('created'),
                ];
            } else {
                FileManager::delete($fileInfo['file_path']);
                $this->_response['file_error'] = __('Unable to upload {0}', $fileInfo['filetype']);
                $error += 1;
                break;
            }
        }
        if ($error > 0) {
            return false;
        }

        return $batchAttachmentsData;
    }


    protected function useAjax()
    {
        $response = $this->getResponse();
        $response = $response->withType('json');
        $msg = [];
        $responseCode = 404;

        if ( !$this->Status->post()) {
            $msg = [
                'message' => $this->Status->getError() . ' ' . $this->Status->getAttachmentsError()
            ];
            $responseCode = 304;
        } else {
            $msg = [
                'message' => $this->Status->getError() . ' ' . $this->Status->getAttachmentsError()
            ];
            $responseCode = 200;
        }

        $json_str = json_encode($msg);
        $response = $response
                ->withStatus($responseCode, $msg['message'])
                ->withStringBody($json_str);

        return $response;
    }

    protected function useDefault()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        if ( !$this->Status->post() )
            $this->Flash->error(__($this->Status->getMessage()));
        else
            $this->Flash->success(__($this->Status->getMessage()));

        return $this->redirect($request->referer(true));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEmptyEntity();
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $users = $this->Posts->Users->find('list', ['limit' => 200]);
        $this->set(compact('post', 'users'));
    }

    public function read($username, $postID)
    {
        $request = $this->getRequest();
        if ($request->is('ajax') ||
            $request->getQuery('ref') === 'container') {
            $this->viewBuilder()->setLayout('blank');
        }
        try {
            $username = $this->Users->getUser($username);
            $post = $this->Posts->get($postID);
        } catch (RecordNotFoundException $recordError) {
            return null;
        }

        $this->set(['post' => $post, '_serialize' => 'post']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($refid = null)
    {
        try {
            $post = $this->Posts->get($refid, [
                'contain' => ['Authors' => ['Profiles']],
                'conditions' => ['author_refid' => $this->getActiveUser()->refid]
            ]);
        } catch(RecordNotFoundException $exc) {
            $this->Flash->warning(__('Warning: The post does not exist or you have no right to perform this action.'));
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $authors = $this->Posts->Authors->find('list', ['limit' => 200]);

        $this->set(compact('post', 'authors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function _addComment($username, $post_refid)
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $this->viewBuilder()->setTemplate('add_comment');

        $draft = $this->getLastSavedDraft();
        if ($draft) {
            $this->_post = json_decode($draft->getValue(), false);
        } else {
            $this->_post = $this->Posts->newEmptyEntity();
        }

        $comment = $this->_post;
        $isAjax = ($request->is('ajax') || $request->getQuery('utm_req_w') === 'if');
        if ($isAjax) {
            $this->viewBuilder()->setLayout('ajax');
        }

        if ($request->is(['post','put'])) {
            // Prepares the data sent via the http post
            $this->preparePost();

            $status = 'success';
            $message = 'Saved';

            if (!$this->savePost()) {
                // This section could be moved to an event handler function
                // {
                $logMessage = __("Status update by user {userid} ({fullname}) failed. Reason: {reason}", [
                        'userid' => $this->_author->refid,
                        'fullname' => $this->_author->fullname,
                        'reason' => json_encode($this->_post->getErrors())
                    ]);
                Log::write('error', $logMessage);
                // }

                $status = 'error';
                $message = __("Sorry, something went wrong while trying "
                        . "to post your {0}. Please try "
                        . "refreshing the page and try again.", $this->_post->type);
                return $response->withStatus(500, 'Unable to publish post');
            }
            $comment = $this->Posts->get($this->_post->refid);
            $this->viewBuilder()->setTemplate('new_post');

            // An event to make other parts of the application
            // aware of the new post, and as well inform those
            // who matter, that this user has created a new post.
            $event =  new Event('Model.Post.newPost', $this, ['comment' => $comment]);
            $this->getEventManager()->dispatch($event);
        }
    }

//    public function _addComment($username, $refid)
//    {
//        $request = $this->getRequest();
//        try {
//            $author = $this->Users->getUser($username);
//            $post = $this->Posts->get($refid, ['Posts.author_refid' => $author->get('refid')]);
//        } catch (Exception $exc) {
//            throw new NotFoundException();
//        }
//        $actor = $this->getActiveUser();
//        $comment = $this->Posts->newEmptyEntity();
//
//        if ($request->is(['post','put'])) {
//
//        // Checks if the comment is sent as reply to another comment
//        // If so, then we verify the existence of the target comment
//            $replyTo = $request->getQuery('reply_to');
//            if ($replyTo !== null) {
//                try {
//                    $comment = $this->Posts->get($replyTo);
//                } catch (Exception $ex) {
//                    // Set a proper error response here...
//                }
//            }
//            if ($comment->isEmpty('refid')) {
//                $replyTo = $post->get('refid');
//            }
//            $type = 'comment';
//            if ($comment->get('type') === 'comment') {
//                $type = 'reply';
//            }
//            $this->_preparePost();
//            $this->_post->set([
//                'type' => $type,
//                'replying_to' => $replyTo,
//                'author_refid' => $actor->get('refid'),
//                'original_author_refid' => $actor->get('refid')
//            ]);
//
//
//
//            if ($isOK) {
//                $comment = $this->Posts->get($this->_post->refid, ['Posts.type' => $type]);
//
//                // An event to make other parts of the application
//                // aware of the new post, and as well inform those
//                // who matter, that this user has created a new post.
//                $event =  new Event("Model.Post.new{$type}", $this, ["$type" => $comment]);
//                $this->getEventManager()->dispatch($event);
//            } elseif($isAjax) {
//                $this->setResponse($this->getResponse()->withStatus(500, 'error'));
//            }
//
//            if (!$request->is('ajax')) {
//                $here = $request->getAttribute('here');
//                $splitPath = explode('/', $here);
//                array_pop($splitPath);
//                $path = implode('/', $splitPath);
//                $response = $this->getResponse();
//                $response = $response->withAddedHeader('X-Last-Comment-ID', $this->_post->get('refid'));
//                return $this->redirect($path);
//            }
//
//            $this->viewBuilder()->setTemplate('new_comment');
//        }
//
//        $this->set(['post' => $post, 'comment' => $comment, '_serialize' => ['post','comment']]);
//    }


    public function addComment($username, $refid)
    {
        $request = $this->getRequest();
        try {
            $rootThreadAuthor = $this->Users->getUser($username);
            $rootThread = $this->Posts->get($refid, ['Posts.author_refid' => $rootThreadAuthor->refid]);
        } catch (RecordNotFoundException $recordError) {
            throw new NotFoundException();
        } catch (Exception $exc) {
            throw new NotFoundException();
        }

        // The logged user who wants to comment/reply to the post/comment
        $actor = $this->getActiveUser();

        // An anstance of the comment
        $comment = $this->Posts->newEmptyEntity();

        // In a case where the refid provided in reply_to is does not match
        // any record, or there was none provided, the post will be used as
        // the target.
        // In that case, the comment will be attributed to the post itself.
        $targetOrComment = $rootThread;

        // Refid of the target post/comment
        $replyTo = $request->getQuery('reply_to');
        if ($replyTo !== null) {
            try {
                $targetOrComment = $this->Posts->get($replyTo);
            } catch (RecordNotFoundException $recordError) {
                // Set a proper error response here...
            } catch (Exception $unknownError) {
                //
            }
        }

        $type = 'comment';
        if ($targetOrComment->type === 'comment') {
            $type = 'reply';
        }

        if ($request->is(['post','put'])) {
            $this->preparePost();
            $this->_post->set([
                'type' => $type,
                'replying_to' => $targetOrComment->refid,
                'author_refid' => $actor->get('refid'),
                'original_author_refid' => $actor->get('refid')
            ]);
            if (!$this->savePost()) {
                // This section could be moved to an event handler function
                // {
                $logMessage = __("User {userid} ({fullname}'s) {type} on {author_name}'s {post_type} failed. Reason: {reason}", [
                        'userid' => $actor->refid,
                        'fullname' => $actor->getFullname(),
                        'type' => $type,
                        'author_name' => $author->getFullname(),
                        'post_type' => $targetOrComment->type,
                        'reason' => json_encode($this->_post->getErrors())
                    ]);
                Log::write('error', $logMessage);
                // }

                return $response->withStatus(500, __('Unable to publish {type}.', ['type' => $type]));
            }
            $this->viewBuilder()->setTemplate('new_comment');

            $comment = $this->Posts->get($this->_post->refid, ['Posts.type' => $type]);

            // An event to make other parts of the application
            // aware of the new post, and as well inform those
            // who matter, that this user has created a new post.
            $event =  new Event("Model.Post.new{$type}", $this, ["$type" => $comment]);
            $this->getEventManager()->dispatch($event);


//            if (!$request->is('ajax')) {
//                $here = $request->getAttribute('here');
//                $splitPath = explode('/', $here);
//                array_pop($splitPath);
//                $path = implode('/', $splitPath);
//                $response = $this->getResponse();
//                $response = $response->withAddedHeader('X-Last-Comment-ID', $this->_post->get('refid'));
//                return $this->redirect($path);
//            }

            $this->viewBuilder()->setTemplate('new_comment');
        }

        $this->set([
            'rootThread' => $rootThread,
            'comment' => $comment,
            '_serialize' => ['rootThread', 'comment']
        ]);
    }

    public function comments($username, $postID) {
        try {
            $post = $this->Posts->get($postID);
        } catch (RecordNotFoundException $exc) {
            if (Configure::read('debug')) {
                echo $exc->getTraceAsString();
            } else {
                throw new NotFoundException();
            }

        }
        $comments = $this->Posts->getDescendants($post->refid);
//        $this->viewBuilder()->setTemplate('comments');
        $this->set(compact('comments','post'));
    }

    /**
     * @param $username
     * @param $postID
     * @param $commentID
     * @return |null
     * @throws NotFoundException
     */
    public function readComment($username, $postID, $commentID) {
//        $this->viewBuilder()->setTemplate('read');
        // Make sure that the post exists
        try {
            $post = $this->Posts->get($postID);
        } catch (RecordNotFoundException $exc) {
            if (Configure::read('debug')) {
                echo $exc->getTraceAsString();
            } else {
                throw new NotFoundException();
            }
        }

        $this->setAction('read', [$username, $commentID]);
        return($this->read($username, $commentID));
    }

    public function reactions($username, $postID)
    {
        try {
            $post = $this->Posts->get($postID);
        } catch (RecordNotFoundException $exc) {
            if (Configure::read('debug')) {
                echo $exc->getTraceAsString();
            } else {
                throw new NotFoundException();
            }
        }

        $reactions = $this->PostReactions->find('for', [
            'post' => $post->get('refid')
        ])->toArray();

        $this->set(compact('username','post','reactions'));
    }

    public function followers($username, $postID)
    {
        try {
            $post = $this->Posts->get($postID);
        } catch (RecordNotFoundException $exc) {
            if (Configure::read('debug')) {
                echo $exc->getTraceAsString();
            } else {
                throw new NotFoundException();
            }
        }

        $this->set(compact('username','post'));
    }
    protected function applyFilters($postText) {
        $text = str_replace('\&nbsp;', ' ', $postText);
        $text = str_replace('\&amp;', ' ', $text);
        $text = str_replace('&amp;nbsp;', ' ', $text);
        $text = strip_tags($text, '<a></a> <strong></strong> <em></em> <span></span>');

        return $text;
    }
}

