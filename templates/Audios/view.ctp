<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Song $song
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Song'), ['action' => 'edit', $song->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Song'), ['action' => 'delete', $song->id], ['confirm' => __('Are you sure you want to delete # {0}?', $song->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Songs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Song'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="songs view large-9 medium-8 columns content">
    <h3><?= h($song->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Refid') ?></th>
            <td><?= h($song->refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($song->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($song->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Privacy') ?></th>
            <td><?= h($song->privacy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author Location') ?></th>
            <td><?= h($song->author_location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($song->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Media Type') ?></th>
            <td><?= h($song->media_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author Refid') ?></th>
            <td><?= h($song->author_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Video Refid') ?></th>
            <td><?= h($song->video_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Album Refid') ?></th>
            <td><?= h($song->album_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genre Refid') ?></th>
            <td><?= h($song->genre_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category Refid') ?></th>
            <td><?= h($song->category_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Debute') ?></th>
            <td><?= h($song->is_debute) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monetize') ?></th>
            <td><?= h($song->monetize) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($song->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Plays') ?></th>
            <td><?= $this->Number->format($song->total_plays) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of People Played') ?></th>
            <td><?= $this->Number->format($song->number_of_people_played) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Downloads') ?></th>
            <td><?= $this->Number->format($song->number_of_downloads) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Release Date') ?></th>
            <td><?= h($song->release_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($song->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($song->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($song->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Cast') ?></h4>
        <?= $this->Text->autoParagraph(h($song->cast)); ?>
    </div>
    <div class="row">
        <h4><?= __('Tags') ?></h4>
        <?= $this->Text->autoParagraph(h($song->tags)); ?>
    </div>
</div>
