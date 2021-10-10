<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group[]|\Cake\Collection\CollectionInterface $groups
 */

use App\Utility\RandomString;

$pageTitle = $this->get('title', 'Groups');
?>
<div class="groups index content">
    <div class="page-header bg-white border-bottom p-3 my-0 mgriukcz">
        <?= $this->Html->link(__('New Group'), [
            'controller' => 'groups',
            'action' => 'new-group'
        ],
        [
            'class' => 'btn btn-secondary btn-sm float-right yy63sy1k',
            'escapeTitle' => false,
            'data-toggle' => 'page',
            'data-page-id' => RandomString::generateString(32, 'mixed', 'alpha'),
            'fullBase' => true
        ]) ?>
        <h3 class="page-title mb-0"><?= __($pageTitle) ?></h3>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('refid') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('group_image') ?></th>
                    <th><?= $this->Paginator->sort('author') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= $this->Number->format($group->id) ?></td>
                    <td><?= h($group->refid) ?></td>
                    <td><?= h($group->name) ?></td>
                    <td><?= h($group->slug) ?></td>
                    <td><?= h($group->group_image) ?></td>
                    <td><?= h($group->author) ?></td>
                    <td><?= h($group->created) ?></td>
                    <td><?= h($group->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $group->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $group->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $group->id], ['confirm' => __('Are you sure you want to delete # {0}?', $group->id)]) ?>
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
