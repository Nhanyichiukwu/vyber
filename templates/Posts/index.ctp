<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post[]|\Cake\Collection\CollectionInterface $posts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Post'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="posts index large-9 medium-8 columns content">
    <h3><?= __('Posts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('author_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shared_post_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('has_attachment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('privacy') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= $this->Number->format($post->id) ?></td>
                <td><?= h($post->refid) ?></td>
                <td><?= $post->has('user') ? $this->Html->link($post->user->refid, ['controller' => 'Users', 'action' => 'view', $post->user->refid]) : '' ?></td>
                <td><?= h($post->shared_post_refid) ?></td>
                <td><?= h($post->has_attachment) ?></td>
                <td><?= h($post->type) ?></td>
                <td><?= h($post->privacy) ?></td>
                <td><?= h($post->created) ?></td>
                <td><?= h($post->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $post->refid]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $post->refid]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $post->refid], ['confirm' => __('Are you sure you want to delete # {0}?', $post->refid)]) ?>
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
