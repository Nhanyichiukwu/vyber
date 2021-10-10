<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MusicIndustry $musicIndustry
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Music Industry'), ['action' => 'edit', $musicIndustry->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Music Industry'), ['action' => 'delete', $musicIndustry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $musicIndustry->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Music Industry'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Music Industry'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="musicIndustry view large-9 medium-8 columns content">
    <h3><?= h($musicIndustry->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User Refid') ?></th>
            <td><?= h($musicIndustry->user_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role Refid') ?></th>
            <td><?= h($musicIndustry->role_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Stagename') ?></th>
            <td><?= h($musicIndustry->stagename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Entity Refid') ?></th>
            <td><?= h($musicIndustry->user_entity_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genre Refid') ?></th>
            <td><?= h($musicIndustry->genre_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Music Category Refid') ?></th>
            <td><?= h($musicIndustry->music_category_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debute Album') ?></th>
            <td><?= h($musicIndustry->debute_album) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debute Song') ?></th>
            <td><?= h($musicIndustry->debute_song) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Manager') ?></th>
            <td><?= h($musicIndustry->manager) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($musicIndustry->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Songs') ?></th>
            <td><?= $this->Number->format($musicIndustry->number_of_songs) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Videos') ?></th>
            <td><?= $this->Number->format($musicIndustry->number_of_videos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Albums') ?></th>
            <td><?= $this->Number->format($musicIndustry->number_of_albums) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Features') ?></th>
            <td><?= $this->Number->format($musicIndustry->number_of_features) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debute Year') ?></th>
            <td><?= h($musicIndustry->debute_year) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($musicIndustry->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($musicIndustry->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Skills') ?></h4>
        <?= $this->Text->autoParagraph(h($musicIndustry->skills)); ?>
    </div>
    <div class="row">
        <h4><?= __('Instruments Known') ?></h4>
        <?= $this->Text->autoParagraph(h($musicIndustry->instruments_known)); ?>
    </div>
    <div class="row">
        <h4><?= __('Story') ?></h4>
        <?= $this->Text->autoParagraph(h($musicIndustry->story)); ?>
    </div>
</div>
