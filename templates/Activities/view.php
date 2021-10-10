<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Activity'), ['action' => 'edit', $activity->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Activity'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Activities'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Activity'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activities view content">
            <h3><?= h($activity->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= h($activity->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($activity->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Actor Refid') ?></th>
                    <td><?= h($activity->actor_refid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($activity->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($activity->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
