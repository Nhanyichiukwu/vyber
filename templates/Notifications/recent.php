<?php
use Cake\Utility\Inflector;
?>
<?php if (count($notifications) > 0): ?>
    <?php foreach ($notifications as $notification): ?>
        <?= $this->element('Notifications/' . h($notification->type), [
            'notification' => $notification
        ]); ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php $this->extend('common'); ?>
