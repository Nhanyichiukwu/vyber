<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $post->refid],
                ['confirm' => __('Are you sure you want to delete # {0}?', $post->refid)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="posts form large-9 medium-8 columns content">
    <?= $this->Form->create($post) ?>
    <fieldset>
        <legend><?= __('Edit Post') ?></legend>
        <?php
            echo $this->Form->control('id');
            echo $this->Form->control('author_refid', ['options' => $users]);
            echo $this->Form->control('shared_post_refid');
            echo $this->Form->control('post_text');
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
