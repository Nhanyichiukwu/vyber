<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EventVenue $eventVenue
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $eventVenue->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $eventVenue->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Event Venues'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="eventVenues form content">
            <?= $this->Form->create($eventVenue) ?>
            <fieldset>
                <legend><?= __('Edit Event Venue') ?></legend>
                <?php
                    echo $this->Form->control('event_refid', ['options' => $events]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('country_region');
                    echo $this->Form->control('state_province');
                    echo $this->Form->control('city');
                    echo $this->Form->control('address');
                    echo $this->Form->control('start_date');
                    echo $this->Form->control('end_date');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
