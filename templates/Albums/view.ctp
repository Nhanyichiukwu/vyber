<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Album $album
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Album'), ['action' => 'edit', $album->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Album'), ['action' => 'delete', $album->id], ['confirm' => __('Are you sure you want to delete # {0}?', $album->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Albums'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Album'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="albums view large-9 medium-8 columns content">
    <h3><?= h($album->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Refid') ?></th>
            <td><?= h($album->refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($album->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($album->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Owner Refid') ?></th>
            <td><?= h($album->owner_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category Refid') ?></th>
            <td><?= h($album->category_refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Debute') ?></th>
            <td><?= h($album->is_debute) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Privacy') ?></th>
            <td><?= h($album->privacy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= h($album->published) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($album->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Release Date') ?></th>
            <td><?= h($album->release_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($album->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mofified') ?></th>
            <td><?= h($album->mofified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($album->description)); ?>
    </div>
</div>
