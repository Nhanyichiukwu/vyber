<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Genre $genre
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Genres'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="genres form large-9 medium-8 columns content">
    <?= $this->Form->create($genre) ?>
    <fieldset>
        <legend><?= __('Add Genre') ?></legend>
        <?php
            echo $this->Form->control('refid');
            echo $this->Form->control('name');
            echo $this->Form->control('slug');
            echo $this->Form->control('description');
            echo $this->Form->control('mofified');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
