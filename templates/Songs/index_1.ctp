<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Video[]|\Cake\Collection\CollectionInterface $videos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Video'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="videos index large-9 medium-8 columns content">
    <h3><?= __('Videos') ?></h3>
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
                <th scope="col"><?= $this->Paginator->sort('song_refid') ?></th>
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
            <?php foreach ($videos as $video): ?>
            <tr>
                <td><?= $this->Number->format($video->id) ?></td>
                <td><?= h($video->refid) ?></td>
                <td><?= h($video->title) ?></td>
                <td><?= h($video->slug) ?></td>
                <td><?= h($video->privacy) ?></td>
                <td><?= h($video->author_location) ?></td>
                <td><?= h($video->url) ?></td>
                <td><?= h($video->media_type) ?></td>
                <td><?= h($video->author_refid) ?></td>
                <td><?= h($video->song_refid) ?></td>
                <td><?= h($video->album_refid) ?></td>
                <td><?= h($video->genre_refid) ?></td>
                <td><?= h($video->category_refid) ?></td>
                <td><?= h($video->release_date) ?></td>
                <td><?= h($video->is_debute) ?></td>
                <td><?= h($video->monetize) ?></td>
                <td><?= $this->Number->format($video->total_plays) ?></td>
                <td><?= $this->Number->format($video->number_of_people_played) ?></td>
                <td><?= $this->Number->format($video->number_of_downloads) ?></td>
                <td><?= h($video->created) ?></td>
                <td><?= h($video->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $video->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $video->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $video->id], ['confirm' => __('Are you sure you want to delete # {0}?', $video->id)]) ?>
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
