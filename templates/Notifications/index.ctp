<?php

use Cake\Utility\Inflector;

?>
<?php $this->start('page_top'); ?>

<?php $this->end(); ?>

<div class="notifications">
    <div class="card">
        <div class="card-body p-4">
            <div class="d-flex">
            <h6 class="card-title"><?= __('Notifications') ?></h6>
            <div class="ml-auto">
                <span class="text-dark">Filter:</span>
                <ul class="d-inline-flex m-0 menu px-0">
                    <li class="nav-item">
                        <?= $this->Html->link('All', [
                            'controller' => 'notifications',
                            'action' => 'index'
                        ]); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link('Unread', [
                            'controller' => 'notifications',
                            'action' => 'unread'
                        ]); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link('Read', [
                            'controller' => 'notifications',
                            'action' => 'read'
                        ]); ?>
                    </li>
                </ul>
            </div>
        </div>
            <div class="toolbar">
                <div class="options">
                    <div class="d-flex">
                        <div class=""></div>
                    </div>
                </div>
            </div>
            <?php if (is_array($notifications) && count($notifications)): ?>
                <div class="e-notifications mx-n3">
                    <div>
                        <div class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                            <?php foreach ($notifications as $notification): ?>
                                <?= $this->element('Notifications/' . h($notification->type), ['notification' =>
                                    $notification]); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="no-data">You have no notification</div>
            <?php endif; ?>
        </div>
    </div>
</div>
