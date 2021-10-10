<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Utility\File;
use Cake\View\Helper;
use Cake\View\View;

/**
 * MediaResolver helper
 */
class MediaResolverHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function resolveProfileImage(string $path = null)
    {
        $default = 'img/profile-photos/img_avatar.png';

    }

    public function resolveProfileHeaderImage($path)
    {
        $default = WWW_ROOT . str_replace(
            '/',
            DS,
            'img/profile-headers/entertainer_profile_cover_image_915x240.jpg'
            );
        if (is_array($path)) {
            $path = implode(DS, $path);
        }
        if ($path === null) {
            $path = $default;
        }
        $imgPath = WWW_ROOT . str_replace('/', DS, $path);
        $file = new File($imgPath);
        if (!$file->exists()) {
            $file = new File($default);
        }
        $stream = $file->read();
        $encoded = base64_encode($stream);
        $dataUri = 'data:image/image/jpeg;base64,' . $encoded;
        return $dataUri;
    }

    public function resolvePostMedia(string $path = null)
    {

    }
}
