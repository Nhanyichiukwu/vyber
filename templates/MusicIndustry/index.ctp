<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MusicIndustry[]|\Cake\Collection\CollectionInterface $musicIndustry
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Music Industry'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="musicIndustry index large-9 medium-8 columns content">
    <h3><?= __('Music Industry') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('stagename') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_entity_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('genre_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('music_category_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debute_year') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debute_album') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debute_song') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_of_songs') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_of_videos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_of_albums') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_of_features') ?></th>
                <th scope="col"><?= $this->Paginator->sort('manager') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($musicIndustry as $musicIndustry): ?>
            <tr>
                <td><?= $this->Number->format($musicIndustry->id) ?></td>
                <td><?= h($musicIndustry->user_refid) ?></td>
                <td><?= h($musicIndustry->role_refid) ?></td>
                <td><?= h($musicIndustry->stagename) ?></td>
                <td><?= h($musicIndustry->user_entity_refid) ?></td>
                <td><?= h($musicIndustry->genre_refid) ?></td>
                <td><?= h($musicIndustry->music_category_refid) ?></td>
                <td><?= h($musicIndustry->debute_year) ?></td>
                <td><?= h($musicIndustry->debute_album) ?></td>
                <td><?= h($musicIndustry->debute_song) ?></td>
                <td><?= $this->Number->format($musicIndustry->number_of_songs) ?></td>
                <td><?= $this->Number->format($musicIndustry->number_of_videos) ?></td>
                <td><?= $this->Number->format($musicIndustry->number_of_albums) ?></td>
                <td><?= $this->Number->format($musicIndustry->number_of_features) ?></td>
                <td><?= h($musicIndustry->manager) ?></td>
                <td><?= h($musicIndustry->created) ?></td>
                <td><?= h($musicIndustry->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $musicIndustry->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $musicIndustry->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $musicIndustry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $musicIndustry->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
