<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Utility\Inflector;

$this->enablePageHeader();
?>
<?php $this->start('header_widget'); ?>
<div id="notification-nav" class="ms-auto">
    <span class="text-dark">Filter:</span>
    <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle"
                data-bs-toggle="dropdown"></button>
        <div class="ix2mbqch dropdown-menu dropdown-menu-bottom dropdown-menu-right
        dropdown-menu-arrow mt-2">
            <?= $this->Html->link('All', [
                'controller' => 'notifications',
                'action' => 'index'
            ],[
                'class' => 'dropdown-item d-flex'
            ]); ?>
            <?= $this->Html->link('Recent', [
                'controller' => 'notifications',
                'action' => 'recent'
            ],[
                'class' => 'dropdown-item d-flex'
            ]); ?>
            <?= $this->Html->link('Unread', [
                'controller' => 'notifications',
                'action' => 'unread'
            ],[
                'class' => 'dropdown-item d-flex'
            ]); ?>
            <?= $this->Html->link('Read', [
                'controller' => 'notifications',
                'action' => 'read'
            ],[
                'class' => 'dropdown-item d-flex'
            ]); ?>
        </div>
    </div>
</div>
<?php $this->end(); ?>
<?php if ($this->fetch('content')): ?>
    <div class="e-notifications">
        <div>
            <div class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                <?= $this->fetch('content'); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="p-3 text-center text-muted-dark">Oops! This list is empty...</div>
<?php endif; ?>
