<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity[]|\Cake\Collection\CollectionInterface $activities
 */
$this->set('showTitleBar', true);
$this->assign(
    'title',
    $this->get(
        'title',
        'Activities'
    )
);
?>
<div class="activities index content">
    <?php foreach ($activities as $activity): ?>
    <div class="activity-list-item">
        <a href="#" class="">
            <!-- Message Start -->
            <div class="media">
                <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                    <h3 class="activity-list-item-title">
                        Brad Diesel
<!--                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>-->
                    </h3>
                    <p class="text-sm"><?= h($activity->get('description')) ?></p>
                    <p class="text-sm text-muted"><i class="mdi mdi-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
        </a>
    </div>
    <?php endforeach; ?>
    <div class="activity-list-item">
        <a href="#" class="">
            <!-- Message Start -->
            <div class="media">
                <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                    <h3 class="activity-list-item-title">
                        John Pierce
                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">I got your message bro</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
        </a>
    </div>
    <div class="activity-list-item">
        <a href="#" class="">
            <!-- Message Start -->
            <div class="media">
                <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                    <h3 class="activity-list-item-title">
                        Nora Silvester
                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">The subject goes here</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
        </a>
    </div>
    <a href="#" class="activity-list-item dropdown-footer">See All Messages</a>
</div>
<div class="activities index content">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('subject') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('actor_refid') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $activity): ?>
                <tr>
                    <td><?= $this->Number->format($activity->id) ?></td>
                    <td><?= h($activity->subject) ?></td>
                    <td><?= h($activity->description) ?></td>
                    <td><?= h($activity->actor_refid) ?></td>
                    <td><?= h($activity->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $activity->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activity->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id)]) ?>
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
