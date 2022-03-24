<?php
/**
 * @var \App\View\AppView $this;
 */
?>
<?php if (is_array($notifications) && count($notifications)): ?>
    <?php foreach ($notifications as $section => $list): ?>
        <div id="<?= $section ?>-notifications" class="section">
            <div class="bg-gray-dark-lightest border-bottom fw-bold px-3 py-2 section-title">
                <?= ucfirst($section) ?>
            </div>
            <?php foreach ($list as $notification): ?>
                <?= $this->element('Notifications/' . h($notificatio->type)); ?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php $this->extend('/Notifications/common'); ?>
