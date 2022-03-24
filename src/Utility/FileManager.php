<?php

namespace App\Utility;

use InvalidArgumentException;
use Laminas\Diactoros\UploadedFile;
use Cake\Utility\Inflector;
use App\Utility\RandomString;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Utility\Security;
use App\Utility\Folder;
use App\Utility\File;

/**
 * FileManager Utility
 */
class FileManager
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];


    protected $_filesAreSuccessful = false;

    protected static $_responseText;

    protected $_filesFailedAtDiskWritePoint = [];

    protected $_filesFailedAtDbSavePoint = [];

    protected $_filesMovedToDisk = [];

    protected $_filesMetaData = [];

    protected $_totalUploadedFiles = 0;

    protected $_user;

    protected $_tableLocator;

    protected $_fileDbTable;

    const FILE_DICTIONARY = array(
            'application/pdf' => 'pdf-file',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'spreadsheet',
            'application/vnd.ms-excel' => 'spreadsheet',
            'application/zip' => 'zip-file',
            'text/plain' => 'text-file',
            'image/jpeg' => 'photo',
            'image/jpg' => 'photo',
            'image/png' => 'photo',
            'video/mpeg4' => 'video',
            'video/mp4' => 'video',
            'video/ogg' => 'video',
            'audio/mpeg3' => 'audio',
            'audio/mp3' => 'audio',
            'audio/ogg' => 'audio'
        );

    protected $_fileToMove;

    const UPLOAD_DIR = WWW_ROOT . 'public-files' . DS;

    public function __construct()
    {
    }

    public static function getFileTypeBasedOnMime($file_mediatype)
    {
        $definition = '';

        if (array_key_exists($file_mediatype, self::FILE_DICTIONARY)) {
            $definition = self::FILE_DICTIONARY[$file_mediatype];
        }

        return $definition;
    }

    public function getFileClientType($fileMime)
    {
        $pcs = explode('/', $fileMime);
        return $pcs[0];
    }

    /**
     * Save multiple files at once
     *
     * @param array $files
     * @param string $targetLocation
     * @param boolean Whether or not to cancel the entire process if anyone fails
     * @return array An associative array representing saved and failed files.
     * However, if $saveOrFail is set to true and no one failed, it will return
     * only an array of arrays of just the saved file(s)
     * Example: [
     *              [saved] => [],
     *              [failed] => []
     *          ]
     */
    public static function saveFiles( array $files, string $targetLocation, bool $saveOrFail = false)
    {
        $failedFiles = $savedFiles = [];

        foreach ( $files as $file )
        {
            $result = self::saveFile($file, $targetLocation);

            if (null !== $result) {
                $savedFiles[] = $result;
            } else {
                $failedFiles[] = $file;
            }
        }

        if (true === $saveOrFail) {
            if (count($failedFiles)) {
                self::deleteAllFiles($savedFiles);
                self::$_responseText = 'One or more files could not be saved';
                return false;
            }
            return $savedFiles;
        }

        return ['saved' => $savedFiles, 'failed' => $failedFiles];
    }

    /**
     * @param $file
     * @param $destination
     * @return array|void|null
     */
    public static function saveFile($file, $destination) {
        $result = null;
        if ($file instanceof UploadedFile) {
            $result = self::_saveAsCakeUploadedFile($file, $destination);
        } else {
            $result = self::_saveAsPHPNativeUploadedFile($file, $destination);
        }

        return $result;
    }

    protected static function _saveAsCakeUploadedFile(UploadedFile $file, string $targetLocation)
    {
        $originalFilename = $file->getClientFilename();
        $mediaType = $file->getClientMediaType(); // mime type
        $filetype = self::getFileTypeBasedOnMime($mediaType); // photo, video, doc etc
        $extension = self::getFileExtension($originalFilename);
        $newFilename = time() . '_' . Security::randomString() . '.' . $extension;
        $destination = $targetLocation;
        if (false === strpos($destination, WWW_ROOT)) {
            $destination = self::UPLOAD_DIR . $destination;
        }
        $destination = str_replace(['\\\\','\\','/','//'], DS, $destination);

        if (!is_dir($destination)) {
            $Folder = New Folder($destination, true, 0755);
            $destination = rtrim($Folder->path, DS);
        }

        $filePath = $destination . DS . $newFilename;
        try {
            $file->moveTo($filePath);
            return [
                'filetype' => $filetype,
                'original_filename' => $originalFilename,
                'file_path' => $filePath,
                'file_mime' => $mediaType
            ];
        } catch (\Exception $exc) {
            return null;
        }
    }

    /**
     * Handle file upload using PHP move_uploaded_file()
     *
     * @param $file
     * @param bool $destination
     */
    protected static function _saveAsPHPNativeUploadedFile($file, $destination = false)
    {
        // Implement PHP native uploading, using move_uploaded_file();
    }

    /**
     * This method checks to identify file fields that have values, and remove
     * one that have not
     * Please Note: That this method works recursively
     *
     * @param array $uploaded_files
     * @return boolean|$this
     */
    public static function getUploadedFiles( $uploaded_files )
    {
        $files = array();
        foreach ( $uploaded_files as $indexOrKey => $arrayOrObject )
        {
            if ( is_array($arrayOrObject) )
            {
                $files = self::getUploadedFiles($arrayOrObject);
            }
            elseif ( $arrayOrObject instanceof \Zend\Diactoros\UploadedFile )
            {
                if ( $arrayOrObject->getClientFilename() != '')
                {
                    is_numeric($indexOrKey)?
                            $files[] = $arrayOrObject :
                    $files[$indexOrKey] = $arrayOrObject;
                }
            }
        }

        return $files;
    }

    public function getLastFilesMetaData()
    {
        return (array) $this->_filesMetaData;
    }

    public function getLastError()
    {

    }

    public function getMessage()
    {
        return $this->_message;
    }

    /**
     *
     * @param array $path
     * @return Folder
     */
    public static function getUploadDir(array $path = null)
    {
        $uploadDir = new Folder(static::UPLOAD_DIR);

        if (!$path || $path === null)
            return $uploadDir;

        $withAddedPath = Folder::addPathElement(trim($uploadDir->path), $path);

        if (is_readable($withAddedPath))
            $uploadDir = new Folder ($withAddedPath);
        else
            $uploadDir = new Folder($withAddedPath, true);

        return $uploadDir;
    }

    /**
     * Get a file extension from the the filename
     *
     * @param string $filename
     * @return string
     */
    public static function getFileExtension(string $filename)
    {
        $parts = explode('.', $filename);
        return array_pop($parts);
    }

    /**
     * Defines a file to move from one location to another
     *
     * @param mixed $file_to_move
     * @return $this
     */
    public function move($file_to_move)
    {
        if (is_array($file_to_move))
            $file_to_move = implode(DS, $file_to_move);
        $this->_fileToMove = $file_to_move;

        return $this;
    }

    /**
     * Executes the file move on the file defined by FileManager::move()
     *
     * @param mixed $targetPath
     * @return boolean|File the path to the new file location
     * @throws Exception
     */
    public function to($targetPath)
    {
        if (is_array($targetPath))
            $targetPath = implode(DS, $targetPath);
        if (! ($this->_fileToMove || file_exists($this->_fileToMove)) )
            throw new Exception('FileManager could not find any file to move');

        $targetDirectory = dirname($targetPath);
        if (! is_dir($targetDirectory) || ! is_writable($targetDirectory)) {
            throw new RuntimeException(sprintf(
                'The target directory `%s` does not exists or is not writable',
                $targetDirectory
            ));
        }

        // For files that were uploaded via HTTP POST
        if (is_uploaded_file($this->_fileToMove)) {
            if (! move_uploaded_file($this->_fileToMove, $targetPath)) {
                return false;
            }

            $File = new File($targetPath);
            return $File;
        }

        $fileToMove = new File($this->_fileToMove);
        try {
            if ($fileToMove->readable()) {
                if ($fileToMove->copy($targetPath)) {
                    $fileToMove->deleteFile();
                    $neFile = new File($targetPath);
                    return $neFile;
                }
                throw new \RuntimeException('Unable to move file; the file is unreadable.');
            }
            throw new \RuntimeException('Unable to move file; the file does not exist.');
        } catch (Exception $ex) {
            $this->_message = $ex->getMessage();
            return false;
        }

        return false;
    }

    /**
     *
     * @param string $file path/to/the/file.txt
     */
    public static function deleteFile(string $file) {

    }

    /**
     *
     * @param array $files List of file paths
     */
    public static function deleteFiles(array $files) {

    }
}
