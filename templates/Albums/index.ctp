<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Album[]|\Cake\Collection\CollectionInterface $albums
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Album'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="albums index large-9 medium-8 columns content">
    <h3><?= __('Albums') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                <th scope="col"><?= $this->Paginator->sort('owner_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('release_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_debute') ?></th>
                <th scope="col"><?= $this->Paginator->sort('privacy') ?></th>
                <th scope="col"><?= $this->Paginator->sort('published') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mofified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($albums as $album): ?>
            <tr>
                <td><?= $this->Number->format($album->id) ?></td>
                <td><?= h($album->refid) ?></td>
                <td><?= h($album->name) ?></td>
                <td><?= h($album->slug) ?></td>
                <td><?= h($album->owner_refid) ?></td>
                <td><?= h($album->category_refid) ?></td>
                <td><?= h($album->release_date) ?></td>
                <td><?= h($album->is_debute) ?></td>
                <td><?= h($album->privacy) ?></td>
                <td><?= h($album->published) ?></td>
                <td><?= h($album->created) ?></td>
                <td><?= h($album->mofified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $album->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $album->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $album->id], ['confirm' => __('Are you sure you want to delete # {0}?', $album->id)]) ?>
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
