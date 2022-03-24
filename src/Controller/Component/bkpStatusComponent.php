<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Status component
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

    protected $_postHasAttachments = false;

    protected $_postAttachments = [];

    protected $_totalAttachments = 0;

    protected $_postIsSuccessful = false;

    protected $_lastSavedPost;

    protected $_postError;

    protected $_attachmentsAreSuccessful = false;

    protected $_attachmentsError;

    protected $_attachmentsFailedAtDiskWritePoint = [];

    protected $_attachmentsFailedAtDbSavePoint = [];

    protected $_attachmentsMovedToDisk = [];


        const UPLOAD_DIR = WWW_ROOT . 'public-files/';

    public function post()
    {
        $post = $this->Posts->newEntity();
        $controller = $controller->getController();
        $request = $controller->getRequest();
        $response = $controller->getResponse();
        $session = $request->getSession();
        $user = $controller->getActiveUser();

        $statusText = $request->getData('status_text');
        $uploadedFiles = $request->getUploadedFiles();

        if (array_key_exists('attachments', $uploadedFiles))
        {
            $this->_postAttachments = (array) $uploadedFiles['attachments'];
            $this->_postHasAttachments = true;
            $this->_totalAttachments = count($this->_postAttachments);
        }

        if (empty($statusText) && !$this->_postHasAttachments)
        {
            $this->_postError = 'Please type a status or upload a file...';
            return false;
        }
        else
        {
            // Save attachment fisrt, if any, using the FileManager Component
            if ($this->_postHasAttachments) {
                if ( ! $this->FileManager->saveUploadedFiles($uploadedFiles) ) {
                    $this->_attachmentsError = $this->FileManager->getLastError();
                    return false;
                }
            }

            if ( ! $this->_attachmentsError )
            {
                if ($this->Posts->save($post))
                {
                    $this->_lastSavedPost = (object) $post;
                    if ($this->_postHasAttachments)
                    {
                        if (!$this->_savePostAttachments())
                        {
                            // Remove the files from both database and webdisk
                            $this->PostAttachments->deleteAll(['refid' => $post->author_refid]);
                            foreach ($this->_attachmentsMovedToDisk as $movedFile) {
                                $file = new File($movedFile);
                                if ($file->exists())
                                    $file->delete();
                            }

                            // Remove the just saved post
                            $this->Posts->delete($post);

                            //$this->_attachmentsError = 'Sorry, could not upload one or more file(s)';
//                            if ($isAjax) {
//                                $response = $response->withStringBody('Sorry, could not upload none or more file(s)');
//                                $response = $response->withStatus('500');
//
//                                return $response;
//                            }
                            return false;
                        }
                    }

                    $this->_postIsSuccessful = true;

                    return true;
                }
            }

            $refid = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
            $hasAttach = $this->_postHasAttachments ? '1' : '0';
            $datetime = date('Y-m-d h:i:s');
            $postData = [
                'refid' => $refid,
                'author_id' => $user->refid,
                'post_text' => $statusText,
                'has_attachment' => $hasAttach,
                'created' => $datetime,
                'modified' => $datetime
            ];
//            $post = $this->Posts->patchEntity($post, $postData);
//            // Prevent multiple entry attempt aresubmission
//            if ($this->Posts->exists(['OR' => ['author_refid' => $post->author_refid, 'post_text' => $post->post_text]]))
//            {
//                $this->_postError = 'Sorry. But you already posted that...';
//                return false;
//            }
//            else
//            {
//
//
//            }
        }
    }

    private function _savePostAttachments ()
    {
        $AttachmentTbl = $this->PostAttachments;
        $post = $this->_lastSavedPost;

        foreach ( $this->_postAttachments as $attachment )
        {
            $fileFilename = $attachment->getClientFilename();
            $fileMediaType = $attachment->getClientMediaType();
            $fileFiletype = $this->FileLib->getDefinition($fileMediaType);

            $fileFilenameSplit = explode('.', $fileFilename);
            $ext = end($fileFilenameSplit);

            $fileName = time() . '_' .  $this->CustomString->generateRandom(32) . '.' . $ext;
            $fileFinalDestination = static::UPLOAD_DIR . $user->refid . '/' . $fileFiletype . 's/';

            if (!is_dir($fileFinalDestination)) {
                $Folder = New Folder($fileFinalDestination, true, 0755);
                $fileFinalDestination = $Folder->path;
            }

            $fileFinalDestination = rtrim($fileFinalDestination, '/') . '/' . $fileName;
            //$fileUrl = static::UPLOAD_DIR . $user->refid . '/' . $fileFiletype . '/' . $fileName;
            $fileUrl = explode('/', $fileFinalDestination);
            array_shift($fileUrl);
            $fileUrl = trim(implode('/', $fileUrl), '/');

            $attachmentData = [
                'attachment_id' => $this->CustomString->generateRandom(20, ['type' => 'numbers']),
                'refid' => $post->author_refid,
                'refid' => $user->refid,
                'attachment_url' => $fileUrl,
                'attachment_type' => $fileFiletype,
                'created' => $datetime,
                'modified' => $datetime
            ];

            $postAttachment = $AttachmentTbl->newEntity($attachmentData);

            if ( ! $AttachmentTbl->save($postAttachment) ) {
                $this->_attachmentsFailedAtDbSavePoint[] = $fileFilename;
                return false;
            } elseif ( ! $attachment->moveTo($fileFinalDestination)) {
                $this->_attachmentsFailedAtDiskWritePoint[] = $fileFinalDestination;
                return false;
            } else {
                $this->_attachmentsMovedToDisk[] = $fileFinalDestination;
                $this->_attachmentsSavedToDb[] = $postAttachment;
            }
        }

        if ( $this->_totalAttachments ===
                (count($this->_attachmentsSavedToDb) && count($this->_attachmentsMovedToDisk)) )
        {
            return true;
        }
    }

    public function getPostError()
    {
        return $this->_postError;
    }

    public function getAttachmentError()
    {
        return $this->_attachmentsError;
    }

    public function getAttachmentsFailedAtSavepoint()
    {
        return $this->_attachmentsFailedAtDbSavePoint;
    }

    public function getAttachmentsFailedAtDiskWrite()
    {
        return $this->_attachmentsFailedAtDiskWritePoint;
    }
}
