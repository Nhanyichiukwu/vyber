<?php

use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Routing\Router;
use App\Utility\RandomString;

/* 
 * Photos
 */

?>
<?php if (isset($albums) && $albums): ?>
<div class="col-12">
    <?php foreach ($albumGroups as $mediaType => $albums): ?>
    <div class="album-title">
        <div class="section-header">
            <h3 class="section-title <?= strtolower($mediaType) ?>"><?= __('{type}', ['type' => strtoupper($mediaType)]); ?></h3>
        </div>
    </div>
    <div class="gallery gallery-grid has-caption gap-0 row">
        <?php foreach ($albums as $album): ?>
        <div class="col-6 col-sm-3 px-1">
            <?php
                $dataSrc = 'album/'.$album->get('refid') . '?token=' . base64_encode(Security::randomString() . '_'. $account->get('refid') . time());
            ?>
            <div class="_kG2vdB" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="album<?= $photo->get('id') ?>" data-su="false" data-limit="1" data-r-ind="false" id="album<?= $album->get('id') ?>"></div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>