<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Video $video
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Video'), ['action' => 'edit', $video->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Video'), ['action' => 'delete', $video->id], ['confirm' => __('Are you sure you want to delete # {0}?', $video->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Videos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Video'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="videos view large-9 medium-8 columns content">
    <h3><?= h($video->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Refid') ?></th>
            <td><?= h($video->refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($video->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($video->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Privacy') ?></th>
            <td><?= h($video->privacy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author Location') ?></th>
            <td><?= h($video->author_location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($video->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Media Type') ?></th>
            <td><?= h($video->media_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author Refid') ?></th>
            <td><?= h($video->author_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Song Refid') ?></th>
            <td><?= h($video->song_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Album Refid') ?></th>
            <td><?= h($video->album_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genre Refid') ?></th>
            <td><?= h($video->genre_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category Refid') ?></th>
            <td><?= h($video->category_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Debute') ?></th>
            <td><?= h($video->is_debute) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monetize') ?></th>
            <td><?= h($video->monetize) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($video->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Plays') ?></th>
            <td><?= $this->Number->format($video->total_plays) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of People Played') ?></th>
            <td><?= $this->Number->format($video->number_of_people_played) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Downloads') ?></th>
            <td><?= $this->Number->format($video->number_of_downloads) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Release Date') ?></th>
            <td><?= h($video->release_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($video->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($video->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($video->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Cast') ?></h4>
        <?= $this->Text->autoParagraph(h($video->cast)); ?>
    </div>
    <div class="row">
        <h4><?= __('Tags') ?></h4>
        <?= $this->Text->autoParagraph(h($video->tags)); ?>
    </div>
</div>
