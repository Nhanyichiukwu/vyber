<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Connection $connection
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Connections'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="connections form large-9 medium-8 columns content">
    <?= $this->Form->create($connection) ?>
    <fieldset>
        <legend><?= __('Add Connection') ?></legend>
        <?php
            echo $this->Form->control('party_a');
            echo $this->Form->control('party_b');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
