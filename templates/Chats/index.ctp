<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chat[]|\Cake\Collection\CollectionInterface $chats
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Chat'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="chats index large-9 medium-8 columns content">
    <h3><?= __('Chats') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('initiator_refid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('chattype') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_accessibility') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_scalability') ?></th>
                <th scope="col"><?= $this->Paginator->sort('max_participants') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chats as $chat): ?>
            <tr>
                <td><?= $this->Number->format($chat->id) ?></td>
                <td><?= h($chat->refid) ?></td>
                <td><?= h($chat->initiator_refid) ?></td>
                <td><?= h($chat->start_time) ?></td>
                <td><?= h($chat->chattype) ?></td>
                <td><?= h($chat->group_accessibility) ?></td>
                <td><?= h($chat->group_scalability) ?></td>
                <td><?= $this->Number->format($chat->max_participants) ?></td>
                <td><?= h($chat->created) ?></td>
                <td><?= h($chat->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $chat->refid]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chat->refid]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chat->refid], ['confirm' => __('Are you sure you want to delete # {0}?', $chat->refid)]) ?>
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
