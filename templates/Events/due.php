<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event[]|\Cake\Collection\CollectionInterface $events
 */
?>
<div class="row">
    <nav class="col-md-2" id="actions-sidebar">
        <ul class="side-nav">
            <li class="heading"><?= __('Actions') ?></li>
            <li><?= $this->Html->link(__('New Events'), ['action' => 'add']) ?></li>
        </ul>
    </nav>
    <div class="events col-md-10 content">
        <?php
        $section = $this->Url->request->getQuery('section');
        if (!$section) $section = 'default';
        ?>
        <div class="connections row">
            <div class="col-md-12 page-header">
                <h1 class="page-title"><?= __('Events') ?></h1>
                <div class="page-subtitle">You have <?= $events->count() ?> events</div>
            </div>
        </div>
        <nav class="collapse d-lg-flex navbar toolbar page-nav border-bottom p-0">
            <div class="align-items-center px-2">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                    <li class="nav-item"><?= $this->Html->link(__('My Events'), ['action' => 'index'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'default'? ' active':'')]) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Sent Requests'), ['section' => 'sent_requests'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'sent_requests'? ' active':'')]) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Pending Approval'), ['section' => 'pending'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending'? ' active':'')]) ?></li>
                </ul>
            </div>
        </nav>
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
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    </div>
</div>
