<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Album $album
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Albums'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="albums form large-9 medium-8 columns content">
    <?= $this->Form->create($album) ?>
    <fieldset>
        <legend><?= __('Add Album') ?></legend>
        <?php
            echo $this->Form->control('refid');
            echo $this->Form->control('name');
            echo $this->Form->control('slug');
            echo $this->Form->control('description');
            echo $this->Form->control('owner_refid');
            echo $this->Form->control('category_refid');
            echo $this->Form->control('release_date', ['empty' => true]);
            echo $this->Form->control('is_debute');
            echo $this->Form->control('privacy');
            echo $this->Form->control('published');
            echo $this->Form->control('mofified');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
