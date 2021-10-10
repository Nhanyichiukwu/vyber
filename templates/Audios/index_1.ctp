<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Song[]|\Cake\Collection\CollectionInterface $songs
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Song'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="songs index large-9 medium-8 columns content">
    <h3><?= __('Songs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                <th scope="col"><?= $this->Paginator->sort('privacy') ?></th>
                <th scope="col"><?= $this->Paginator->sort('author_location') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('media_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('author_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('video_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('album_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('genre_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('release_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_debute') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monetize') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_plays') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_of_people_played') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_of_downloads') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($songs as $song): ?>
            <tr>
                <td><?= $this->Number->format($song->id) ?></td>
                <td><?= h($song->refid) ?></td>
                <td><?= h($song->title) ?></td>
                <td><?= h($song->slug) ?></td>
                <td><?= h($song->privacy) ?></td>
                <td><?= h($song->author_location) ?></td>
                <td><?= h($song->url) ?></td>
                <td><?= h($song->media_type) ?></td>
                <td><?= h($song->author_refid) ?></td>
                <td><?= h($song->video_refid) ?></td>
                <td><?= h($song->album_refid) ?></td>
                <td><?= h($song->genre_refid) ?></td>
                <td><?= h($song->category_refid) ?></td>
                <td><?= h($song->release_date) ?></td>
                <td><?= h($song->is_debute) ?></td>
                <td><?= h($song->monetize) ?></td>
                <td><?= $this->Number->format($song->total_plays) ?></td>
                <td><?= $this->Number->format($song->number_of_people_played) ?></td>
                <td><?= $this->Number->format($song->number_of_downloads) ?></td>
                <td><?= h($song->created) ?></td>
                <td><?= h($song->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $song->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $song->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $song->id], ['confirm' => __('Are you sure you want to delete # {0}?', $song->id)]) ?>
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
