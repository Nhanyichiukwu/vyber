<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Media $media
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Media'), ['action' => 'edit', $media->refid]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Media'), ['action' => 'delete', $media->refid], ['confirm' => __('Are you sure you want to delete # {0}?', $media->refid)]) ?> </li>
        <li><?= $this->Html->link(__('List Medias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Media'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="medias view large-9 medium-8 columns content">
    <h3><?= h($media->refid) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Refid') ?></th>
            <td><?= h($media->refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($media->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($media->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author Refid') ?></th>
            <td><?= h($media->author_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genre Refid') ?></th>
            <td><?= h($media->genre_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Album Refid') ?></th>
            <td><?= h($media->album_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author Location') ?></th>
            <td><?= h($media->author_location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File Path') ?></th>
            <td><?= h($media->file_path) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File Mime') ?></th>
            <td><?= h($media->file_mime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Media Type') ?></th>
            <td><?= h($media->media_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Classification') ?></th>
            <td><?= h($media->classification) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Target Audience') ?></th>
            <td><?= h($media->target_audience) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Age Restriction') ?></th>
            <td><?= h($media->age_restriction) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Audio Or Video Counterpart Refid') ?></th>
            <td><?= h($media->audio_or_video_counterpart_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Privacy') ?></th>
            <td><?= h($media->privacy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($media->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Language') ?></th>
            <td><?= h($media->language) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Orientation') ?></th>
            <td><?= h($media->orientation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Thumbnail') ?></th>
            <td><?= h($media->thumbnail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($media->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Plays') ?></th>
            <td><?= $this->Number->format($media->total_plays) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of People Played') ?></th>
            <td><?= $this->Number->format($media->number_of_people_played) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Downloads') ?></th>
            <td><?= $this->Number->format($media->number_of_downloads) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Recording Date') ?></th>
            <td><?= h($media->recording_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Release Date') ?></th>
            <td><?= h($media->release_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($media->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($media->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Debut') ?></th>
            <td><?= $media->is_debut ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monetize') ?></th>
            <td><?= $media->monetize ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($media->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Cast') ?></h4>
        <?= $this->Text->autoParagraph(h($media->cast)); ?>
    </div>
    <div class="row">
        <h4><?= __('Tags') ?></h4>
        <?= $this->Text->autoParagraph(h($media->tags)); ?>
    </div>
    <div class="row">
        <h4><?= __('Audience Locations') ?></h4>
        <?= $this->Text->autoParagraph(h($media->audience_locations)); ?>
    </div>
</div>
