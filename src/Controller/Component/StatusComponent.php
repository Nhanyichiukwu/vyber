<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use App\Utility\RandomString;

/**
 * Status component
 * 
 * @property \App\Controller\Component\FileManagerComponent $FileManager Handles all file processing
 * @property \App\Controller\Component\CustomStringComponent $CustomString
 */
class StatusComponent extends Component
{
    public $components = ['CustomString','FileManager'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    protected $_isAttachments = false;

    protected $_uploadedFiles = [];
    
    protected $_lastSavedPost;
    
    protected $_usernameRegex = '/^(?=.*[a-z].*[a-z])(?=.*[A-Z].*[A-Z])(?=.*\d.*\d)(?=.*\W.*\W)[a-zA-Z0-9\S]{4,15}$/';
    
    protected $_hashtagRegex = '/^(?=.*[a-z].*[a-z])(?=.*[A-Z].*[A-Z])(?=.*\d.*\d)(?=.*\W.*\W)[a-zA-Z0-9\S]$/';
    
    protected $_message;
    
    protected $_statusText;
    
    protected $_hashtags;
    
    protected $_authorLocation;

    protected $_mentionedUsers;
    
    protected $_privacy;
    
    protected $_contentType = 'post';
    
    protected $PostsTable;
    
    protected $CommentsTable;
    
    public function initialize(array $config) {
        parent::initialize($config);
        
        $tableLocator = $this->getController()->getTableLocator();
        $this->PostsTable = $tableLocator->get('Posts');
        $this->CommentsTable = $tableLocator->get('Comments');
    }


    public function publish()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();
        $response = $controller->getResponse();
        $session = $request->getSession();
        $user = $controller->getActiveUser();
        $post = $this->PostsTable->newEntity();
        
        $statusText = $request->getData('status_text');
        $privacy = $request->getData('privacy');
        $hashtags = (array) $this->extractHashtags($statusText);
        $mentionedUsers = (array) $this->getMentionedUsers($statusText);
        $authorLocation = (string) $request->getData('location');
        $contentType = $request->getData('content_type');
        $originalPostRefid = $request->getData('original_post_refid');
        $originalPostAuthorRefid = $request->getData('original_post_author_refid');
        $isAttachment = $request->getData('is_attachment');
        $fileManager = $this->FileManager;
        $datetime = date('Y-m-d h:i:s');
        $year = date('Y');
        $published = $request->getData('save_as_draft') ? 0 : 1;
        
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
            // Save attachment fisrt, if any, using the FileManager Component
//            if ( $isAttachment ) {
//                $fileData = [
//                    'privacy' => $privacy,
//                    'tags' => $hashtags,
//                    'location' => $authorLocation,
//                    'date' => $datetime
//                ];
//                
//                //$fileManager = $fileManager->processFilesUpload($uploadedFiles);
//                if ( $fileManager->saveFiles($uploadedFiles, $fileData) ) {
//                    $attachmentsMetaData = (array) $fileManager->getLastFilesMetaData();
//                } else {
//                    $message = $fileManager->getMessage();
//                    return false;
//                }
//            }

            // If this function runs upto this point, it means that either there were no files
            // or there were, but no errors were encountered with the files;
            // So we proceed with saving the associated post...
            $refid = RandomString::generateString(20);
            $data = [
                'refid' => $refid,
                'author_refid' => $user->refid,
                'original_author_refid' => $originalPostAuthorRefid,
                'post_text' => $statusText,
                'original_post_refid' => $originalPostRefid,
                'type' => $contentType,
                'tags' => json_encode($hashtags),
                'location' => $authorLocation,
                'privacy' => $privacy,
                'published' => $published,
                'year_published' => $year,
                'date_published' => $datetime,
                'created' => $datetime,
                'modified' => $datetime,
            ];
            
            $post = $this->PostsTable->patchEntity($post, $data);
            
            if ($this->PostsTable->save($post)) 
            {
                $lastSavedPost = $post;
                if ($this->saveAttachment($post)) {
                    // Save the attachment
                    $this->_message = 'Your ' . $contentType . ' was posted successfully.';
                    return true;
                }
            } else {
                $this->_message = 'Sorry, we could not post your ' . $contentType . '.';
            }
        }
    }
    
    public function sharePost(\App\Model\Entity\Post $shared_post)
    {
        $controller = $this->getController();
        $user = $controller->getActiveUser();
        $request = $controller->getRequest();
        
        $origin = $request->getQuery('origin');
        $refid = RandomString::generateString(20);
        $date = date('Y-m-d h:i:s');
//        $sharedPostArray = (array) $shared_post;
//        print_r($sharedPostArray);
//        exit;
        $postData = [
            'refid' => $refid,
            'author_refid' => $user->refid,
            'shared_post_refid' => $shared_post->refid,
            'shared_post_referer' => $origin,
            'type' => $shared_post->type,
            'location' => $controller->getUserCurrentLocation(),
            'privacy' => $controller->getUserContentPrivacy(),
            'created' => $date,
            'modified' => $date
        ];
        
        $post = $this->PostsTable->newEntity($postData);
        if ($this->PostsTable->save($post)) {
            return true;
        }
        return false;
    }


    public function extractHashtags( $source )
    {
        
    }
    
    public function getMentionedUsers( $source )
    {
        
    }
    
    public function getMessage()
    {
        return $message;
    }
}
