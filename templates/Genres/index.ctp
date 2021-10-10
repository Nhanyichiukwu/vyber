<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Genre[]|\Cake\Collection\CollectionInterface $genres
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Genre'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="genres index large-9 medium-8 columns content">
    <h3><?= __('Genres') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mofified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($genres as $genre): ?>
            <tr>
                <td><?= $this->Number->format($genre->id) ?></td>
                <td><?= h($genre->refid) ?></td>
                <td><?= h($genre->name) ?></td>
                <td><?= h($genre->slug) ?></td>
                <td><?= h($genre->created) ?></td>
                <td><?= h($genre->mofified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $genre->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $genre->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $genre->id], ['confirm' => __('Are you sure you want to delete # {0}?', $genre->id)]) ?>
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
