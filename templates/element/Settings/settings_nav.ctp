<?php 
use Cake\Utility\Inflector;
use Cake\Utility\Text;

//$page = $this->getRequest()->getParam('action');
$page = isset($page) ? Inflector::underscore($page) : 'account';
?>
<div class="settings-nav mb-3">
    <ul class="nav-stacked navbar-nav p-0">
        <li class="e__nav-item <?= $page === 'profile' ? ' active' : '' ?>">
    <?= $this->Html->link(
        __('<span class="has-icon has-label"><i class="mdi mdi-account"></i> Edit Profile</span>'), 
        ['action' => 'profile'],
        [
            'class' => 'align-items-center d-flex justify-content-between nav-link px-3 text-muted',
            'escapeTitle' => false
        ]
    ); ?>
        </li>
        <li class="e__nav-item <?= $page === 'career' ? ' active' : '' ?>">
    <?= $this->Html->link(
        __('<span class="has-icon has-label"><i class="mdi mdi-domain"></i> Career Lines</span>'), 
        ['action' => 'career'],
        [
            'class' => 'align-items-center d-flex justify-content-between nav-link px-3 text-muted',
            'escapeTitle' => false
        ]
    ); ?>
        </li>
        <li class="e__nav-item <?= $page === 'account' ? ' active' : '' ?>">
    <?= $this->Html->link(
        __('<span class="has-icon has-label"><i class="mdi mdi-account"></i> Account</span>'), 
        ['action' => 'account'],
        [
            'class' => 'align-items-center d-flex justify-content-between nav-link px-3 text-muted',
            'escapeTitle' => false
        ]
    ); ?>
        </li>
        <li class="e__nav-item <?= $page === 'location' ? ' active' : '' ?>">
    <?= $this->Html->link(
        __('<span class="has-icon has-label"><i class="mdi mdi-map-marker"></i> Location</span>'), 
        ['action' => 'location'],
        [
            'class' => 'align-items-center d-flex justify-content-between nav-link px-3 text-muted',
            'escapeTitle' => false
        ]
    ); ?>
        </li>
        <li class="e__nav-item <?= $page === 'privacy' ? ' active' : '' ?>">
    <?= $this->Html->link(
        __('<span class="has-icon has-label"><i class="mdi mdi-key"></i> Privacy</span>'), 
        ['action' => 'privacy'],
        [
            'class' => 'align-items-center d-flex justify-content-between nav-link px-3 text-muted',
            'escapeTitle' => false
        ]
    ); ?>
        </li>
        <li class="e__nav-item <?= $page === 'notification' ? ' active' : '' ?>">
    <?= $this->Html->link(
        __('<span class="has-icon has-label"><i class="mdi mdi-bell"></i> Notification</span>'), 
        ['action' => 'notification'],
        [
            'class' => 'align-items-center d-flex justify-content-between nav-link px-3 text-muted',
            'escapeTitle' => false
        ]
    ); ?>
        </li>
        <li class="e__nav-item <?= $page === 'blocking' ? ' active' : '' ?>">
    <?= $this->Html->link(
        __('<span class="has-icon has-label"><i class="mdi mdi-cancel-circle"></i> Blocking</span>'), 
        [
            'action' => 'blocking'
        ],
        [
            'class' => 'align-items-center d-flex justify-content-between nav-link px-3 text-muted',
            'escapeTitle' => false
        ]
    ); ?>
        </li>
        <li class="e__nav-item <?= $page === 'apps' ? ' active' : '' ?>">
    <?= $this->Html->link(
        __('<span class="has-icon has-label"><i class="mdi mdi-account"></i> Apps</span>'), 
        ['action' => 'apps'],
        [
            'class' => 'align-items-center d-flex justify-content-between nav-link px-3 text-muted',
            'escapeTitle' => false
        ]
    ); ?>
        </li>
    </ul>
</div>