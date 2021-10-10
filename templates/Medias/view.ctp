<?php

use Cake\Utility\Inflector;
use Cake\Utility\Text;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Media $media
 */

$mc = $media->get('classification');
$mcUnderscored = Inflector::underscore($mc);
$mcCapitalized = Inflector::humanize($mc);
$mcPlural = Inflector::pluralize($mc);
$mcPluralUnderscored = Inflector::underscore($mcPlural);
$mcPluralCapitalized = Inflector::humanize($mcPlural);
$equiv = $media->media_type === 'audio' ? 'video' : 'audio';
?>
<nav class="navbar bg-white navbar-top" id="actions-sidebar">
    <ul class="nav ml-auto">
        <li class="nav-item"><?= $this->Html->link(__('Edit {media}', ['media' => $mcCapitalized]), 
                [
                    'controller' => $mcPluralUnderscored,
                    'action' => 'edit', $media->refid
                ],
                [
                    'class' => 'btn btn-sm btn-azure',
                    'escapeTitle' => false
                ]) ?> 
        </li>
        <li class="nav-item"><?= $this->Form->postLink(__('Delete {media}', ['media' => $mcCapitalized]), 
                ['action' => 'delete', $media->refid], 
                [
                    'class' => 'btn btn-sm btn-danger',
                    'escapeTitle' => false,
                    'confirm' => __('Are you sure you want to delete # {0}?', $media->refid)
                ]) ?> 
        </li>
        <li class="nav-item"><?= $this->Html->link(__('List {medias}', ['medias' => $mcPluralCapitalized]), 
                [
                    'controller' => $mcPluralUnderscored,
                    'action' => 'index'
                ],
                [
                    'class' => 'btn btn-sm btn-green',
                    'escapeTitle' => false
                ]) ?> 
        </li>
        <li class="nav-item"><?= $this->Html->link(__('New {media}', ['media' => $mcCapitalized]), 
                ['controller' => 'upload', 'action' => 'media', '?' => [
                    'mtp' => h($media->get('media_type')), 
                    'cls' => h($media->get('classification'))
                    ]
                ],
                [
                    'class' => 'btn btn-sm btn-green',
                    'escapeTitle' => false
                ]) ?>
        </li>
    </ul>
</nav>
<div class="py-4">
    <div class="card rounded-0">
        <div class="card-body">
            <div class="<?= $mcUnderscored ?> content row">
                <div class="col-md-7 col-lg-8">
                    <div class="table-responsive">
                        <table class="vertical-table table table-hover table-outline table-vcenter text-nowrap card-table border">
                            <tr>
                                <th scope="row"><?= __('Title') ?></th>
                                <td><?= h($media->get('title')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Genre') ?></th>
                                <td><?= $media->get('genre') ? $media->get('genre')->get('name') : 'Not Available' ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Album') ?></th>
                                <td><?= $media->get('album') ? $media->get('album')->get('name') : 'Not yet assigned to any album' ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Author Location') ?></th>
                                <td><?= $media->get('author_location') ? h($media->get('author_location')) : 'Unknown Location' ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Target Audience') ?></th>
                                <td><?= h($media->get('target_audience')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Age Restriction') ?></th>
                                <td><?= h($media->get('age_restriction')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('{0}', ucfirst($equiv)) ?></th>
                                <td><?= $media->get('audio_or_video_counterpart_refid') ? $media->get('counterpart')->get('title') : 'NIL' ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Privacy') ?></th>
                                <td><?= h($media->get('privacy')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Status') ?></th>
                                <td><?= h($media->get('status')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Language') ?></th>
                                <td><?= h($media->get('language')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Orientation') ?></th>
                                <td><?= h($media->get('orientation')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Thumbnail') ?></th>
                                <td><?= h($media->get('thumbnail')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Total Plays') ?></th>
                                <td><?= $this->Number->format($media->get('total_plays')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Number Of People Played') ?></th>
                                <td><?= $this->Number->format($media->get('number_of_people_played')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Number Of Downloads') ?></th>
                                <td><?= $this->Number->format($media->get('number_of_downloads')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Recording Date') ?></th>
                                <td><?= h($media->get('recording_date')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Release Date') ?></th>
                                <td><?= h($media->get('release_date')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Created') ?></th>
                                <td><?= h($media->get('created')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Modified') ?></th>
                                <td><?= h($media->get('modified')) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Is Debut') ?></th>
                                <td><?= $media->get('is_debut') ? __('Yes') : __('No'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Monetize') ?></th>
                                <td><?= $media->get('monetize') ? __('Yes') : __('No'); ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="row">
                        <h4><?= __('Description') ?></h4>
                    <?= $this->Text->autoParagraph(h($media->get('description'))); ?>
                    </div>
                    <div class="row">
                        <h4><?= __('Cast') ?></h4>
                    <?= $this->Text->autoParagraph(h($media->get('cast'))); ?>
                    </div>
                    <div class="row">
                        <h4><?= __('Tags') ?></h4>
                    <?= $this->Text->autoParagraph(h($media->get('tags'))); ?>
                    </div>
                    <div class="row">
                        <h4><?= __('Audience Locations') ?></h4>
                    <?= $this->Text->autoParagraph(h($media->get('audience_locations'))); ?>
                    </div>
                </div>
                <aside class="col-md-5 col-lg-4">
                    <div class="sidebar-inner">
                        <div class="media-preview">
                            <div class="media-container">
                            <?= $this->MediaPlayer->load($media); ?>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

