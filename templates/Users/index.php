<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

$layout = $options['layout'] ?? 'users_grid';
$colSize = $options['colSize'] ?? 4;
?>
<?php if ($this->get('page_title')): ?>
    <?php $this->start('page_header'); ?>
    <?= $this->element('App/page_header'); ?>
    <?php $this->end(); ?>
<?php endif; ?>

<div class="users index content py-3">
    <div class="users-list">
        <?php if (isset($users) && count($users)): ?>
        <?= $this->element( 'Users/'.$layout, ['colSize' => $colSize]); ?>
        <?php else: ?>
            <?php if ($this->fetch('ajax_loader')): ?>
                <?= $this->fetch('ajax_loader'); ?>
            <?php else: ?>
                <div class="_Hc0qB9"
                     data-load-type="r"
                     data-src="/people"
                     data-rfc="users"
                     data-su="false"
                     data-limit="24"
                     data-r-ind="false">
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
