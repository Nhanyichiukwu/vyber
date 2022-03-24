<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EventVenue $eventVenue
 */
?>
<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */

$this->enablePageHeader();
$this->pageTitle('Create Events');

$this->omitWidget('unread_notifications');

?>
<?php $this->start('header_widget'); ?>
<?= $this->Html->link(
    __('List Events'),
    ['action' => 'index'],
    [
        'class' => 'border btn btn-outline-light nav-link px-2 shadow-sm text-dark c-default',
    ]
) ?>
<?php $this->end(); ?>
<div class="_rtacSK">
    <div class="_nJRzoh">
        <div class="events form bg-white">
            <div class="p-3">
                <?= $this->Form->create($event, ['type' => 'file']) ?>
                <div class="venues">
                    <p class="section-title"><b>Venue:</b> <small>Where is this event taking place? You can add multiple
                            venues,
                            and specify the dates and times the event will take place at each venue.</small>
                    </p>
                    <?= $this->element('Events/venue_input', ['id' => 'default-venue', 'class' => 'default-venue',
                        'index' => 0]) ?>
                    <div class="add-venue mb-3">
                        <button class="btn btn-app-outline btn-block">
                            <i class="mdi mdi-plus"></i> Add another venue
                        </button>
                    </div>
                </div>
                <div class="form-group text-md-end">
                    <?= $this->Form->button(__('Save Events'), [
                        'class' => 'btn btn-app btn-block'
                    ]) ?>
                </div>
                <?= $this->Form->end(['Upload']) ?>
            </div>
        </div>
    </div>
</div>

