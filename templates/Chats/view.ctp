<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chat $chat
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Chat'), ['action' => 'edit', $chat->refid]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Chat'), ['action' => 'delete', $chat->refid], ['confirm' => __('Are you sure you want to delete # {0}?', $chat->refid)]) ?> </li>
        <li><?= $this->Html->link(__('List Chats'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Chat'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="chats view large-9 medium-8 columns content">
    <h3><?= h($chat->refid) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Refid') ?></th>
            <td><?= h($chat->refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Initiator Refid') ?></th>
            <td><?= h($chat->initiator_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Chattype') ?></th>
            <td><?= h($chat->chattype) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group Accessibility') ?></th>
            <td><?= h($chat->group_accessibility) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group Scalability') ?></th>
            <td><?= h($chat->group_scalability) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($chat->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Max Participants') ?></th>
            <td><?= $this->Number->format($chat->max_participants) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($chat->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($chat->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($chat->modified) ?></td>
        </tr>
    </table>
</div>
