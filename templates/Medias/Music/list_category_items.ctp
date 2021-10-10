<?php
/**
 * @var App\View\AppView $this
 */

$this->extend('common');

use Cake\Routing\Router; ?>

<?php $this->start('header'); ?>
    <div class="page-header">
        <h2 class="page-title"><?= h($category->name) ?> <?= ucfirst(h($category->type)) ?></h2>
    </div>
<?php $this->end(); ?>
<div class="<?= h($category->slug) ?>-<?= h($category->type) ?>"
     data-title="<?= h($category->name) ?>"
     role="list"
     data-role="Category Items"
     data-content="<?= h($category->type) ?>">
    <div class="row">
        <?php foreach ($categoryItems as $categoryItem): ?>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card <?= h($categoryItem->item_type) ?>-card">
                    <div class="<?= h($categoryItem->item_type) ?>-card-image">
                        <a class="play-icon" href="https://askbootstrap.com/preview/vidoe-v1-1/theme-four/single-channel.html#"><i class="fas fa-play-circle"></i></a>
                        <a href="https://askbootstrap.com/preview/vidoe-v1-1/theme-four/single-channel.html#"><img class="img-fluid" src="./VIDOE - Video Streaming Website HTML single-channel_files/v1.png" alt=""></a>
                        <div class="time">3:50</div>
                    </div>
                    <div class="<?= h($categoryItem->item_type) ?>-card-body">
                        <div class="<?= h($categoryItem->item_type) ?>-title">
                            <a href="https://askbootstrap.com/preview/vidoe-v1-1/theme-four/single-channel.html#">There are many variations of passages of Lorem</a>
                        </div>
                        <div class="<?= h($categoryItem->item_type) ?>-page text-success">
                            Education  <a title="" data-placement="top" data-toggle="tooltip" href="https://askbootstrap.com/preview/vidoe-v1-1/theme-four/single-channel.html#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                        </div>
                        <div class="<?= h($categoryItem->item_type) ?>-view">
                            1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
