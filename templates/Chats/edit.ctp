<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chat $chat
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $chat->refid],
                ['confirm' => __('Are you sure you want to delete # {0}?', $chat->refid)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Chats'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="chats form large-9 medium-8 columns content">
    <?= $this->Form->create($chat) ?>
    <fieldset>
        <legend><?= __('Edit Chat') ?></legend>
        <?php
            echo $this->Form->control('id');
            echo $this->Form->control('initiator_refid');
            echo $this->Form->control('start_time');
            echo $this->Form->control('chattype');
            echo $this->Form->control('group_accessibility');
            echo $this->Form->control('group_scalability');
            echo $this->Form->control('max_participants');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
