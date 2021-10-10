<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment $comment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $comment->refid],
                ['confirm' => __('Are you sure you want to delete # {0}?', $comment->refid)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="comments form large-9 medium-8 columns content">
    <?= $this->Form->create($comment) ?>
    <fieldset>
        <legend><?= __('Edit Comment') ?></legend>
        <?php
            echo $this->Form->control('id');
            echo $this->Form->control('author_refid', ['options' => $users]);
            echo $this->Form->control('post_refid', ['options' => $posts]);
            echo $this->Form->control('text');
            echo $this->Form->control('has_attachment');
            echo $this->Form->control('attachments');
            echo $this->Form->control('type');
            echo $this->Form->control('tags');
            echo $this->Form->control('location');
            echo $this->Form->control('privacy');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
