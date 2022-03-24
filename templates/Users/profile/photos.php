<?php

use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Routing\Router;
use App\Utility\RandomString;

/*
 * Photos
 */
$this->extend('common');
?>
<?php if (isset($photos) && count($photos)): ?>
<div class="col-12">
    <?php foreach ($photos as $album => $items): ?>
    <div class="album-title">
        <div class="section-header">
            <h3 class="section-title album-<?= $album->get('slug') ?>"><?= __('{title}', ['title' => $album->get('title')]); ?></h3>
        </div>
    </div>
    <div class="row gutters-sm">
        <div class="col"><?= $this->Paginator->sort('author_refid') ?></div>
        <div class="col"><?= $this->Paginator->sort('has_attachment') ?></div>
        <div class="col"><?= $this->Paginator->sort('privacy') ?></div>
        <div class="col"><?= $this->Paginator->sort('created') ?></div>
        <div class="col"><?= __('Actions') ?></div>
    </div>
    <div class="gallery gallery-grid has-caption gap-0 row">
        <?php foreach ($items as $photo): ?>
        <div class="col-6 col-sm-3 px-1">
            <?php
                $dataSrc = 'photo/'.$photo->get('refid') . '?token=' . base64_encode(Security::randomString() . '_'. $account->get('refid') . time());
            ?>
            <div class="_kG2vdB" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="photo<?= $photo->get('id') ?>" data-su="false" data-limit="1" data-r-ind="false" id="photo<?= $photo->get('id') ?>"></div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
