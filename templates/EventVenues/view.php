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
            <?= $this->Html->link(__('Edit Event Venue'), ['action' => 'edit', $eventVenue->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Event Venue'), ['action' => 'delete', $eventVenue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventVenue->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Event Venues'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Event Venue'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="eventVenues view content">
            <h3><?= h($eventVenue->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Event') ?></th>
                    <td><?= $eventVenue->has('event') ? $this->Html->link($eventVenue->event->title, ['controller' => 'Events', 'action' => 'view', $eventVenue->event->refid]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($eventVenue->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country Region') ?></th>
                    <td><?= h($eventVenue->country_region) ?></td>
                </tr>
                <tr>
                    <th><?= __('State Province') ?></th>
                    <td><?= h($eventVenue->state_province) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($eventVenue->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($eventVenue->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($eventVenue->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($eventVenue->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($eventVenue->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($eventVenue->end_date) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($eventVenue->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Event Guests') ?></h4>
                <?php if (!empty($eventVenue->guests)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Event Refid') ?></th>
                            <th><?= __('Event Venue Id') ?></th>
                            <th><?= __('Guest Refid') ?></th>
                            <th><?= __('Inviter Refid') ?></th>
                            <th><?= __('Date Invited') ?></th>
                            <th><?= __('Event Seen') ?></th>
                            <th><?= __('Date Seen') ?></th>
                            <th><?= __('Invite Response Date') ?></th>
                            <th><?= __('Response') ?></th>
                            <th><?= __('Event Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($eventVenue->guests as $guests) : ?>
                        <tr>
                            <td><?= h($guests->id) ?></td>
                            <td><?= h($guests->event_refid) ?></td>
                            <td><?= h($guests->event_venue_id) ?></td>
                            <td><?= h($guests->guest_refid) ?></td>
                            <td><?= h($guests->inviter_refid) ?></td>
                            <td><?= h($guests->date_invited) ?></td>
                            <td><?= h($guests->event_seen) ?></td>
                            <td><?= h($guests->date_seen) ?></td>
                            <td><?= h($guests->invite_response_date) ?></td>
                            <td><?= h($guests->response) ?></td>
                            <td><?= h($guests->event_status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'EventGuests', 'action' => 'view', $guests->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'EventGuests', 'action' => 'edit', $guests->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'EventGuests', 'action' => 'delete', $guests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $guests->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invitees') ?></h4>
                <?php if (!empty($eventVenue->invitees)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Event Refid') ?></th>
                            <th><?= __('Event Venue Id') ?></th>
                            <th><?= __('Guest Refid') ?></th>
                            <th><?= __('Inviter Refid') ?></th>
                            <th><?= __('Date Invited') ?></th>
                            <th><?= __('Event Seen') ?></th>
                            <th><?= __('Date Seen') ?></th>
                            <th><?= __('Invite Response Date') ?></th>
                            <th><?= __('Response') ?></th>
                            <th><?= __('Event Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($eventVenue->invitees as $invitees) : ?>
                        <tr>
                            <td><?= h($invitees->id) ?></td>
                            <td><?= h($invitees->event_refid) ?></td>
                            <td><?= h($invitees->event_venue_id) ?></td>
                            <td><?= h($invitees->guest_refid) ?></td>
                            <td><?= h($invitees->inviter_refid) ?></td>
                            <td><?= h($invitees->date_invited) ?></td>
                            <td><?= h($invitees->event_seen) ?></td>
                            <td><?= h($invitees->date_seen) ?></td>
                            <td><?= h($invitees->invite_response_date) ?></td>
                            <td><?= h($invitees->response) ?></td>
                            <td><?= h($invitees->event_status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Invitees', 'action' => 'view', $invitees->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Invitees', 'action' => 'edit', $invitees->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Invitees', 'action' => 'delete', $invitees->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invitees->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Event Venue Dates') ?></h4>
                <?php if (!empty($eventVenue->dates)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Venue Id') ?></th>
                            <th><?= __('Day') ?></th>
                            <th><?= __('Starts At') ?></th>
                            <th><?= __('Ends At') ?></th>
                            <th><?= __('Detail') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($eventVenue->dates as $dates) : ?>
                        <tr>
                            <td><?= h($dates->id) ?></td>
                            <td><?= h($dates->venue_id) ?></td>
                            <td><?= h($dates->day) ?></td>
                            <td><?= h($dates->starts_at) ?></td>
                            <td><?= h($dates->ends_at) ?></td>
                            <td><?= h($dates->detail) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'EventVenueDates', 'action' => 'view', $dates->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'EventVenueDates', 'action' => 'edit', $dates->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'EventVenueDates', 'action' => 'delete', $dates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dates->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
