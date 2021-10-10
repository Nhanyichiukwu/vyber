<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $request->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $request->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Requests'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="requests form large-9 medium-8 columns content">
    <?= $this->Form->create($request) ?>
    <fieldset>
        <legend><?= __('Edit Request') ?></legend>
        <?php
            echo $this->Form->control('refid');
            echo $this->Form->control('sender_refid');
            echo $this->Form->control('target_refid');
            echo $this->Form->control('short_message');
            echo $this->Form->control('is_read');
            echo $this->Form->control('acceptance');
            echo $this->Form->control('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
