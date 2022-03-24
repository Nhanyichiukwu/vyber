<div class="notifications-list new-notifications">
    <?php foreach ($notifications as $notification): ?>
        <?= $this->element('Notifications/' . h($notification->type), [
            'notification' => $notification
        ]); ?>
    <?php endforeach; ?>
</div>
