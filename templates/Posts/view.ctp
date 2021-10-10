<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Post'), ['action' => 'edit', $post->refid]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Post'), ['action' => 'delete', $post->refid], ['confirm' => __('Are you sure you want to delete # {0}?', $post->refid)]) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="posts view large-9 medium-8 columns content">
    <h3><?= h($post->refid) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Refid') ?></th>
            <td><?= h($post->refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $post->has('user') ? $this->Html->link($post->user->refid, ['controller' => 'Users', 'action' => 'view', $post->user->refid]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shared Post Refid') ?></th>
            <td><?= h($post->shared_post_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Has Attachment') ?></th>
            <td><?= h($post->has_attachment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($post->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Privacy') ?></th>
            <td><?= h($post->privacy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($post->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($post->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($post->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Post Text') ?></h4>
        <?= $this->Text->autoParagraph(h($post->post_text)); ?>
    </div>
    <div class="row">
        <h4><?= __('Attachments') ?></h4>
        <?= $this->Text->autoParagraph(h($post->attachments)); ?>
    </div>
    <div class="row">
        <h4><?= __('Tags') ?></h4>
        <?= $this->Text->autoParagraph(h($post->tags)); ?>
    </div>
    <div class="row">
        <h4><?= __('Location') ?></h4>
        <?= $this->Text->autoParagraph(h($post->location)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Comments') ?></h4>
        <?php if (!empty($post->comments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Refid') ?></th>
                <th scope="col"><?= __('Author Refid') ?></th>
                <th scope="col"><?= __('Post Refid') ?></th>
                <th scope="col"><?= __('Text') ?></th>
                <th scope="col"><?= __('Has Attachment') ?></th>
                <th scope="col"><?= __('Attachments') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Tags') ?></th>
                <th scope="col"><?= __('Location') ?></th>
                <th scope="col"><?= __('Privacy') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($post->comments as $comments): ?>
            <tr>
                <td><?= h($comments->id) ?></td>
                <td><?= h($comments->refid) ?></td>
                <td><?= h($comments->author_refid) ?></td>
                <td><?= h($comments->post_refid) ?></td>
                <td><?= h($comments->text) ?></td>
                <td><?= h($comments->has_attachment) ?></td>
                <td><?= h($comments->attachments) ?></td>
                <td><?= h($comments->type) ?></td>
                <td><?= h($comments->tags) ?></td>
                <td><?= h($comments->location) ?></td>
                <td><?= h($comments->privacy) ?></td>
                <td><?= h($comments->created) ?></td>
                <td><?= h($comments->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comments->refid]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Comments', 'action' => 'edit', $comments->refid]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Comments', 'action' => 'delete', $comments->refid], ['confirm' => __('Are you sure you want to delete # {0}?', $comments->refid)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
