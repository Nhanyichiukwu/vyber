<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Media[]|\Cake\Collection\CollectionInterface $medias
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Media'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="medias index large-9 medium-8 columns content">
    <h3><?= __('Medias') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                <th scope="col"><?= $this->Paginator->sort('author_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('genre_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('album_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('author_location') ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_path') ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_mime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('media_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('classification') ?></th>
                <th scope="col"><?= $this->Paginator->sort('target_audience') ?></th>
                <th scope="col"><?= $this->Paginator->sort('age_restriction') ?></th>
                <th scope="col"><?= $this->Paginator->sort('audio_or_video_counterpart_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('recording_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('release_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('privacy') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_debut') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monetize') ?></th>
                <th scope="col"><?= $this->Paginator->sort('language') ?></th>
                <th scope="col"><?= $this->Paginator->sort('orientation') ?></th>
                <th scope="col"><?= $this->Paginator->sort('thumbnail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_plays') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_of_people_played') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_of_downloads') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medias as $media): ?>
            <tr>
                <td><?= $this->Number->format($media->id) ?></td>
                <td><?= h($media->refid) ?></td>
                <td><?= h($media->title) ?></td>
                <td><?= h($media->slug) ?></td>
                <td><?= h($media->author_refid) ?></td>
                <td><?= h($media->genre_refid) ?></td>
                <td><?= h($media->album_refid) ?></td>
                <td><?= h($media->author_location) ?></td>
                <td><?= h($media->file_path) ?></td>
                <td><?= h($media->file_mime) ?></td>
                <td><?= h($media->media_type) ?></td>
                <td><?= h($media->classification) ?></td>
                <td><?= h($media->target_audience) ?></td>
                <td><?= h($media->age_restriction) ?></td>
                <td><?= h($media->audio_or_video_counterpart_refid) ?></td>
                <td><?= h($media->recording_date) ?></td>
                <td><?= h($media->release_date) ?></td>
                <td><?= h($media->privacy) ?></td>
                <td><?= h($media->status) ?></td>
                <td><?= h($media->is_debut) ?></td>
                <td><?= h($media->monetize) ?></td>
                <td><?= h($media->language) ?></td>
                <td><?= h($media->orientation) ?></td>
                <td><?= h($media->thumbnail) ?></td>
                <td><?= $this->Number->format($media->total_plays) ?></td>
                <td><?= $this->Number->format($media->number_of_people_played) ?></td>
                <td><?= $this->Number->format($media->number_of_downloads) ?></td>
                <td><?= h($media->created) ?></td>
                <td><?= h($media->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $media->refid]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $media->refid]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $media->refid], ['confirm' => __('Are you sure you want to delete # {0}?', $media->refid)]) ?>
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
