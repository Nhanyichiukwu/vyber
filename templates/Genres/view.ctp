<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Genre $genre
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Genre'), ['action' => 'edit', $genre->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Genre'), ['action' => 'delete', $genre->id], ['confirm' => __('Are you sure you want to delete # {0}?', $genre->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Genres'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Genre'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="genres view large-9 medium-8 columns content">
    <h3><?= h($genre->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Refid') ?></th>
            <td><?= h($genre->refid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($genre->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($genre->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($genre->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($genre->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mofified') ?></th>
            <td><?= h($genre->mofified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($genre->description)); ?>
    </div>
</div>
