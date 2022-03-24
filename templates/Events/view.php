<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */
//$this->enablePageHeader();
?>
<nav class="toolbar bg-white py-3 border-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <?= $this->Html->link(__('Edit Event'), [
                    'action' => 'edit',
                    $event->refid
                ], [
                    'class' => 'btn btn-sm btn-primary'
                ]) ?>
                <?= $this->Form->postLink(__('Delete Event'), [
                    'action' => 'delete',
                    $event->refid
                ], [
                    'confirm' => __('Are you sure you want to delete # {0}?', $event->refid),
                    'class' => 'btn btn-sm btn-danger'
                ]) ?>
            </div>
            <div class="col-auto ms-auto">
                <?= $this->Html->link(__('List Events'), [
                    'action' => 'index'
                ], [
                    'class' => 'btn btn-sm btn-info'
                ]) ?>
                <?= $this->Html->link(__('New Event'), [
                    'action' => 'create'
                ], [
                    'class' => 'btn btn-sm btn-app'
                ]) ?>
            </div>
        </div>
    </div>
</nav>
<div class="px-3 px-lg-0">
    <div class="row">
        <div class="event view content col-md-9">
            <div class="event-header h_jLXcJpA0 border-bottom bg-white"></div>
            <h3><?= h($event->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Refid') ?></th>
                    <td><?= h($event->refid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($event->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Event Type') ?></th>
                    <td><?= $event->has('event_type') ? $this->Html->link($event->event_type->name, ['controller' => 'EventTypes', 'action' => 'view', $event->event_type->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Privacy') ?></th>
                    <td><?= h($event->privacy) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><?= h($event->media) ?></td>
                </tr>
                <tr>
                    <th><?= __('Author') ?></th>
                    <td><?= $event->has('author') ? $this->Html->link($event->author->refid, ['controller' => 'Users', 'action' => 'view', $event->author->refid]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Hostname') ?></th>
                    <td><?= h($event->hostname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($event->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($event->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($event->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($event->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($event->description)); ?>
                </blockquote>
            </div>
        </div>
        <div class="related col-md-3">
            <div class="event-venues">
                <h4><?= __('Venues') ?></h4>
                <?php if (!empty($event->venues)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Event Refid') ?></th>
                                <th><?= __('Title') ?></th>
                                <th><?= __('Description') ?></th>
                                <th><?= __('Image') ?></th>
                                <th><?= __('Country Region') ?></th>
                                <th><?= __('State Province') ?></th>
                                <th><?= __('City') ?></th>
                                <th><?= __('Address') ?></th>
                                <th><?= __('Start Date') ?></th>
                                <th><?= __('End Date') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($event->venues as $venues) : ?>
                                <tr>
                                    <td><?= h($venues->id) ?></td>
                                    <td><?= h($venues->event_refid) ?></td>
                                    <td><?= h($venues->title) ?></td>
                                    <td><?= h($venues->description) ?></td>
                                    <td><?= h($venues->image) ?></td>
                                    <td><?= h($venues->country_region) ?></td>
                                    <td><?= h($venues->state_province) ?></td>
                                    <td><?= h($venues->city) ?></td>
                                    <td><?= h($venues->address) ?></td>
                                    <td><?= h($venues->start_date) ?></td>
                                    <td><?= h($venues->end_date) ?></td>
                                    <td><?= h($venues->status) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'EventVenues', 'action' => 'view', $venues->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'EventVenues', 'action' => 'edit', $venues->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'EventVenues', 'action' => 'delete', $venues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $venues->id)]) ?>
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
<?php //$this->extend('common'); ?>
