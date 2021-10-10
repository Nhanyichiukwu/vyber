<?php

/**
 *
 */
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
?>

<div class="LkYB profile-card">
    <div class="SKgK LkA card card-profile">
        <?php
            $imgPath = WWW_ROOT . str_replace('/', DS, 'img/profile-headers/entertainer_profile_cover_image_915x240.jpg');
            $file = new File($imgPath, false);
            //pr(get_class_methods($file));
            //$stream = $file->read();
            //$encoded = base64_encode($stream);
            $basename = $file->info()['basename'];
            $filename = substr($basename, 0, strrpos($basename, '.'));
            $dataUri = $this->Url->assetUrl('/media/' . $filename . '?type=photo&role=profile_header&format=' . $file->ext());

            ?>
        <div class="h_16ro">
            <div class="_3PpE _XZA1 _ibW2U7 _kx7 _poYC _v6nr border o-hidden card-img-top" style="background-image: url(<?=
            $dataUri ?>)">
                            <?= $this->Html->image('/media/' . $filename . '?type=photo&role=profile_header&format='
                                . $file->ext(), ['class' => 'media _Aqj']); ?>
            </div>
        </div>
        <div class="bQ3 card-body">
            <div class="mb-3 mt-n5 text-center">
                <span class="avatar avatar-xxl"  style="background-image: url(/media/iohfh?type=photo&role=profile_photo&format=jpg)"></span>
            </div>
            <h4 class="mb-3"><?= __('{fullname}', ['fullname' => h($connection->getFullname())]) ?></h4>
        </div>
    </div>
</div>

