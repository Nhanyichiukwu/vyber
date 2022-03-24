<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EventVenue[]|\Cake\Collection\CollectionInterface $eventVenues
 */
?>
<div class="eventVenues index content">
    <?= $this->Html->link(__('New Event Venue'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Event Venues') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('event_refid') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('country_region') ?></th>
                    <th><?= $this->Paginator->sort('state_province') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventVenues as $eventVenue): ?>
                <tr>
                    <td><?= $this->Number->format($eventVenue->id) ?></td>
                    <td><?= $eventVenue->has('event') ? $this->Html->link($eventVenue->event->title, ['controller' => 'Events', 'action' => 'view', $eventVenue->event->refid]) : '' ?></td>
                    <td><?= h($eventVenue->title) ?></td>
                    <td><?= h($eventVenue->country_region) ?></td>
                    <td><?= h($eventVenue->state_province) ?></td>
                    <td><?= h($eventVenue->city) ?></td>
                    <td><?= h($eventVenue->address) ?></td>
                    <td><?= h($eventVenue->start_date) ?></td>
                    <td><?= h($eventVenue->end_date) ?></td>
                    <td><?= h($eventVenue->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $eventVenue->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $eventVenue->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $eventVenue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventVenue->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
