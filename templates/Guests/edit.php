<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $guest
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $guest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $guest->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Guests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="guests form content">
            <?= $this->Form->create($guest) ?>
            <fieldset>
                <legend><?= __('Edit Guest') ?></legend>
                <?php
                    echo $this->Form->control('browser');
                    echo $this->Form->control('continent');
                    echo $this->Form->control('continent_code');
                    echo $this->Form->control('country');
                    echo $this->Form->control('country_code');
                    echo $this->Form->control('currency_converter');
                    echo $this->Form->control('currency_code');
                    echo $this->Form->control('currency_symbol');
                    echo $this->Form->control('device');
                    echo $this->Form->control('ip');
                    echo $this->Form->control('last_visit');
                    echo $this->Form->control('latitude');
                    echo $this->Form->control('longitude');
                    echo $this->Form->control('os');
                    echo $this->Form->control('region');
                    echo $this->Form->control('registered_user_refid');
                    echo $this->Form->control('state');
                    echo $this->Form->control('timezone');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
