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
$this->pageTitle('Add Event Venues');

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
                    <p class="section-title intro-texts text-center text-md-left">
                        You've created a new event: <strong class="_ah49Gn"><?= $event->get('title')
                            ?></strong>.
                        Add venues where this event will be taking place. You can add multiple
                            venues, specify the title, description, poster image for each venue,
                            as well as the dates and times the event will take place at each venue.
                        If no image is added for a venue, it will use the event general poster
                        as the fallback.</small>
                    </p>
                    <?= $this->element('Events/venue_input', ['id' => 'default-venue', 'class' => 'default-venue',
                        'index' => 0]) ?>
                    <div class="add-venue mb-3 text-center">
                        <button class="btn btn-outline-secondary btn-sm" type="button">
                            <i class="mdi mdi-format-float-left"></i> Add another venue
                        </button>
                    </div>
                </div>
                <div class="form-group text-md-end mt-5">
                    <?= $this->Form->button(__('Update Event'), [
                        'class' => 'btn btn-app btn-block btn-pill'
                    ]) ?>
                </div>
                <?= $this->Form->end(['Upload']) ?>
            </div>
        </div>
    </div>
</div>

