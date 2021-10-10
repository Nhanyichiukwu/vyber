<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event[]|\Cake\Collection\CollectionInterface $events
 */
?>

<?php
$section = $this->Url->request->getQuery('section');
if (!$section) {
    $section = 'default';
}
?>
<div class="connections">
    <div class="page-header mt-0 justify-content-between">
        <h1 class="page-title"><?= __('Events') ?></h1>
        <nav class="collapse d-lg-flex navbar toolbar page-nav border-bottom p-0">
            <div class="align-items-center px-2">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                    <li class="nav-item"><?= $this->Html->link(__('My Events'), ['action' => 'index'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'default'? ' active':'')]) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Invites'), ['action' => 'invites'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'sent_requests'? ' active':'')]) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Upcoming'), ['action' => 'upcoming'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending'? ' active':'')]) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Recent'), ['action' => 'recent'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending'? ' active':'')]) ?></li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="row">
    <div class="events col-md-8 content table-responsive">
        <div class="">
            <div class="row">
                <?php foreach ($events as $event): ?>
                <div class="col-md-4">
                    <div class="event">
                        <div class="card">
                            <div class="card-img card-img-top">
                                <?php
                                    $imageName = substr($event->image, 0, strrpos($event->image, '.'));
                                    $ext = substr($event->image, strrpos($event->image, '.'));
                                ?>
                                <?= $this->Html->image(Router::url('media/' . $imageName . '?format=' $ext . '&size=small', true), [])
                            </div>
                            <div class="card-body">
                                <div class="event-description"><?= h($event->description) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('refid') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('user_refid') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('host_name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('start_date') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('end_date') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('event_title') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= $this->Number->format($event->id) ?></td>
                    <td><?= h($event->refid) ?></td>
                    <td><?= h($event->user_refid) ?></td>
                    <td><?= h($event->host_name) ?></td>
                    <td><?= h($event->start_date) ?></td>
                    <td><?= h($event->end_date) ?></td>
                    <td><?= h($event->event_title) ?></td>
                    <td><?= h($event->created) ?></td>
                    <td><?= h($event->modified) ?></td>
                    <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $event->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $event->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $event->id], ['confirm' => __('Are you sure you want to delete # {0}?', $event->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first'), ['class' => 'bar']) ?>
            <?= $this->Paginator->prev('< ' . __('previous'), ['class' => 'barz']) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >', ['class' => 'foo']) ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>