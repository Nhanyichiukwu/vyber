<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $guests
 */
?>
<div class="guests index content">
    <?= $this->Html->link(__('New Guest'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Guests') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('browser') ?></th>
                    <th><?= $this->Paginator->sort('continent') ?></th>
                    <th><?= $this->Paginator->sort('continent_code') ?></th>
                    <th><?= $this->Paginator->sort('country') ?></th>
                    <th><?= $this->Paginator->sort('country_code') ?></th>
                    <th><?= $this->Paginator->sort('currency_converter') ?></th>
                    <th><?= $this->Paginator->sort('currency_code') ?></th>
                    <th><?= $this->Paginator->sort('currency_symbol') ?></th>
                    <th><?= $this->Paginator->sort('device') ?></th>
                    <th><?= $this->Paginator->sort('ip') ?></th>
                    <th><?= $this->Paginator->sort('last_visit') ?></th>
                    <th><?= $this->Paginator->sort('latitude') ?></th>
                    <th><?= $this->Paginator->sort('longitude') ?></th>
                    <th><?= $this->Paginator->sort('os') ?></th>
                    <th><?= $this->Paginator->sort('region') ?></th>
                    <th><?= $this->Paginator->sort('registered_user_refid') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('timezone') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($guests as $guest): ?>
                <tr>
                    <td><?= $this->Number->format($guest->id) ?></td>
                    <td><?= h($guest->browser) ?></td>
                    <td><?= h($guest->continent) ?></td>
                    <td><?= h($guest->continent_code) ?></td>
                    <td><?= h($guest->country) ?></td>
                    <td><?= h($guest->country_code) ?></td>
                    <td><?= h($guest->currency_converter) ?></td>
                    <td><?= h($guest->currency_code) ?></td>
                    <td><?= h($guest->currency_symbol) ?></td>
                    <td><?= h($guest->device) ?></td>
                    <td><?= h($guest->ip) ?></td>
                    <td><?= h($guest->last_visit) ?></td>
                    <td><?= h($guest->latitude) ?></td>
                    <td><?= h($guest->longitude) ?></td>
                    <td><?= h($guest->os) ?></td>
                    <td><?= h($guest->region) ?></td>
                    <td><?= h($guest->registered_user_refid) ?></td>
                    <td><?= h($guest->state) ?></td>
                    <td><?= h($guest->timezone) ?></td>
                    <td><?= h($guest->created) ?></td>
                    <td><?= h($guest->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $guest->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $guest->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $guest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $guest->id)]) ?>
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
